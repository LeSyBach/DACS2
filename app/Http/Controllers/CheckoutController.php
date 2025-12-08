<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Services\ZaloPayService; // Đã sẵn sàng cho API

class CheckoutController extends Controller
{
    /**
     * BƯỚC 1: Hiển thị Form Thông tin và Tóm tắt đơn hàng.
     */
    public function showCheckoutForm()
    {
        $cartItems = Auth::check() 
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : session()->get('cart', []);

        if (empty($cartItems) || (is_object($cartItems) && $cartItems->isEmpty()) || count($cartItems) == 0) {
            return redirect()->route('index')->with('error', 'Giỏ hàng của bạn đang trống!'); 
        }

        $defaultData = Auth::check() ? Auth::user() : new User(); 
        $subtotal = $this->calculateCartTotal($cartItems); 

        return view('checkout.information', compact('cartItems', 'defaultData', 'subtotal'));
    }

    /**
     * BƯỚC 1.5: Xử lý thông tin nhận hàng và chuyển sang BƯỚC 2 (Thanh toán).
     */
    public function processInformation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);
        
        session()->put('checkout_info', $validated);

        return redirect()->route('checkout.payment');
    }


    /**
     * BƯỚC 2: Hiển thị Form Chọn Phương thức Thanh toán (ZaloPay và COD).
     */
    public function showPaymentForm()
    {
        if (!session()->has('checkout_info')) {
            return redirect()->route('checkout.show')->with('error', 'Vui lòng nhập thông tin giao hàng trước.');
        }
        
        $cartItems = Auth::check() 
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : session()->get('cart', []);

        $subtotal = $this->calculateCartTotal($cartItems);
        $shippingFee = 30000; 
        
        // Tính Grand Total (Không tính thuế)
        $grandTotal = $subtotal + $shippingFee;

        return view('checkout.payment', compact(
            'cartItems', 
            'subtotal', 
            'shippingFee', 
            'grandTotal'
        ));
    }

    /**
     * BƯỚC 3: Xử lý ĐẶT HÀNG VÀ THANH TOÁN (Lưu vào DB và Xử lý ZaloPay).
     */
    public function placeOrder(Request $request)
{
    $paymentMethod = $request->input('payment_method');
    $checkoutInfo = session()->get('checkout_info');
    $userId = Auth::id();

    // 1. Validation BƯỚC 2
    $request->validate(['payment_method' => 'required|in:cod,zalopay',]);
    
    // 2. Lấy Giỏ hàng (DB hoặc Session)
    $cartItems = $userId 
        ? CartItem::where('user_id', $userId)->with('product')->get()
        : session()->get('cart', []);

    if (empty($cartItems)) {
        return redirect()->route('checkout.show')->with('error', 'Giỏ hàng bị trống!');
    }

    // 3. TÍNH TOÁN GRAND TOTAL (Cho tính toàn vẹn)
    $subtotal = $this->calculateCartTotal($cartItems);
    $shippingFee = 30000; 
    $grandTotal = $subtotal + $shippingFee;

    // 4. Xử lý Transaction
    try {
        DB::beginTransaction();

        // 4.1. TẠO ORDER CHÍNH và Order Items (Chỉ lưu vào DB tạm thời)
        $order = $this->createOrderAndItems($userId, $checkoutInfo, $cartItems, $paymentMethod, $grandTotal);
        
        // 4.2. Xử lý thanh toán ZaloPay (Nếu thất bại, sẽ Rollback)
        if ($paymentMethod === 'zalopay') {
            $zalopayService = new ZaloPayService();
            $zalopayResponse = $zalopayService->createOrderPayment($order); // Gửi API ZaloPay
            
            // 4.3. Kiểm tra phản hồi ZaloPay
            if (isset($zalopayResponse['return_code']) && $zalopayResponse['return_code'] === 1) {
                // THÀNH CÔNG API: Chuyển hướng người dùng đến URL thanh toán
                
                // 4.4. Dọn dẹp Giỏ hàng và Commit DB
                $this->cleanUpCart($userId);
                DB::commit(); 
                
                return redirect()->away($zalopayResponse['order_url']);
            } else {
                // THẤT BẠI API: Rollback DB và giữ lại Giỏ hàng Session
                DB::rollBack(); 
                Log::error('ZaloPay Create Order Failed: ' . ($zalopayResponse['return_message'] ?? 'Unknown API error'));
                return redirect()->route('checkout.payment')->with('error', 'Lỗi kết nối ZaloPay. Vui lòng thử lại hoặc chọn COD.');
            }
        }
        
        // 4.5. XỬ LÝ COD: Hoàn thành, dọn dẹp và Commit
        $this->cleanUpCart($userId);
        DB::commit();
        
        // Hoàn thành cho COD
        return redirect()->route('checkout.success', ['order_id' => $order->id]);

    } catch (\Exception $e) {
        // 5. Xử lý lỗi hệ thống (như lỗi DB, lỗi code)
        DB::rollBack();
        Log::error('Order Placement Failed: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại.');
    }
}

    public function thankYou($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('checkout.success', compact('order'));
    }

    // ====================================================
    // CÁC HÀM PHỤ (HELPERS)
    // ====================================================

    private function calculateCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            if (is_object($item)) { // DB Item
                $price = $item->product->price ?? 0;
                $quantity = $item->quantity;
            } else { // Session Item
                $price = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
            }
            $total += $price * $quantity;
        }
        return $total;
    }

    private function createOrderAndItems($userId, $checkoutInfo, $cartItems, $paymentMethod, $grandTotal)
    {
        // 1. Tạo Order chính (Gán đủ các cột bắt buộc)
        $order = Order::create([
            'user_id' => $userId,
            'customer_name' => $checkoutInfo['name'],
            'customer_phone' => $checkoutInfo['phone'],
            'customer_email' => $checkoutInfo['email'],
            'shipping_address' => $checkoutInfo['address'],
            'payment_method' => $paymentMethod,
            'total_price' => $grandTotal, // <-- LƯU GRAND TOTAL
            'status' => ($paymentMethod === 'cod') ? 'pending' : 'pending_payment', 
            'payment_status' => ($paymentMethod === 'cod') ? 'unpaid' : 'pending',
        ]);

        // 2. Chuyển Cart Items thành Order Items
        $orderItemsData = [];
        foreach ($cartItems as $item) {
            $price = is_object($item) ? ($item->product->price ?? 0) : $item['price'];
            $quantity = is_object($item) ? $item->quantity : $item['quantity'];
            $productId = is_object($item) ? $item->product_id : $item['product_id'];

            // LẤY TÊN SẢN PHẨM: Cần thiết vì cột product_name là NOT NULL
            $productName = is_object($item) 
                ? ($item->product->name ?? 'Sản phẩm không rõ') 
                : ($item['name'] ?? 'Sản phẩm không rõ'); 
            
            $orderItemsData[] = new OrderItem([
                'product_id' => $productId,
                'product_name' => $productName, 
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        // 3. Lưu Order Items
        $order->items()->saveMany($orderItemsData); 

        return $order;
    }

    private function cleanUpCart($userId)
    {
        if ($userId) {
            CartItem::where('user_id', $userId)->delete();
        } else {
            session()->forget('cart');
        }
    }
}