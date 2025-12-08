<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Xử lý yêu cầu đến và kiểm tra quyền Admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu chưa đăng nhập HOẶC role không phải 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            
            // Nếu chưa đăng nhập HOẶC không phải Admin, chuyển hướng đến trang đăng nhập Admin.
            // Auth::logout() được đặt ở Login Controller, ở đây chỉ cần chuyển hướng.
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}