<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // --- TỰ ĐỘNG TÍNH GIỎ HÀNG CHO TOÀN BỘ WEBSITE ---
        View::composer('*', function ($view) {
            // 1. Lấy giỏ hàng
            $cart = Session::get('cart', []);
            
            $totalPrice = 0;
            $totalQty = 0;

            // 2. Tính toán
            if(is_array($cart)) {
                foreach ($cart as $item) {
                    if(isset($item['price']) && isset($item['quantity'])) {
                        $totalPrice += $item['price'] * $item['quantity'];
                        $totalQty += $item['quantity'];
                    }
                }
            }
            $cartCount=count($cart);

            // 3. Chia sẻ biến sang TẤT CẢ các View
            // Bạn có thể dùng $cart, $cartTotal, $cartCount ở bất cứ file blade nào
            $view->with([
                'cart' => $cart,
                'cartTotal' => $totalPrice,
                // 'cartCount' => $totalQty,
                'cartCount' => $cartCount
            ]);
        });
    }
}