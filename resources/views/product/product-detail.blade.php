@extends('layouts.app')

{{-- Tiêu đề tab sẽ lấy tên sản phẩm --}}
@section('title', $product->name)

@section('content')
    <section class="product-detail">
        <div class="grid wide">
            
            {{-- Breadcrumb / Nút Quay lại --}}
            <div class="row">
                <div class="col c-12">
                    <a href="{{ route('index') }}" class="back-btn">
                        <i class="fa-solid fa-chevron-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="product-container">
                <div class="row">
                    
                    {{-- 1. CỘT TRÁI: ẢNH SẢN PHẨM --}}
                    <div class="col l-5 m-6 c-12">
                        <div class="gallery">
                            <div class="gallery__main">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="gallery__img" id="main-img">
                                
                                <div class="gallery__badges">
                                    {{-- Logic: Nếu sản phẩm mới tạo trong 30 ngày --}}
                                    @if($product->created_at > now()->subDays(30))
                                        <span class="badge badge--new">Mới</span>
                                    @endif
                                    
                                    {{-- Logic: Tính phần trăm giảm giá --}}
                                    @if($product->old_price && $product->old_price > $product->price)
                                        @php
                                            $percent = round((($product->old_price - $product->price) / $product->old_price) * 100);
                                        @endphp
                                        <span class="badge badge--sale">-{{ $percent }}%</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- (Tạm thời ảnh nhỏ dùng lại ảnh chính vì chưa có bảng ProductImage) --}}
                            <div class="gallery__thumbs">
                                <div class="gallery__thumb gallery__thumb--active">
                                    <img src="{{ $product->image }}" alt="">
                                </div>
                                <div class="gallery__thumb">
                                    <img src="{{ $product->image }}" alt="">
                                </div>
                                <div class="gallery__thumb">
                                    <img src="{{ $product->image }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. CỘT PHẢI: THÔNG TIN SẢN PHẨM --}}
                    <div class="col l-7 m-6 c-12">
                        <div class="info">
                            {{-- Tên danh mục (Dùng quan hệ hasOne Category) --}}
                            <p class="info__cate">
                                {{ $product->category ? $product->category->name : 'Sản phẩm' }}
                            </p>
                            
                            <h1 class="info__title">{{ $product->name }}</h1>
                            
                            <div class="info__meta">
                                <div class="rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span>({{ $product->review_count ?? 0 }} đánh giá)</span>
                                </div>
                                <span class="meta-divider">|</span>
                                <span class="status">
                                    {{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                            </div>

                            <div class="price-box">
                                <div class="price-box__main">
                                    <span class="current-price">
                                        {{ number_format($product->price, 0, ',', '.') }} ₫
                                    </span>
                                    @if($product->old_price)
                                        <span class="old-price">
                                            {{ number_format($product->old_price, 0, ',', '.') }} ₫
                                        </span>
                                    @endif
                                </div>
                                
                                @if($product->old_price)
                                    <div class="price-box__save">
                                        Tiết kiệm: {{ number_format($product->old_price - $product->price, 0, ',', '.') }} ₫
                                    </div>
                                @endif
                            </div>

                            <p class="info__desc">
                                {{ $product->description }}
                            </p>

                            {{-- FORM MUA HÀNG (Chuẩn bị cho tính năng Add to Cart) --}}
                            {{-- FORM THÊM VÀO GIỎ --}}
                            <form id="add-to-cart-form" action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="actions">
                                @csrf
                                
                                <div class="quantity">
                                    {{-- Nút giảm --}}
                                    <button type="button" class="qty-btn minus">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    
                                    {{-- Ô nhập số lượng --}}
                                    <input type="number" name="quantity" value="1" class="qty-input" min="1">
                                    
                                    {{-- Nút tăng --}}
                                    <button type="button" class="qty-btn plus">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                                
                                {{-- Nút Submit --}}
                                <button type="submit" class="btn-buy">
                                    <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ
                                </button>
                                
                                <button type="button" class="btn-heart">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>

                            <div class="divider"></div>

                            {{-- Phần Chính sách giữ nguyên (Vì nó giống nhau cho mọi SP) --}}
                            <div class="policies">
                                <div class="policy-card">
                                    <div class="policy-card__icon"><i class="fa-solid fa-truck-fast"></i></div>
                                    <div class="policy-card__text">
                                        <h4>Miễn phí vận chuyển</h4>
                                        <p>Cho đơn hàng từ 500k</p>
                                    </div>
                                </div>
                                <div class="policy-card">
                                    <div class="policy-card__icon"><i class="fa-solid fa-shield-halved"></i></div>
                                    <div class="policy-card__text">
                                        <h4>Bảo hành uy tín</h4>
                                        <p>Chính hãng 12 tháng</p>
                                    </div>
                                </div>
                                <div class="policy-card">
                                    <div class="policy-card__icon"><i class="fa-solid fa-rotate"></i></div>
                                    <div class="policy-card__text">
                                        <h4>Đổi trả dễ dàng</h4>
                                        <p>Trong vòng 7 ngày</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/product-detail.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/product-detail.js') }}"></script>
@endpush
