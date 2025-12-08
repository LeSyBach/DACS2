{{-- FILE: resources/views/errors/404.blade.php --}}
@extends('layouts.app') 

@section('title', 'Lỗi 404 - Không tìm thấy trang')

@section('content')
    <div class="error-page-container">
        <div class="error-card">
            
            <span class="error-code">404</span>
            
            <h1 class="error-heading">Rất tiếc! Không tìm thấy trang này.</h1>
            
            <p class="error-message">
                Liên kết bạn truy cập có thể đã bị hỏng, bị xóa hoặc không còn tồn tại.
            </p>
            
            <div class="error-actions">
                <a href="{{ route('index') }}" class="btn btn-primary btn-home">
                    <i class="fa-solid fa-house"></i> Quay lại Trang chủ
                </a>
                
                {{-- Tùy chọn: Thêm nút Tìm kiếm --}}
                <a href="{{ route('product') }}" class="btn btn-secondary btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Xem Sản phẩm
                </a>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/errors.css') }}">
@endpush