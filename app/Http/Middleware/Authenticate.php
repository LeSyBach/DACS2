<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            // Nếu đang truy cập route admin/* → redirect về admin.login
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }


            
            // Route khách hàng → redirect về trang chủ (modal sẽ tự hiện)
            session()->flash('show_login_modal', true);

            return route('index');
        }

        return null;
    }
}