{{-- FILE: resources/views/profile/orders.blade.php --}}
@extends('layouts.app') 

@section('title', 'Đơn hàng của tôi')

@section('content')
    
    <div class="grid wide profile-page-wrapper">
        <div class="row">
            <div class="col c-12 m-12 l-12"> 
                
                <div class="orders-card">
                    
                    <h1 class="main-heading">
                        <i class="fa-solid fa-box"></i>
                        <span>ĐƠN HÀNG CỦA TÔI</span>
                    </h1>
                    
                    {{-- Thông báo --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($orders->isEmpty())
                        {{-- Không có đơn hàng --}}
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h3>Bạn chưa có đơn hàng nào</h3>
                            <p>Hãy bắt đầu mua sắm và trải nghiệm dịch vụ của chúng tôi!</p>
                            <a href="{{ route('product') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Khám phá sản phẩm</span>
                            </a>
                        </div>
                    @else
                        {{-- Filter tabs --}}
                        <div class="order-filter-tabs">
                            <button class="filter-tab active" data-status="all">
                                <i class="fas fa-list"></i>
                                <span>Tất cả</span>
                            </button>
                            <button class="filter-tab" data-status="pending">
                                <i class="fas fa-clock"></i>
                                <span>Chờ xử lý</span>
                            </button>
                            <button class="filter-tab" data-status="processing">
                                <i class="fas fa-box"></i>
                                <span>Đang chuẩn bị</span>
                            </button>
                            <button class="filter-tab" data-status="shipped">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Đang giao</span>
                            </button>
                            <button class="filter-tab" data-status="completed">
                                <i class="fas fa-check-circle"></i>
                                <span>Hoàn thành</span>
                            </button>
                        </div>

                        {{-- Danh sách đơn hàng --}}
                        <div class="order-list-wrapper">
                            @php
                                $statusMap = [
                                    'pending' => ['label' => 'Chờ xử lý', 'icon' => 'clock'],
                                    'processing' => ['label' => 'Đang chuẩn bị', 'icon' => 'box'],
                                    'shipped' => ['label' => 'Đang giao', 'icon' => 'shipping-fast'],
                                    'completed' => ['label' => 'Hoàn thành', 'icon' => 'check-circle'],
                                    'cancelled' => ['label' => 'Đã hủy', 'icon' => 'times-circle'],
                                ];

                                $paymentMap = [
                                    'pending' => 'Chờ thanh toán',
                                    'unpaid' => 'Chưa thanh toán',
                                    'paid' => 'Đã thanh toán',
                                    'failed' => 'Thất bại',
                                ];
                                
                                $paymentMethodMap = [
                                    'cod' => 'COD',
                                    'zalopay' => 'ZaloPay',
                                    'momo' => 'MoMo',
                                ];
                            @endphp

                            @foreach ($orders as $order)
                                @php
                                    $status = $statusMap[$order->status] ?? ['label' => $order->status, 'icon' => 'question'];
                                    $payment = $paymentMap[$order->payment_status] ?? $order->payment_status;
                                    $paymentMethod = $paymentMethodMap[$order->payment_method] ?? strtoupper($order->payment_method);
                                @endphp

                                <div class="order-item-simple" data-status="{{ $order->status }}">
                                    {{-- Header: Mã đơn + Trạng thái --}}
                                    <div class="order-simple-header">
                                        <div class="order-header-left">
                                            <div class="order-id">
                                                <i class="fas fa-receipt"></i>
                                                <span>Đơn hàng #{{ $order->id }}</span>
                                            </div>
                                            <div class="order-date-mobile">
                                                <i class="far fa-calendar"></i>
                                                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="order-header-right">
                                            <span class="badge status-{{ $order->status }}">
                                                <i class="fas fa-{{ $status['icon'] }}"></i>
                                                {{ $status['label'] }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Body: Thông tin chi tiết --}}
                                    <div class="order-simple-body">
                                        {{-- Hàng 1: Thông tin giao hàng --}}
                                        <div class="order-info-grid">
                                            <div class="info-item">
                                                <i class="fas fa-user"></i>
                                                <span class="info-label">Người nhận:</span>
                                                <span class="info-value">{{ $order->customer_name }}</span>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-phone"></i>
                                                <span class="info-label">SĐT:</span>
                                                <span class="info-value">{{ $order->customer_phone }}</span>
                                            </div>
                                            <div class="info-item info-item-full">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="info-label">Địa chỉ:</span>
                                                <span class="info-value">{{ Str::limit($order->shipping_address, 60) }}</span>
                                            </div>
                                        </div>

                                        {{-- Hàng 2: Thông tin đơn hàng --}}
                                        <div class="order-summary-row">
                                            <div class="summary-left">
                                                <div class="summary-item">
                                                    <i class="far fa-calendar"></i>
                                                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                                <div class="summary-item">
                                                    <i class="fas fa-credit-card"></i>
                                                    <span>{{ $paymentMethod }}</span>
                                                </div>
                                                <div class="summary-item">
                                                    <span class="badge payment-{{ $order->payment_status }}">
                                                        {{ $payment }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="summary-right">
                                                <div class="order-total">
                                                    <span class="total-label">Tổng tiền:</span>
                                                    <span class="total-price">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                                                </div>
                                                <div class="order-actions">
                                                    <a href="{{ route('order.detail', $order->id) }}" class="btn-view-detail">
                                                        <i class="fas fa-eye"></i>
                                                        <span>Xem chi tiết</span>
                                                    </a>
                                                    @if($order->status === 'pending')
                                                        <button type="button" class="btn-cancel-order" data-order-id="{{ $order->id }}">
                                                            <i class="fas fa-times-circle"></i>
                                                            <span>Hủy đơn</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Phân trang --}}
                        @if($orders->hasPages())
                            <div class="pagination-wrapper">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Modal xác nhận hủy đơn --}}
    <div id="cancelOrderModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Xác nhận hủy đơn hàng</h3>
                <button class="modal-close" onclick="closeCancelModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng <strong>#<span id="cancelOrderId"></span></strong>?</p>
                <p class="text-warning">Lưu ý: Hành động này không thể hoàn tác!</p>
                <div class="cancel-reason">
                    <label for="cancelReason">Lý do hủy đơn:</label>
                    <textarea id="cancelReason" rows="3" placeholder="Vui lòng cho chúng tôi biết lý do bạn muốn hủy đơn hàng..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeCancelModal()">Đóng</button>
                <button class="btn btn-danger" onclick="confirmCancelOrder()">Xác nhận hủy</button>
            </div>
        </div>
    </div>

    {{-- JavaScript Filter & Cancel Order --}}
    <script>
        let orderIdToCancel = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Filter tabs
            const filterTabs = document.querySelectorAll('.filter-tab');
            const orderItems = document.querySelectorAll('.order-item-simple');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    filterTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    const status = this.getAttribute('data-status');
                    
                    orderItems.forEach(item => {
                        if (status === 'all' || item.getAttribute('data-status') === status) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });

            // Cancel order buttons
            const cancelButtons = document.querySelectorAll('.btn-cancel-order');
            cancelButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    orderIdToCancel = this.getAttribute('data-order-id');
                    document.getElementById('cancelOrderId').textContent = orderIdToCancel;
                    document.getElementById('cancelOrderModal').style.display = 'flex';
                });
            });
        });

        function closeCancelModal() {
            document.getElementById('cancelOrderModal').style.display = 'none';
            document.getElementById('cancelReason').value = '';
            orderIdToCancel = null;
        }

        function confirmCancelOrder() {
            if (!orderIdToCancel) {
                console.error('No order ID to cancel');
                return;
            }

            const reason = document.getElementById('cancelReason').value;
            const url = `{{ url('/order') }}/${orderIdToCancel}/cancel`;
            console.log('Cancelling order:', orderIdToCancel, 'URL:', url, 'Reason:', reason);

            // Gửi AJAX request
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Đã hủy đơn hàng thành công!', 'success');
                    } else {
                        alert(data.message || 'Đã hủy đơn hàng thành công!');
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Có lỗi xảy ra!', 'error');
                    } else {
                        alert(data.message || 'Có lỗi xảy ra!');
                    }
                }
                closeCancelModal();
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof showToast === 'function') {
                    showToast('Có lỗi xảy ra khi hủy đơn hàng!', 'error');
                } else {
                    alert('Có lỗi xảy ra khi hủy đơn hàng!');
                }
                closeCancelModal();
            });
        }
    </script>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/oder.css') }}">
@endpush