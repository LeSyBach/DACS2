{{-- FILE: resources/views/profile/order_detail.blade.php --}}
@extends('layouts.app') 

@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('content')
    
    <div class="grid wide customer-order-wrapper">
        <div class="row">
            <div class="col c-12 m-12 l-12"> 
                
                <div class="customer-order-detail-card">
                    
                    <div class="customer-detail-header">
                        <h1 class="customer-order-heading">
                            <i class="fa-solid fa-receipt"></i> CHI TIẾT ĐƠN HÀNG #{{ $order->id }}
                        </h1>
                        
                        <a href="{{ route('orders') }}" class="customer-btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    @php
                        $orderStatusMap = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang chuẩn bị',
                            'shipped' => 'Đang giao',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy',
                        ];

                        $paymentStatusMap = [
                            'pending' => 'Chờ thanh toán',
                            'unpaid' => 'Chưa thanh toán',
                            'paid' => 'Đã thanh toán',
                            'failed' => 'Thất bại',
                        ];

                        $paymentMethodMap = [
                            'cod' => 'Thanh toán khi nhận hàng (COD)',
                            'zalopay' => 'ZaloPay',
                        ];

                        $getTranslated = function ($key, $map) {
                            return $map[$key] ?? strtoupper($key);
                        };

                        $orderStatusKey = $order->status;
                        $paymentStatusKey = $order->payment_status;
                        $paymentMethodKey = $order->payment_method;
                        
                        $shippingFee = 30000;
                        $subtotal = $order->total_price - $shippingFee;
                    @endphp

                    {{-- TRACKING STATUS --}}
                    <div class="customer-order-tracking">
                        <div class="customer-tracking-step {{ in_array($orderStatusKey, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <div class="customer-step-icon"><i class="fas fa-clipboard-check"></i></div>
                            <div class="customer-step-label">Đã đặt</div>
                        </div>
                        <div class="customer-tracking-step {{ in_array($orderStatusKey, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <div class="customer-step-icon"><i class="fas fa-box"></i></div>
                            <div class="customer-step-label">Chuẩn bị</div>
                        </div>
                        <div class="customer-tracking-step {{ in_array($orderStatusKey, ['shipped', 'completed']) ? 'active' : '' }}">
                            <div class="customer-step-icon"><i class="fas fa-shipping-fast"></i></div>
                            <div class="customer-step-label">Đang giao</div>
                        </div>
                        <div class="customer-tracking-step {{ $orderStatusKey === 'completed' ? 'active' : '' }}">
                            <div class="customer-step-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="customer-step-label">Hoàn thành</div>
                        </div>
                    </div>

                    {{-- THÔNG TIN ĐƠN HÀNG --}}
                    <div class="customer-detail-section">
                        <div class="row">
                            <div class="col c-12 m-6 l-6">
                                <div class="customer-info-box">
                                    <h2 class="customer-section-title">
                                        <i class="fas fa-info-circle"></i> Thông tin đơn hàng
                                    </h2>
                                    <div class="customer-info-content">
                                        <div class="customer-info-row">
                                            <label><i class="far fa-calendar"></i> Ngày đặt:</label>
                                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-credit-card"></i> Thanh toán:</label>
                                            <span>{{ $getTranslated($paymentMethodKey, $paymentMethodMap) }}</span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-box"></i> Trạng thái:</label>
                                            <span class="customer-badge customer-status-{{ $orderStatusKey }}">
                                                {{ $getTranslated($orderStatusKey, $orderStatusMap) }}
                                            </span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-money-bill-wave"></i> TT Thanh toán:</label>
                                            <span class="customer-badge customer-payment-{{ $paymentStatusKey }}">
                                                {{ $getTranslated($paymentStatusKey, $paymentStatusMap) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col c-12 m-6 l-6">
                                <div class="customer-info-box">
                                    <h2 class="customer-section-title">
                                        <i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng
                                    </h2>
                                    <div class="customer-info-content">
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-user"></i> Người nhận:</label>
                                            <span>{{ $order->customer_name }}</span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-phone"></i> Điện thoại:</label>
                                            <span>{{ $order->customer_phone }}</span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-envelope"></i> Email:</label>
                                            <span>{{ $order->customer_email }}</span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-map-marked-alt"></i> Địa chỉ:</label>
                                            <span>{{ $order->shipping_address }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- CHI TIẾT SẢN PHẨM --}}
                    {{-- CHI TIẾT SẢN PHẨM & TỔNG KẾT - LAYOUT 2 CỘT --}}
<div class="customer-detail-section">
    <h2 class="customer-section-title">
        <i class="fas fa-shopping-bag"></i> Sản phẩm đã mua
    </h2>
    
    <div class="customer-products-summary-wrapper">
        {{-- Cột trái: Danh sách sản phẩm --}}
        <div class="customer-products-list">
            @foreach($order->items as $item)
                <div class="customer-product-item">
                    <div class="customer-product-image">
                        <img src="{{ $item->product->image ?? asset('images/placeholder.png') }}" 
                             alt="{{ $item->product_name }}"
                             onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    </div>
                    <div class="customer-product-info">
                        <h3 class="customer-product-name">{{ $item->product_name }}</h3>
                        <div class="customer-product-meta">
                            <span class="customer-product-price">{{ number_format($item->price, 0, ',', '.') }}₫</span>
                            <span class="customer-product-qty">x {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <div class="customer-product-total">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Cột phải: Tổng kết (sticky) --}}
        <div class="customer-summary-box">
            <div class="customer-summary-row">
                <span>Tạm tính:</span>
                <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
            </div>
            <div class="customer-summary-row">
                <span>Phí vận chuyển:</span>
                <span>{{ number_format($shippingFee, 0, ',', '.') }}₫</span>
            </div>
            <div class="customer-summary-divider"></div>
            <div class="customer-summary-row customer-grand-total">
                <span>TỔNG THANH TOÁN:</span>
                <span class="customer-total-price">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
            </div>
        </div>
    </div>
</div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/oder.css') }}">
@endpush