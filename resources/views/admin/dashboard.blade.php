{{-- FILE: resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.guest') 

@section('title', 'Admin Dashboard')

@section('content')
    <div class="l-12">
        <h1 class="admin-page-heading">Tổng quan Hệ thống</h1>
        
        {{-- THẺ THỐNG KÊ CHÍNH --}}
        <div class="admin-stats-row">
            
            {{-- 1. Tổng Đơn Hàng (Sử dụng Pending Orders làm ví dụ) --}}
            @include('admin.partials.stat_card', [
                'title' => 'Đơn Hàng Đang Chờ', 
                'value' => number_format($pendingOrders), 
                'icon' => 'fa-bell', 
                'color' => 'orange'
            ])
            
            {{-- 2. Doanh Thu --}}
            @include('admin.partials.stat_card', [
                'title' => 'Doanh Thu Đã TT', 
                'value' => number_format($totalRevenue, 0, ',', '.') . ' ₫',
                'icon' => 'fa-dollar-sign',
                'color' => 'blue'
            ])
            
            {{-- 3. Khách hàng --}}
            @include('admin.partials.stat_card', [
                'title' => 'Tổng Khách Hàng', 
                'value' => number_format($totalCustomers),
                'icon' => 'fa-users',
                'color' => 'green'
            ])

            {{-- 4. Tổng Đơn Hàng --}}
            @include('admin.partials.stat_card', [
                'title' => 'Tổng Số Đơn', 
                'value' => number_format($totalOrders),
                'icon' => 'fa-receipt',
                'color' => 'teal'
            ])
        </div>
        
        {{-- KHỐI THỐNG KÊ DANH MỤC SẢN PHẨM --}}
        <h2 class="section-sub-heading">Thống kê Sản phẩm theo Danh mục</h2>
        <div class="admin-category-stats">
            
            @php
                // Mảng màu sắc luân phiên
                $colors = ['green', 'blue', 'orange', 'teal', 'purple', 'red'];
                $i = 0;
            @endphp
            
            @foreach ($categoryStats as $category)
                @include('admin.partials.stat_card', [
                    'title' => $category->name, 
                    'value' => number_format($category->products_count),
                    'icon' => 'fa-box',
                    'color' => $colors[$i++ % count($colors)]
                ])
            @endforeach
            
        </div>
        
        {{-- BẢNG ĐƠN HÀNG GẦN ĐÂY --}}
        {{-- <h2 class="section-sub-heading">Đơn hàng mới nhất</h2> --}}
        {{-- @include('admin.partials.recent_orders', ['orders' => $orders]) --}}
    </div>
@endsection