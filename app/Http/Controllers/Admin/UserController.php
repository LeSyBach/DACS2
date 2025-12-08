<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Hàm phụ trợ để kiểm tra quyền Admin thủ công
    private function checkAdminPermission()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login');
        }
        return null;
    }

    /**
     * Hiển thị danh sách tất cả người dùng (READ - Index).
     */
    public function index()
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }

        // Lấy tất cả người dùng (trừ Admin hiện tại), sắp xếp theo ID, có phân trang
        $users = User::where('id', '!=', Auth::id()) 
                      ->orderBy('id', 'asc')
                      ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin người dùng (EDIT).
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $user = User::findOrFail($id);
        
        // Ngăn Admin tự sửa tài khoản của chính mình thông qua route này
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Vui lòng sử dụng trang hồ sơ cá nhân để sửa thông tin của bạn.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Xử lý cập nhật thông tin người dùng (UPDATE).
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,customer', // Cho phép Admin thay đổi quyền
            'new_password' => 'nullable|string|min:6|confirmed', // Đổi mật khẩu tùy chọn
        ]);

        $user->fill($validatedData);

        // Cập nhật mật khẩu nếu có
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Đã cập nhật thông tin người dùng thành công.');
    }

    /**
     * Xử lý xóa tài khoản người dùng (DELETE).
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $user = User::findOrFail($id);
        
        // Ngăn không cho Admin tự xóa tài khoản của chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của mình.');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa tài khoản thành công.');
    }
}