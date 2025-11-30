<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;

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
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/update/{id}/{action}', [CartController::class, 'update'])->name('cart.update');

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {

    // A. Form Đăng ký/Đăng nhập (GET để hiện Modal nếu JS lỗi)
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email'); //
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); //
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


    // BƯỚC 1: Hiển thị form thông tin
Route::get('/checkout/information', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.show');

// BƯỚC 1.5: Xử lý Thông tin và chuyển sang bước 2 (Payment)
Route::post('/checkout/information', [CheckoutController::class, 'processInformation'])->name('checkout.process_info');

// BƯỚC 2: Hiển thị Form Chọn Phương thức Thanh toán
Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentForm'])->name('checkout.payment');

// BƯỚC 3: Xử lý ĐẶT HÀNG CUỐI CÙNG
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');

// BƯỚC 4: Trang xác nhận/Cảm ơn
Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'thankYou'])->name('checkout.success');


