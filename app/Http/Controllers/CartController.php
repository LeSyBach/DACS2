<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hàm thêm vào giỏ
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        // 1. Logic thêm vào giỏ
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        session()->save(); // Lưu session ngay lập tức

        // 2. Tính tổng số lượng (để cập nhật Icon Header)
        $totalQty = 0;
        foreach($cart as $item) {
            $totalQty += $item['quantity'];
        }
        $countUnique = count($cart);

        // 3. QUAN TRỌNG: Vẽ lại HTML của giỏ hàng mới
        // render() sẽ biến file blade thành chuỗi HTML
        $newCartHTML = view('partials.cart-mini')->render();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Đã thêm vào giỏ hàng thành công!',
            // 'cartCount' => $totalQty,
            'cartCount' => $countUnique,
            'cartHTML'  => $newCartHTML // Gửi đoạn HTML mới này về cho JS
        ]);
    }

        // 1. Hàm Xóa sản phẩm
    public function remove($id){
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $countUnique = count($cart);
            $newCartHTML = view('partials.cart-mini')->render();
            // Trả về dữ liệu JSON để JS xử lý
            return response()->json([
                'status' => 'success',
                'message' => 'Đã xóa sản phẩm!',
                
                'cartCount' => $countUnique,
                'cartHTML'  => $newCartHTML,
                'total' => number_format($this->getCartTotal($cart), 0, ',', '.') . ' ₫',
                // 'count' => count($cart) // Số món còn lại
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
    }

    // 2. Hàm Cập nhật số lượng (+/-)
    public function update(Request $request, $id, $action){
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            // Xử lý tăng giảm
            if($action == 'increase') {
                $cart[$id]['quantity']++;
            } elseif($action == 'decrease') {
                $cart[$id]['quantity']--;
            }

            // Nếu giảm về 0 -> Xóa luôn
            if($cart[$id]['quantity'] < 1) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                
                // Trả về tín hiệu xóa để JS ẩn dòng đó đi
                return response()->json([
                    'status' => 'remove',
                    'total' => $this->getCartTotal($cart),
                    'count' => count($cart) // Số lượng món hàng còn lại
                ]);
            }

            session()->put('cart', $cart);

            // Tính toán lại giá để trả về cho JS
            $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
            $cartTotal = $this->getCartTotal($cart);

            return response()->json([
                'status' => 'update',
                'newQty' => $cart[$id]['quantity'],
                'newPrice' => number_format($itemTotal, 0, ',', '.') . ' ₫',
                'newTotal' => number_format($cartTotal, 0, ',', '.') . ' ₫',
            ]);
        }
    }

    // Hàm phụ để tính tổng tiền (Viết thêm vào trong class CartController)
    private function getCartTotal($cart) {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}