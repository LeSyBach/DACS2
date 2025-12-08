<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Để gửi mail OTP
use Illuminate\Support\Facades\Response; // Để trả về JSON
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Carbon\Carbon; // Để xử lý thời gian hết hạn OTP
use App\Mail\OTPEmail; // Class Mailable bạn đã tạo

class AuthController extends Controller
{
    // --- PHẦN 1: XỬ LÝ ĐĂNG KÝ/ĐĂNG NHẬP/ĐĂNG XUẤT ---

    public function register(Request $request)
    {
        // 1. Validation 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // Thêm validation cho các cột mới nếu cần thiết
            // 'phone' => 'nullable|string|max:20', 
            // 'address' => 'nullable|string|max:255',
        ]);

        // 2. Tạo User trực tiếp trong Controller
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'customer',
            // Thêm các cột mới (nếu bạn muốn lưu chúng khi đăng ký)
            // 'phone' => $request->phone ?? null, 
            // 'address' => $request->address ?? null,
        ]);

        Auth::login($user);
        return redirect()->route('index')->with('success', 'Đăng ký thành công!');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {

            // Tạo session
            $request->session()->regenerate();

            // ⚠️ Không redirect admin nữa!
            // Dù là admin hay user đều vào trang khách hàng
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        // Nếu sai email / mật khẩu
        throw ValidationException::withMessages([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ]);
    }

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Đã đăng xuất thành công!');
    }

    // --- PHẦN 2: QUÊN MẬT KHẨU (FORGOT PASSWORD LOGIC) ---

    // 1. Gửi mã OTP (AJAX POST từ Form 3)
    public function sendOtp(Request $request) 
    {
        // Validation: Nếu lỗi, Laravel tự ném ngoại lệ 422
        $request->validate(['email' => 'required|email|exists:users,email',]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        
        // Lưu OTP và thời gian hết hạn (10 phút)
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); 
        $user->save();

        // Gửi Email (Bỏ comment khi đã cấu hình Mail)
        Mail::to($user->email)->send(new OTPEmail($otp));

        // Trả về JSON để JS chuyển đổi Form 3 -> Form 4
        return Response::json([
            'status' => 'success',
            'message' => 'Đã gửi mã xác nhận OTP vào email của bạn!'
        ], 200);
    }

    // 2. Xử lý Đặt lại Mật khẩu (FINAL RESET - AJAX POST từ Form 4)
    public function resetPassword(Request $request) 
    {
        // 1. Validation (Dùng throw ValidationException để JS bắt được lỗi)
        $request->validate([
            // Bắt buộc phải có input email (cần ẩn trong form)
            'email' => 'required|email|exists:users,email', 
            'otp' => 'required|numeric|digits:6', // Thêm digits:6 để đảm bảo độ dài 6 số
            'password' => 'required|string|min:6|confirmed',
        ], [
             'otp.required' => 'Mã xác nhận không được để trống.',
             'otp.digits' => 'Mã OTP phải có 6 chữ số.',
             'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
             'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
             'email.exists' => 'Email không tồn tại trong hệ thống.'
        ]);

        $user = User::where('email', $request->email)->first(); //

        // 2. Kiểm tra User và OTP
        if (!$user || $user->otp_code != $request->otp) {
            // Trả về lỗi 422: Mã OTP sai
            throw ValidationException::withMessages(['otp' => 'Mã OTP không chính xác.']); //
        }

        // 3. Kiểm tra Hết hạn
        if (\Carbon\Carbon::now()->gt($user->otp_expires_at)) {
            // Trả về lỗi 422: Mã OTP hết hạn
            // Thêm xóa OTP để tránh dùng lại mã hết hạn
            $user->otp_code = null;
            $user->save();
            throw ValidationException::withMessages(['otp' => 'Mã OTP đã hết hạn. Vui lòng gửi lại yêu cầu.']); //
        }

        // 4. Đặt lại mật khẩu và xóa OTP
        $user->password = $request->password; // Laravel tự động Hash nhờ $casts trong Model
        $user->otp_code = null; 
        $user->save(); //

        // 5. Trả về JSON thành công
        return Response::json([
            'status' => 'success',
            'message' => 'Mật khẩu đã được thay đổi thành công! Vui lòng đăng nhập lại.'
        ], 200); //
    }
    
    // --- PHẦN SHOW FORM (Cần thiết cho Route::get) ---
    public function showRegistrationForm() { return view('auth.register'); }
    public function showLoginForm() { return view('auth.login'); }
    public function showLinkRequestForm() { return view('auth.forgot-password'); }
}