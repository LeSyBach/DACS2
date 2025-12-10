<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
         // ✅ Kiểm tra Guard 'admin'
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('admin.login')
                ->with('error', 'Vui lòng đăng nhập với tài khoản Admin.');
        }

        return $next($request);
    }
}