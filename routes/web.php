<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('index');

// Route tạo symlink cho hosting không có CLI
// Truy cập: http://yoursite.com/setup-storage
Route::get('/setup-storage', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    
    if (file_exists($link) && is_link($link)) {
        return 'Symlink đã tồn tại!';
    }
    
    try {
        // Thử tạo symlink trước
        if (!file_exists($link)) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $command = 'mklink /J "' . $link . '" "' . $target . '"';
                exec($command, $output, $return);
                if ($return === 0) {
                    return 'Symlink đã được tạo thành công!';
                }
            } else {
                if (@symlink($target, $link)) {
                    return 'Symlink đã được tạo thành công!';
                }
            }
        }
        
        // Nếu không tạo được symlink, copy file
        if (!file_exists($link)) {
            mkdir($link, 0755, true);
        }
        
        // Copy tất cả file từ storage/app/public sang public/storage
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($target, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        $count = 0;
        foreach ($files as $file) {
            $targetPath = $link . '/' . substr($file->getPathname(), strlen($target) + 1);
            if ($file->isDir()) {
                if (!file_exists($targetPath)) {
                    mkdir($targetPath, 0755, true);
                }
            } else {
                copy($file->getPathname(), $targetPath);
                $count++;
            }
        }
        
        return "Không thể tạo symlink, đã copy {$count} files. LƯU Ý: Mỗi khi upload ảnh mới phải chạy lại route này!";
    } catch (\Exception $e) {
        return 'Lỗi: ' . $e->getMessage();
    }
});

// Sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('product');

// Giới thiệu
Route::get('/about', function () {
    return view('about');
})->name('about');

// Liên hệ
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Tìm kiếm
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Chi tiết sản phẩm
Route::get('/san-pham/{id}', [ProductController::class, 'detail'])->name('product.detail');

// Giỏ hàng
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/update/{id}/{action}', [CartController::class, 'update'])->name('cart.update');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
//Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
//});

Route::middleware('auth')->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    // Đơn hàng của tôi
    Route::get('/orders', [UserProfileController::class, 'showOrders'])->name('orders');
    Route::get('/orders/{id}', [UserProfileController::class, 'showOrderDetail'])->name('order.detail');
    Route::post('/order/{id}/cancel', [UserProfileController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/profile/orders', [UserProfileController::class, 'showOrders'])->name('orders');
});

// Trang chi tiết đơn hàng (profile)
Route::get('/profile/orders/{id}', [UserProfileController::class, 'showOrderDetail'])->name('order.detail');

/*
|--------------------------------------------------------------------------
| CHECKOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/checkout/information', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.show');
Route::post('/checkout/information', [CheckoutController::class, 'processInformation'])->name('checkout.process_info');
Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentForm'])->name('checkout.payment');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');
Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'thankYou'])->name('checkout.success');

// Callback ZaloPay
Route::post('/payment/zalopay/callback', [CheckoutController::class, 'handleZaloPayCallback']);

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\ProductController as AdminProductController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductVariantController;

// Admin Login
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin Dashboard & chức năng
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->group(function () {

    // Quản lý variants
    Route::get('products/{product}/variants', [ProductVariantController::class, 'index'])->name('admin.products.variants.index');
    Route::get('products/{product}/variants/list', [ProductVariantController::class, 'list'])->name('admin.products.variants.list');
    Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])->name('admin.products.variants.store');
    Route::delete('products/{product}/variants/{variant}', [ProductVariantController::class, 'destroy'])->name('admin.products.variants.destroy');
    Route::put('products/{product}/variants/{variant}', [ProductVariantController::class, 'update'])->name('admin.products.variants.update');
    Route::post('products/{product}/variants/{variant}/set-default', [ProductVariantController::class, 'setDefault'])->name('admin.products.variants.setDefault');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Categories
    Route::resource('categories', CategoryController::class)->names([
        'index'   => 'admin.categories.index',
        'create'  => 'admin.categories.create',
        'store'   => 'admin.categories.store',
        'edit'    => 'admin.categories.edit',
        'update'  => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Products
    Route::resource('products', AdminProductController::class)->names([
        'index'   => 'admin.products.index',
        'create'  => 'admin.products.create',
        'store'   => 'admin.products.store',
        'edit'    => 'admin.products.edit',
        'update'  => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
        'show'    => 'admin.products.show',
    ]);

    // Users
    Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update', 'destroy'])->names([
        'index'   => 'admin.users.index',
        'edit'    => 'admin.users.edit',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Orders
    Route::resource('orders', AdminOrderController::class)
        ->names([
            'index'   => 'admin.orders.index',
            'show'    => 'admin.orders.show',
            'destroy' => 'admin.orders.destroy',
        ])
        ->except(['create', 'store', 'edit', 'update']);

    // Update status
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/orders/ajax-search', [AdminOrderController::class, 'ajaxSearch'])->name('admin.orders.ajaxSearch');
});