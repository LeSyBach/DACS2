<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/products', [ProductController::class, 'index'])->name('product');

// Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/about',function(){
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Search routes
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');




// Route này sẽ gọi file views/product/detail.blade.php
// Route::get('/san-pham/chi-tiet', function () {
//     return view('product.product-detail');
// })->name('product.detail');
Route::get('/san-pham/{id}', [ProductController::class, 'detail'])->name('product.detail');
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

    Route::get('/profile/orders', [UserProfileController::class, 'showOrders'])->name('orders');

    
    // ...



});

// Trang chi tiết đơn hàng (CẦN ID)
Route::get('/profile/orders/{id}', [UserProfileController::class, 'showOrderDetail'])->name('order.detail');
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

Route::post('/payment/zalopay/callback', [CheckoutController::class, 'handleZaloPayCallback']);




// FILE: routes/web.php (Phần Admin)

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\ProductController as AdminProductController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// ==================== ADMIN LOGIN ROUTES ====================

// Route Đăng nhập/Đăng xuất Admin (Không cần Middleware 'admin')
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


// ==================== ADMIN DASHBOARD & CHỨC NĂNG ====================

// CHỈ DÙNG MIDDLEWARE 'auth' MẶC ĐỊNH
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Trang chính Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);
    
    // Quản lý Sản phẩm (CRUD)
    Route::resource('products', AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
        'show' => 'admin.products.show'
    ]);

    Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update', 'destroy'])->names([
        'index' => 'admin.users.index',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // Quản lý Đơn hàng
    Route::resource('orders', AdminOrderController::class)->names([
    'index' => 'admin.orders.index',
    'show' => 'admin.orders.show',
    'destroy' => 'admin.orders.destroy' // <-- THÊM DÒNG NÀY
    ])->except(['create', 'store', 'edit', 'update']); // Chỉ trừ các hàm không cần thiết

    // Route xử lý Cập nhật trạng thái (Giữ nguyên)
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/orders/ajax-search', [\App\Http\Controllers\Admin\OrderController::class, 'ajaxSearch'])
    ->name('admin.orders.ajaxSearch');
});