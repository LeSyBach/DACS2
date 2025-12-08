{{-- FILE: resources/views/admin/orders/show.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('content')
    
    {{-- Lớp Bảo vệ Thủ công (Bắt buộc) --}}
    @php
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login'); 
        }
        // Tính toán Tạm tính (Subtotal)
        $shipping_fee = 30000;
        $subtotal = $order->total_price - $shipping_fee; 
    @endphp

    {{-- HEADER VỚI NÚT QUAY LẠI --}}
    <div class="page-header-actions">
        <a href="{{ route('admin.orders.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Quay lại Danh sách
        </a>
    </div>

    <h1 class="admin-page-heading">Chi tiết Đơn hàng #{{ $order->id }}</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="order-detail-layout">
        
        {{-- CỘT BÊN TRÁI: BẢNG SẢN PHẨM VÀ THÔNG TIN --}}
        <div class="order-detail-main">
            
            {{-- THÔNG TIN KHÁCH HÀNG & GIAO HÀNG --}}
            <div class="admin-table-card mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-user-circle"></i>
                    <h3 class="card-title">Thông tin Khách hàng & Giao hàng</h3>
                </div>
                <div class="card-body-custom">
                    <div class="info-grid">
                        <div class="info-item">
                            <label><i class="fas fa-user"></i> Tên Khách hàng:</label>
                            <span>{{ $order->customer_name }}</span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-calendar"></i> Ngày đặt:</label>
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-envelope"></i> Email:</label>
                            <span>{{ $order->customer_email }}</span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-map-marker-alt"></i> Địa chỉ:</label>
                            <span>{{ $order->shipping_address }}</span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-phone"></i> Điện thoại:</label>
                            <span>{{ $order->customer_phone }}</span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-sticky-note"></i> Ghi chú:</label>
                            <span>{{ $order->note ?? 'Không có' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BẢNG SẢN PHẨM CHI TIẾT --}}
            <div class="admin-table-card">
                <div class="card-header-custom">
                    <i class="fas fa-boxes-stacked"></i>
                    <h3 class="card-title">Sản phẩm đã mua</h3>
                </div>
                <div class="card-body-custom p-0">
                    <div class="order-list-table">
                        <table class="table order-table order-detail-table">
                            <thead>
                                <tr>
                                    <th>Tên Sản phẩm</th>
                                    <th>Đơn Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td data-label="Tên SP">{{ $item->product_name }}</td>
                                        <td data-label="Đơn giá" class="price-col">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                        <td data-label="SL">{{ $item->quantity }}</td>
                                        <td data-label="Thành tiền" class="price-col">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tạm tính:</strong></td>
                                    <td class="price-col">{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Phí Vận chuyển:</strong></td>
                                    <td class="price-col">{{ number_format($shipping_fee, 0, ',', '.') }}₫</td>
                                </tr>
                                <tr class="grand-total-row">
                                    <td colspan="3" class="text-right"><strong>TỔNG THANH TOÁN:</strong></td>
                                    <td class="grand-total-price">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        

        {{-- CỘT BÊN PHẢI: TRẠNG THÁI VÀ HÀNH ĐỘNG --}}
        <div class="order-detail-sidebar">
            
            {{-- THÔNG TIN TRẠNG THÁI VÀ THANH TOÁN --}}
            <div class="admin-table-card mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-info-circle"></i>
                    <h3 class="card-title">Trạng thái Đơn hàng</h3>
                </div>
                <div class="card-body-custom">
                    <div class="status-info">
                        <div class="status-item">
                            <label>Trạng thái ĐH:</label>
                            <span class="badge status-{{ $order->status }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </div>
                        <div class="status-item">
                            <label>Trạng thái TT:</label>
                            <span class="badge status-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ strtoupper($order->payment_status) }}
                            </span>
                        </div>
                        <div class="status-item">
                            <label>Phương thức TT:</label>
                            <span class="payment-method">{{ strtoupper($order->payment_method) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CẬP NHẬT TRẠNG THÁI --}}
            <div class="admin-table-card mb-4">
                <div class="card-header-custom card-header-primary">
                    <i class="fas fa-arrows-rotate"></i>
                    <h3 class="card-title">Cập nhật Trạng thái</h3>
                </div>
                <div class="card-body-custom">
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="status" class="form-label">Chuyển Trạng thái:</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </span>
                                <select name="status" id="status" class="form-input" required>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary btn--block mt-3">
                            <i class="fas fa-check"></i> Cập nhật
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- NÚT DUYỆT / HỦY (Chỉ hiện khi đang chờ) --}}
            @if($order->status == 'pending')
                <div class="admin-table-card">
                    <div class="card-header-custom card-header-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3 class="card-title">Hành động</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="action-buttons">
                            {{-- Duyệt hóa đơn (Chuyển sang processing) --}}
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                                @csrf
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="btn btn-success btn--block">
                                    <i class="fas fa-check-circle"></i> Duyệt hóa đơn
                                </button>
                            </form>
                            
                            {{-- Hủy (Chuyển sang cancelled) --}}
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="mt-3">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn--block" onclick="return confirm('Bạn có chắc chắn muốn HỦY đơn hàng này không?')">
                                    <i class="fas fa-times-circle"></i> Hủy đơn hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection