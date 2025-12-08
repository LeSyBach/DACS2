<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách tất cả đơn hàng (của TẤT CẢ người dùng).
     */
    // public function index()
    // {
    //     $orders = Order::orderBy('created_at', 'desc')->paginate(15);

    //     return view('admin.orders.index', compact('orders'));
    // }
public function index(Request $request)
{
    $query = Order::orderBy('created_at', 'desc');

    // Lọc theo trạng thái
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Tìm kiếm
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
              ->orWhere('customer_phone', 'like', "%{$search}%")
              ->orWhere('customer_email', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    $orders = $query->paginate(15);

    return view('admin.orders.index', compact('orders'));
}
    

    /**
     * Hiển thị chi tiết một đơn hàng cụ thể.
     */
    public function show(Order $order)
    {
        
        $order->load(['items', 'user']); 
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     * - Khi status = 'completed' => tự động set payment_status = 'paid'
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled'
        ]);

        $newStatus = $request->status;
        
        // Cập nhật trạng thái đơn hàng
        $order->status = $newStatus;
        
        // NẾU chuyển sang "Hoàn thành" => Tự động đánh dấu đã thanh toán
        if ($newStatus === 'completed') {
            $order->payment_status = 'paid';
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công.');
    }

    /**
     * Cập nhật riêng payment_status (nếu cần)
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,unpaid,paid,failed'
        ]);

        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái thanh toán thành công.');
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy(Order $order)
    {
        // Tùy chọn: Nếu bạn không sử dụng ràng buộc khóa ngoại (foreign key cascade) 
        // trong cơ sở dữ liệu, bạn nên xóa các chi tiết đơn hàng trước.
        // $order->items()->delete(); 

        // Thực hiện xóa đơn hàng
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đã xóa đơn hàng thành công.');
    }





// search
    public function ajaxSearch(Request $request)
{
    $query = Order::with('user')->orderBy('created_at', 'desc');

    // Lọc theo trạng thái (CHỈ khi có status được chọn)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Tìm kiếm (trong phạm vi filter đã chọn)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
              ->orWhere('customer_phone', 'like', "%{$search}%")
              ->orWhere('customer_email', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    $orders = $query->paginate(20);

    return response()->json([
        'html' => view('admin.orders.partials.table_rows', compact('orders'))->render(),
        'pagination' => $orders->hasPages() ? $orders->appends($request->query())->links()->render() : null
    ]);
}
}