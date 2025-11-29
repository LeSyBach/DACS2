<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserProfileController;


Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/products', [ProductController::class, 'index'])->name('product');

Route::get('/about',function(){
    return view('about');
})->name('about');
Route::get('/contact',function(){
    return view('contact');
})->name('contact');

// Route này sẽ gọi file views/product/detail.blade.php
// Route::get('/san-pham/chi-tiet', function () {
//     return view('product.product-detail');
// })->name('product.detail');

Route::get('/san-pham/{id}', [ProductController::class, 'detail'])->name('product.detail');


// Route xử lý thêm vào giỏ (Dùng POST cho bảo mật)
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/update/{id}/{action}', [CartController::class, 'update'])->name('cart.update');





use App\Http\Controllers\AuthController;


// ==================== AUTH ROUTES ====================

// Đăng ký
Route::middleware('guest')->group(function () {

    // A. Form Đăng ký/Đăng nhập (GET để hiện Modal nếu JS lỗi)
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // B. QUÊN MẬT KHẨU (Gửi email + Nhập Token/OTP)
    
    // Route 1: Xử lý gửi email (POST Ajax/JSON)
    // Sửa: Đảm bảo tên route khớp với Form trong auth_modal.blade.php
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email'); //

    // Route 2: Xử lý nhập OTP và đặt lại mật khẩu (POST Ajax/JSON)
    // Sửa: Dùng tên route 'password.update' theo convention của Laravel và khớp với Form
    // Sửa: Xóa Route không cần thiết (resetPasswordOtp)
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); //

    // Bổ sung: Route GET để hiển thị Form Quên mật khẩu (khi người dùng truy cập trực tiếp)
    Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request'); //
   
});
Route::middleware('auth')->group(function () {
    
    // 1. Đăng Xuất 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 2. TRANG CÁ NHÂN (PROFILE)
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    // 3. ĐƠN HÀNG CỦA TÔI (ORDERS)
    Route::get('/orders', [UserProfileController::class, 'showOrders'])->name('orders');
    Route::get('/orders/{id}', [UserProfileController::class, 'showOrderDetail'])->name('order.detail');
});

