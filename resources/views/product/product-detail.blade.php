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
                                @php
                                    $displayImage = ($defaultVariant && $defaultVariant->image) ? $defaultVariant->image_url : $product->image_url;
                                @endphp
                                <img src="{{ $displayImage }}" alt="{{ $product->name }}" class="gallery__img" id="main-img">
                                
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
                                    @php
                                        $stock = $defaultVariant ? $defaultVariant->stock : $product->quantity;
                                    @endphp
                                    {{ $stock > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                            </div>

                            <div class="price-box">
                                <div class="price-box__main">
                                    <span class="current-price">
                                        @if($defaultVariant)
                                            {{ number_format($defaultVariant->price, 0, ',', '.') }} ₫
                                        @else
                                            {{ number_format($product->price, 0, ',', '.') }} ₫
                                        @endif
                                    </span>
                                    @if($defaultVariant && $defaultVariant->old_price)
                                        <span class="old-price">
                                            {{ number_format($defaultVariant->old_price, 0, ',', '.') }} ₫
                                        </span>
                                    @elseif($product->old_price)
                                        <span class="old-price">
                                            {{ number_format($product->old_price, 0, ',', '.') }} ₫
                                        </span>
                                    @endif
                                </div>
                                
                                @php
                                    $oldPrice = $defaultVariant ? $defaultVariant->old_price : $product->old_price;
                                    $currentPrice = $defaultVariant ? $defaultVariant->price : $product->price;
                                @endphp
                                
                                @if($oldPrice && $oldPrice > $currentPrice)
                                    <div class="price-box__save">
                                        Tiết kiệm: {{ number_format($oldPrice - $currentPrice, 0, ',', '.') }} ₫
                                    </div>
                                @endif
                            </div>

                            <p class="info__desc">
                                {{ $product->description }}
                            </p>

                            @if($product->variants->count() > 0)
                                {{-- CHỌN BIẾN THỂ --}}
                                <div class="variants-selection">
                                    {{-- Chọn màu sắc --}}
                                    @php
                                        $colors = $product->variants->pluck('color')->unique()->filter();
                                    @endphp
                                    
                                    @if($colors->count() > 0)
                                        <div class="variant-group">
                                            <label class="variant-label">
                                                <i class="fa-solid fa-palette"></i> Màu sắc:
                                                <span class="selected-value" id="selected-color">
                                                    {{ $defaultVariant->color ?? $colors->first() }}
                                                </span>
                                            </label>
                                            <div class="variant-options" id="color-options">
                                                @foreach($colors as $color)
                                                    <button 
                                                        type="button" 
                                                        class="variant-option {{ ($defaultVariant && $defaultVariant->color == $color) || (!$defaultVariant && $loop->first) ? 'active' : '' }}"
                                                        data-type="color"
                                                        data-value="{{ $color }}">
                                                        {{ $color }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Chọn dung lượng --}}
                                    @php
                                        $storages = $product->variants->pluck('storage')->unique()->filter();
                                    @endphp
                                    
                                    @if($storages->count() > 0)
                                        <div class="variant-group">
                                            <label class="variant-label">
                                                <i class="fa-solid fa-microchip"></i> Dung lượng:
                                                <span class="selected-value" id="selected-storage">
                                                    {{ $defaultVariant->storage ?? $storages->first() }}
                                                </span>
                                            </label>
                                            <div class="variant-options" id="storage-options">
                                                @foreach($storages as $storage)
                                                    <button 
                                                        type="button" 
                                                        class="variant-option {{ ($defaultVariant && $defaultVariant->storage == $storage) || (!$defaultVariant && $loop->first) ? 'active' : '' }}"
                                                        data-type="storage"
                                                        data-value="{{ $storage }}">
                                                        {{ $storage }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- FORM MUA HÀNG (Chuẩn bị cho tính năng Add to Cart) --}}
                            {{-- FORM THÊM VÀO GIỎ --}}
                            <form id="add-to-cart-form" action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="actions">
                                @csrf
                                
                                {{-- Hidden input để lưu variant_id được chọn --}}
                                <input type="hidden" name="variant_id" id="selected-variant-id" value="{{ $defaultVariant->id ?? '' }}">
                                
                                <div class="quantity">
                                    {{-- Nút giảm --}}
                                    <button type="button" class="qty-btn minus">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    
                                    {{-- Ô nhập số lượng --}}
                                    <input type="number" name="quantity" value="1" class="qty-input" min="1" max="{{ $defaultVariant->stock ?? $product->quantity }}">
                                    
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
    {{-- Truyền dữ liệu variants sang JavaScript với image_url --}}
    <script>
        const productVariants = <?php echo json_encode($product->variants->map(function($v) {
            return [
                'id' => $v->id,
                'product_id' => $v->product_id,
                'color' => $v->color,
                'storage' => $v->storage,
                'price' => $v->price,
                'old_price' => $v->old_price,
                'stock' => $v->stock,
                'sku' => $v->sku,
                'image' => $v->image,
                'image_url' => $v->image_url,
                'is_default' => $v->is_default
            ];
        })); ?>;
        const defaultVariant = <?php echo json_encode($defaultVariant ? [
            'id' => $defaultVariant->id,
            'product_id' => $defaultVariant->product_id,
            'color' => $defaultVariant->color,
            'storage' => $defaultVariant->storage,
            'price' => $defaultVariant->price,
            'old_price' => $defaultVariant->old_price,
            'stock' => $defaultVariant->stock,
            'sku' => $defaultVariant->sku,
            'image' => $defaultVariant->image,
            'image_url' => $defaultVariant->image_url,
            'is_default' => $defaultVariant->is_default
        ] : null); ?>;
    </script>
    <script src="{{ asset('assets/js/product-detail.js') }}"></script>
@endpush
