{{-- FILE: resources/views/checkout/success.blade.php --}}
@extends('layouts.app') 

@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="grid wide checkout-container success-page-wrapper">
        {{-- Thanh tiến trình (Bước 3) --}}
        @include('checkout.steps', ['step' => 3]) 

        <div class="row">
            {{-- Căn giữa nội dung --}}
            <div class="col c-12 l-8 l-o-2"> 
                <div class="checkout-card success-card">
                    
                    {{-- Icon Check Circle --}}
                    <svg class="success-icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><path d="M9 11l3 3L22 4"></path></svg>
                    
                    <h1 class="success-heading">ĐẶT HÀNG THÀNH CÔNG!</h1>
                    
                    <p class="success-text-note">
                        Đơn hàng của bạn đã được xác nhận và đang chờ xử lý thanh toán.
                    </p>

                    <p class="order-id-label">Mã đơn hàng: <span class="order-id-value">#{{ $order->id }}</span></p>

                    {{-- HIỂN THỊ TRẠNG THÁI THANH TOÁN --}}
                    <p class="payment-status-label">Trạng thái thanh toán:</p>
                    
                    @php
                        // Xác định class màu động dựa trên trạng thái thanh toán
                        $paymentStatusClass = ($order->payment_status == 'paid') ? 'status-paid' : 'status-pending-payment';
                    @endphp
                    
                    <span class="payment-status-badge {{ $paymentStatusClass }}">
                        {{ strtoupper($order->payment_method) }} - {{ strtoupper($order->payment_status) }}
                    </span>
                    
                    {{-- Các nút hành động --}}
                    <div class="success-actions">
                        <a href="{{ route('index') }}" class="btn btn-primary btn-continue-shopping">
                            Tiếp tục mua sắm
                        </a>
                        <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary btn-view-order">
                            Xem chi tiết đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout_styles.css') }}">
    <style>
        /* Fix buttons alignment */
        .success-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .btn-continue-shopping,
        .btn-view-order {
            flex: 1;
            max-width: 300px;
            text-align: center;
            text-decoration: none !important;
            padding: 14px 24px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-continue-shopping {
            background: #17a2b8;
            color: #fff;
            border: none;
        }
        
        .btn-continue-shopping:hover {
            background: #138496;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        }
        
        .btn-view-order {
            background: #6c757d;
            color: #fff;
            border: none;
        }
        
        .btn-view-order:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }
        
        @media (max-width: 768px) {
            .success-actions {
                flex-direction: column;
            }
            
            .btn-continue-shopping,
            .btn-view-order {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush