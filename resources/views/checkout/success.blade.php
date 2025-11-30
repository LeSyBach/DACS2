{{-- FILE: resources/views/checkout/success.blade.php --}}
@extends('layouts.app') 

@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="grid wide checkout-container" style="text-align: center; padding: 50px 0;">
        {{-- Thanh tiến trình (Bước 3) --}}
        @include('checkout.steps', ['step' => 3]) 

        <div class="row">
            <div class="col c-12 l-8 l-o-2"> {{-- Căn giữa nội dung --}}
                <div class="success-card" style="padding: 40px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                    
                    <svg style="color: #20c997; margin-bottom: 20px;" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><path d="M9 11l3 3L22 4"></path></svg>
                    
                    <h1 style="color: #20c997; margin-bottom: 15px; font-size: 28px;">ĐẶT HÀNG THÀNH CÔNG!</h1>
                    
                    <p style="font-size: 16px; color: #555; margin-bottom: 10px;">
                        Đơn hàng của bạn đã được xác nhận và đang chờ xử lý thanh toán.
                    </p>

                    <p style="font-weight: bold; margin-bottom: 10px;">Mã đơn hàng: <span style="color: #007bff;">#{{ $order->id }}</span></p>

                    {{-- HIỂN THỊ TRẠNG THÁI THANH TOÁN --}}
                    <p style="font-weight: bold; margin-bottom: 15px;">Trạng thái thanh toán:</p>
                    <span style="display: inline-block; padding: 8px 15px; border-radius: 4px; color: white; background-color: {{ $order->payment_status == 'paid' ? '#20c997' : '#ffc107' }};">
                        {{ strtoupper($order->payment_method) }} - {{ strtoupper($order->payment_status) }}
                    </span>
                    
                    <div style="margin-top: 30px;">
                        <a href="{{ route('index') }}" class="btn" style="background-color: #007bff; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                            Tiếp tục mua sắm
                        </a>
                        <a href="{{ route('order.detail', $order->id) }}" class="btn" style="background-color: #6c757d; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: 600; margin-left: 10px;">
                            Xem chi tiết đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection