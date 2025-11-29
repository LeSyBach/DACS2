<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa thông tin người dùng.
     */
    public function edit()
    {
        // Lấy thông tin user hiện tại
        $user = Auth::user(); 
        
        // Trả về view và truyền dữ liệu user
        return view('profile.edit', compact('user'));
    }

    /**
     * Xử lý cập nhật thông tin người dùng, bao gồm Địa chỉ giao hàng.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validation (Chỉ validate thông tin hồ sơ)
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:255', 
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        // 2. Cập nhật dữ liệu
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->email = $request->email;
        
        // Bỏ qua logic mật khẩu
        
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Thông tin và Địa chỉ giao hàng đã được cập nhật thành công!');
    }

    /**
     * Xử lý ĐỔI MẬT KHẨU (KHÔNG CẬP NHẬT HỒ SƠ KHÁC).
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.required' => 'Mật khẩu mới không được để trống.',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $user->password = Hash::make($request->new_password); 
        $user->save();
        // Auth::login($user);
        // Sau khi đổi mật khẩu, đăng xuất user để họ đăng nhập lại bằng mật khẩu mới (Tùy chọn)
        // Auth::logout(); 
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('profile.edit')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    
    /**
     * Hiển thị danh sách đơn hàng của người dùng hiện tại.
     */
    public function showOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10); 
        return view('profile.orders', compact('orders'));
    }

    /**
     * Hiển thị chi tiết một đơn hàng cụ thể.
     */
    public function showOrderDetail($id)
    {
        /** @var \App\Models\User $user */ // Khai báo biến $user là User Model
        $user = Auth::user(); // Gán đối tượng User vào biến $user
        $order = $user->orders()->findOrFail($id); 
        return view('profile.order_detail', compact('order'));
    }
}