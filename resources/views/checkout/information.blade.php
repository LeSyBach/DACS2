{{-- FILE: resources/views/checkout/information.blade.php --}}
@extends('layouts.app') 

@section('title', 'Thanh toán - Bước 1: Thông tin')

@section('content')
    <div class="checkout-wrapper grid wide">
        
        <a href="{{ route('index') }}" class="back-link">
            ← Quay lại
        </a>

        @include('checkout.steps', ['step' => 1]) 

        <form method="POST" action="{{ route('checkout.process_info') }}">
            @csrf
            
            <div class="row checkout-main-row">
                
                <div class="col c-12 l-7">
                    <div class="checkout-card info-card">
                        <h2 class="card-title">Thông tin giao hàng</h2>
                        
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        
                        <div class="row info-form-row">
                            
                            {{-- Họ và Tên (c-6) --}}
                            <div class="col c-12 m-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Họ và tên *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $defaultData->name) }}" required class="form-input">
                                    @error('name') <span class="input-error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            {{-- Số điện thoại (c-6) --}}
                            <div class="col c-12 m-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Số điện thoại *</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $defaultData->phone) }}" required class="form-input">
                                    @error('phone') <span class="input-error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            {{-- Email (c-12) --}}
                            <div class="col c-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $defaultData->email) }}" required class="form-input">
                                    @error('email') <span class="input-error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Địa chỉ Giao hàng (c-12) --}}
                            <div class="col c-12">
                                <div class="form-group">
                                    <label for="address" class="form-label">Địa chỉ giao hàng *</label>
                                    <textarea name="address" id="address" required rows="2" class="form-input form-textarea">{{ old('address', $defaultData->address) }}</textarea>
                                    @error('address') <span class="input-error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-continue">Tiếp tục thanh toán</button>
                    </div>
                </div>

                {{-- Cột 2: Tóm tắt Đơn hàng (l-5) --}}
                <div class="col c-12 l-5">
                    @include('checkout.summary', ['cartItems' => $cartItems])
                </div>
            </div>
        </form>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout_styles.css') }}">
@endpush