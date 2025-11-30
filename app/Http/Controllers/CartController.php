<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\CartItem; // Cần thiết
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; // Cần thiết để kiểm tra View có dữ liệu

class CartController extends Controller
{
    // === HÀM CHÍNH: THÊM VÀO GIỎ HÀNG ===
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // --- HÀM CHO USER ĐÃ ĐĂNG NHẬP (Lưu vào DB) ---
        if (Auth::check()) {
            $user = Auth::user();
            
            // A. CHUYỂN ĐỔI SESSION SANG DB (Nếu tồn tại Session)
            if (session()->has('cart')) {
                $this->migrateSessionCartToDb($user);
            }
            
            // B. Thêm/Cập nhật mục hiện tại vào DB
            CartItem::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $id],
                ['quantity' => DB::raw('quantity + ' . $quantity)] 
            );
            
            // C. LẤY DỮ LIỆU GIỎ HÀNG DB MỚI NHẤT
            // Phải dùng with('product') để lấy thông tin sản phẩm
            $cartItemsDb = CartItem::where('user_id', $user->id)
                                    ->with('product') 
                                    ->get();

            $countUnique = $cartItemsDb->count();

            // QUAN TRỌNG: TRUYỀN DỮ LIỆU DB VÀO VIEW
            $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cartItemsDb])->render(); 

            return response()->json([
                'status'    => 'success',
                'message'   => 'Đã thêm vào giỏ hàng thành công!',
                'cartCount' => $countUnique,
                'cartHTML'  => $newCartHTML 
            ]);
        } 
        
        // --- HÀM CHO KHÁCH VÃNG LAI (Lưu vào Session) ---
        else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                // Giữ lại thông tin cần thiết cho Session
                $cart[$id] = [
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "image" => $product->image,
                    "product_id" => $id, 
                ];
            }

            session()->put('cart', $cart);
            session()->save(); 

            // QUAN TRỌNG: TRUYỀN DỮ LIỆU SESSION VÀO VIEW
            $countUnique = count($cart);
            $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cart])->render();
            
            return response()->json([
                'status'    => 'success',
                'message'   => 'Đã thêm vào giỏ hàng thành công!',
                'cartCount' => $countUnique,
                'cartHTML'  => $newCartHTML 
            ]);
        }
    }

    // === HÀM PHỤ: DI CHUYỂN SESSION VÀO DB ===
    protected function migrateSessionCartToDb($user) 
    {
        $sessionCart = session()->get('cart', []);
        foreach ($sessionCart as $productId => $item) {
            $quantity = $item['quantity'];
            CartItem::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $productId],
                ['quantity' => DB::raw('quantity + ' . $quantity)] 
            );
        }
        session()->forget('cart');
    }


    // === HÀM XÓA SẢN PHẨM ===
    public function remove($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            CartItem::where('user_id', $user->id)->where('product_id', $id)->delete();
            
            // Lấy lại dữ liệu mới từ DB để render lại View
            $cartItemsDb = CartItem::where('user_id', $user->id)->with('product')->get();
            $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cartItemsDb])->render(); 
            $countUnique = $cartItemsDb->count();

            return response()->json([
                'status' => 'success', 
                'message' => 'Đã xóa sản phẩm khỏi DB!',
                'cartCount' => $countUnique,
                'cartHTML'  => $newCartHTML,
                // Cần hàm tính tổng tiền từ DB nếu cần
            ]);
        } else {
            // Logic cũ cho Session (Giữ nguyên)
            // ...
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                $countUnique = count($cart);
                $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cart])->render();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đã xóa sản phẩm!',
                    'cartCount' => $countUnique,
                    'cartHTML'  => $newCartHTML,
                    'total' => number_format($this->getCartTotal($cart), 0, ',', '.') . ' ₫',
                ]);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
    }

    // === HÀM CẬP NHẬT SỐ LƯỢNG (+/-) ===
    public function update(Request $request, $id, $action)
    {
        // Logic cập nhật số lượng cũng phải được tách theo Session và DB
        if (Auth::check()) {
            $user = Auth::user();

            // Lấy cartItem theo user và product_id
            $cartItem = CartItem::where('user_id', $user->id)
                                ->where('product_id', $id)
                                ->with('product')
                                ->first();

            if ($cartItem) {
                // Tăng hoặc giảm số lượng
                if ($action === 'increase') {
                    $cartItem->quantity++;
                } elseif ($action === 'decrease') {
                    $cartItem->quantity--;
                }

                // Nếu số lượng < 1 thì xóa sản phẩm khỏi giỏ
                if ($cartItem->quantity < 1) {
                    $cartItem->delete();

                    // Tính lại tổng tiền sau khi xóa
                    $cartItemsDb = CartItem::where('user_id', $user->id)->with('product')->get();
                    $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cartItemsDb])->render();
                    $cartTotal = CartItem::where('user_id', $user->id)
                                        ->with('product')
                                        ->get()
                                        ->sum(fn($item) => $item->product->price * $item->quantity);

                    return response()->json([
                        'status' => 'remove',
                        'total'  => number_format($cartTotal, 0, ',', '.') . ' ₫',
                        'count'  => CartItem::where('user_id', $user->id)->count(),
                        // 'count'  => $cartItemsDb->count(),
                        'cartHTML' => $newCartHTML,

                        
                    ]);
                }

                // Lưu lại số lượng mới
                $cartItem->save();

                // Tính lại giá sản phẩm và tổng giỏ hàng
                $itemTotal = $cartItem->product->price * $cartItem->quantity;
                $cartTotal = CartItem::where('user_id', $user->id)
                                    ->with('product')
                                    ->get()
                                    ->sum(fn($item) => $item->product->price * $item->quantity);

                return response()->json([
                    'status'   => 'update',
                    'newQty'   => $cartItem->quantity,
                    'newPrice' => number_format($itemTotal, 0, ',', '.') . ' ₫',
                    'newTotal' => number_format($cartTotal, 0, ',', '.') . ' ₫',
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ]);
        } else {
            // Logic cũ cho Session (Giữ nguyên)
            $cart = session()->get('cart');
            // ... (Phần logic cập nhật Session cũ của bạn) ...
            if(isset($cart[$id])) {
                if($action == 'increase') {
                    $cart[$id]['quantity']++;
                } elseif($action == 'decrease') {
                    $cart[$id]['quantity']--;
                }
                if($cart[$id]['quantity'] < 1) {
                    unset($cart[$id]);
                    session()->put('cart', $cart);

                    $newCartHTML = View::make('partials.cart-mini', ['cartData' => $cart])->render();
                    return response()->json([
                        'status' => 'remove',
                        'total' => $this->getCartTotal($cart),
                        'count' => count($cart),
                        'cartHTML' => $newCartHTML,

                    ]);
                }
                session()->put('cart', $cart);
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
    }

    // Hàm phụ để tính tổng tiền (Giữ nguyên)
    private function getCartTotal($cart) {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}