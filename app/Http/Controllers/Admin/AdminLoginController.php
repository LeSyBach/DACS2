<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Hiển thị Form Đăng nhập Admin.
     */
    public function showLoginForm()
    {
        // Kiểm tra nếu Admin đã đăng nhập, chuyển hướng thẳng đến Dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Trả về view login riêng của Admin
        return view('admin.login'); 
    }

    /**
     * Xử lý Đăng nhập Admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Cố gắng đăng nhập bằng GUARD 'web' mặc định
        if (Auth::attempt($credentials, $request->has('remember'))) {
            
            $user = Auth::user(); 
            
            // 2. KIỂM TRA QUYỀN HẠN BẮT BUỘC (Kiểm tra cột role)
            if ($user->role !== 'admin') {
                
                // Nếu User có email/mật khẩu đúng nhưng KHÔNG phải admin
                Auth::logout(); // Đăng xuất NGAY LẬP TỨC
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Chuyển hướng về trang đăng nhập khách hàng (An toàn hơn) và dùng session flash
                // return redirect()->route('login')->with('error', 'Bạn không có quyền quản trị viên.');
                return back()->with('error', 'Bạn không có quyền truy cập admin.');

            }
            
            // 3. Nếu là Admin, chuyển hướng đến Dashboard
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard')); 
        }

        // Đăng nhập thất bại (sai email/mật khẩu)
        throw ValidationException::withMessages([
            'email' => 'Thông tin đăng nhập không hợp lệ.'
        ]);
    }

    /**
     * Hàm Đăng xuất Admin.
     */
    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất khu vực quản trị.');
    }
}