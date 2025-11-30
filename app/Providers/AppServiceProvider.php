<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // =======================================================
        // LOGIC CHUNG: TÍNH TOÁN GIỎ HÀNG (Cho cả Header và Modal)
        // =======================================================
        View::composer(['layouts.app', 'header', 'partials.header', 'partials.cart-mini'], function ($view) {
            
            $cartData = [];
            $cartTotal = 0;
            $cartCount = 0;

            if (Auth::check()) {
                // 1. NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP (LẤY TỪ DB)
                $user = Auth::user();
                
                // Lấy Cart Items từ DB (kèm thông tin sản phẩm cho Modal)
                $cartData = CartItem::where('user_id', $user->id)
                                    ->with('product')
                                    ->get(); 
                                    
                if ($cartData->isNotEmpty()) {
                    $cartCount = $cartData->count();
                    
                    // Tính toán tổng tiền từ DB
                    foreach ($cartData as $item) {
                        $price = $item->product->price ?? 0;
                        $cartTotal += $price * $item->quantity;
                    }
                }
            } else {
                // 2. KHÁCH VÃNG LAI (LẤY TỪ SESSION)
                $cartData = Session::get('cart', []);
                
                if(is_array($cartData)) {
                    $cartCount = count($cartData);
                    
                    // Tính toán tổng tiền từ Session
                    foreach ($cartData as $item) {
                        if(isset($item['price']) && isset($item['quantity'])) {
                            $cartTotal += $item['price'] * $item['quantity'];
                        }
                    }
                }
            }
            
            // =======================================================
            // CHIA SẺ BIẾN CHO TẤT CẢ CÁC VIEW MỤC TIÊU
            // =======================================================
            $view->with([
                'cartData' => $cartData,
                'cartTotal' => $cartTotal,
                'cartCount' => $cartCount // Biến này sẽ fix lỗi mất số lượng trên Header
            ]);
        });
        
        // Xóa Composer cũ không cần thiết (chỉ dùng để share View::shared)
        /*
        View::composer(['partials.header', 'layouts.app'], function ($view) {
             $view->with('cartCount', View::shared('cartCount', 0)); 
        });
        */
    }
}