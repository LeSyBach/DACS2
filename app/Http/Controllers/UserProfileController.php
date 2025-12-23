<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Order;

class UserProfileController extends Controller
{
    public function edit()
    {
        // Lấy thông tin user hiện tại
        $user = Auth::user(); 
        // Trả về view và truyền dữ liệu user
        return view('profile.edit', compact('user'));
    }

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


    public function showOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10); 
        return view('profile.orders', compact('orders'));
    }

    public function showOrderDetail($id)
    {
        /** @var \App\Models\User $user */ 
        $user = Auth::user(); 
        
        // BỔ SUNG with('items') để tải chi tiết sản phẩm
        $order = $user->orders()
                    ->with('items') // Tải chi tiết các sản phẩm trong đơn hàng
                    ->findOrFail($id); 
        
        return view('profile.order_detail', compact('order'));
    }

    /**
     * Hủy đơn hàng (chỉ được phép khi status = pending)
     */
    public function cancelOrder(Request $request, $id)
    {
        try {
            Log::info('Cancel order request', [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'reason' => $request->reason
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Tìm đơn hàng của user
            $order = $user->orders()->findOrFail($id);
            
            Log::info('Order found', [
                'order_id' => $order->id,
                'current_status' => $order->status
            ]);
            
            // Kiểm tra trạng thái đơn hàng
            if ($order->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng đã được xác nhận!'
                ], 400);
            }
            
            // Cập nhật trạng thái thành cancelled
            $order->status = 'cancelled';
            
            // Lưu lý do hủy nếu có
            if ($request->has('reason') && !empty($request->reason)) {
                $order->note = ($order->note ? $order->note . "\n\n" : '') . 'Lý do hủy: ' . $request->reason;
            }
            
            $order->save();
            
            Log::info('Order cancelled successfully', ['order_id' => $order->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã hủy đơn hàng #' . $order->id . ' thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error cancelling order', [
                'order_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }


    
}