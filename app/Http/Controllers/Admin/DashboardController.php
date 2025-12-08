<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Category; // <-- CẦN IMPORT MODEL CATEGORY
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Cần dùng cho các hàm aggregate

class DashboardController extends Controller
{
    /**
     * Hiển thị trang chính Admin Dashboard với các số liệu thống kê.
     */
    public function index()
    {

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login'); 
        }
        $today = Carbon::today();

        // 1. TRUY VẤN DỮ LIỆU THỐNG KÊ CƠ BẢN
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Giả định bạn có biến $orders (Hoặc $recentOrders) cho bảng bên dưới
        $orders = Order::with('user')->latest()->take(10)->get();

        
        // 2. LOGIC BỔ SUNG: THỐNG KÊ DANH MỤC SẢN PHẨM (DYNAMIC)
        // Lấy tất cả danh mục và đếm số lượng sản phẩm trong từng danh mục
        $categoryStats = Category::select('name')
            ->withCount('products') // Giả định Model Category có quan hệ products()
            ->get();
        
        // 3. Truyền dữ liệu thống kê sang View
        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalRevenue', 
            'totalCustomers', 
            'pendingOrders',
            'orders', // Đơn hàng gần đây
            'categoryStats' // Thống kê danh mục động
        )); 
    }
}