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


class CheckoutController extends Controller
{
    /**
     * BƯỚC 1: Hiển thị Form Thông tin và Tóm tắt đơn hàng.
     */
    public function showCheckoutForm()
    {
        // 1. Lấy Giỏ hàng (DB nếu đăng nhập, Session nếu là khách)
        $cartItems = Auth::check() 
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : session()->get('cart', []);

        if (empty($cartItems) || (is_object($cartItems) && $cartItems->isEmpty()) || count($cartItems) == 0) {
            // Chuyển hướng về trang giỏ hàng (nếu bạn có route này)
            return redirect()->route('index')->with('error', 'Giỏ hàng của bạn đang trống!'); 
        }

        // 2. Lấy thông tin khách hàng mặc định (điền sẵn form)
        // Nếu không đăng nhập, tạo một User rỗng để tránh lỗi truy cập thuộc tính
        $defaultData = Auth::check() ? Auth::user() : new User(); 

        // 3. Tính tổng tiền cho View Summary
        $total = $this->calculateCartTotal($cartItems); 

        return view('checkout.information', compact('cartItems', 'defaultData', 'total'));
    }

    /**
     * BƯỚC 1.5: Xử lý thông tin nhận hàng và chuyển sang BƯỚC 2 (Thanh toán).
     */
    public function processInformation(Request $request)
    {
        // 1. Validation Thông tin
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);
        
        // 2. Lưu tạm thông tin vào session để sử dụng ở bước 2
        session()->put('checkout_info', $validated);

        return redirect()->route('checkout.payment');
    }


    /**
     * BƯỚC 2: Hiển thị Form Chọn Phương thức Thanh toán (ZaloPay và COD).
     */
    public function showPaymentForm()
    {
        // Đảm bảo thông tin nhận hàng đã có trong session
        if (!session()->has('checkout_info')) {
            return redirect()->route('checkout.show')->with('error', 'Vui lòng nhập thông tin giao hàng trước.');
        }
        
        // Lấy lại giỏ hàng để hiển thị tóm tắt
        $cartItems = Auth::check() 
            ? CartItem::where('user_id', Auth::id())->with('product')->get()
            : session()->get('cart', []);

        // 1. Tính tổng tiền Tạm tính (Subtotal)
        $subtotal = $this->calculateCartTotal($cartItems);

        // 2. Định nghĩa các phí/thuế (Bạn có thể sửa số này theo logic kinh doanh của mình)
        $shippingFee = 30000; // Phí vận chuyển cố định 30,000 ₫ (Ví dụ)
        $taxRate = 0.10;      // Thuế GTGT 10% (Ví dụ)

        // 3. Tính toán Thuế GTGT
        // Thuế được tính trên (Tạm tính + Phí vận chuyển)
        $vat = ($subtotal + $shippingFee) * $taxRate;

        // 4. Tính Tổng tiền cuối cùng cần thanh toán (Grand Total)
        $grandTotal = $subtotal + $shippingFee + $vat;

        // 5. Truyền tất cả các biến cần thiết sang view
        return view('checkout.payment', compact(
            'cartItems', 
            'subtotal', 
            'shippingFee', 
            'vat', 
            'grandTotal' // <--- BIẾN QUAN TRỌNG NHẤT
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
        $request->validate([
            'payment_method' => 'required|in:cod,zalopay',
        ]);
        
        // 2. Lấy Giỏ hàng (DB hoặc Session)
        $cartItems = $userId 
            ? CartItem::where('user_id', $userId)->with('product')->get()
            : session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('checkout.show')->with('error', 'Giỏ hàng bị trống!');
        }

        // 3. Xử lý Transaction
        try {
            DB::beginTransaction();

            // Tính tổng tiền và tạo Order Items
            $order = $this->createOrderAndItems($userId, $checkoutInfo, $cartItems, $paymentMethod);
            
            // 4. Dọn dẹp Giỏ hàng
            $this->cleanUpCart($userId);
            
            DB::commit();

            // 5. Xử lý thanh toán ZaloPay
            if ($paymentMethod === 'zalopay') {
                // (Chức năng gọi API ZaloPay và chuyển hướng sẽ được đặt tại đây)
                // Hiện tại, chúng ta chỉ chuyển hướng đến trang Thành công
                return redirect()->route('checkout.success', ['order_id' => $order->id]);
            }
            
            // 6. Hoàn thành cho COD
            return redirect()->route('checkout.success', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Placement Failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại.');
        }
    }

    /**
     * BƯỚC 4: Trang Xác nhận/Cảm ơn
     */
    public function thankYou($order_id)
    {
        // Lấy đơn hàng và truyền sang View
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

    private function createOrderAndItems($userId, $checkoutInfo, $cartItems, $paymentMethod)
    {
        $totalAmount = 0;
        
        // 1. Tạo Order chính
        $order = Order::create([
            'user_id' => $userId,
            'customer_name' => $checkoutInfo['name'],
            'customer_phone' => $checkoutInfo['phone'],
            'customer_email' => $checkoutInfo['email'],
            'shipping_address' => $checkoutInfo['address'],
            'payment_method' => $paymentMethod,
            'total_price' => 0, 
            'status' => ($paymentMethod === 'cod') ? 'pending' : 'pending_payment', 
            'payment_status' => ($paymentMethod === 'cod') ? 'unpaid' : 'pending',
        ]);

        // 2. Chuyển Cart Items thành Order Items và tính tổng tiền
        $orderItemsData = [];
        foreach ($cartItems as $item) {
            // Lấy dữ liệu cho DB Item hay Session Item
            $price = is_object($item) ? ($item->product->price ?? 0) : $item['price'];
            $quantity = is_object($item) ? $item->quantity : $item['quantity'];
            $productId = is_object($item) ? $item->product_id : $item['product_id'];

            $totalAmount += $price * $quantity;
            
            $orderItemsData[] = new OrderItem([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        // 3. Lưu Order Items và cập nhật tổng tiền
        $order->items()->saveMany($orderItemsData); 
        $order->update(['total_price' => $totalAmount]); 

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