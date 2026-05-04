
<div class="product-all" id="all-products-container">
    <div class="grid wide">
        <div class="row">
            @if(isset($showFilter) && $showFilter)
            {{-- CỘT BÊN TRÁI: SIDEBAR FILTER --}}
            <div class="col l-3 m-12 c-12">
                <div class="product-filter-sidebar">
                    <div class="filter-header">
                        <h3><i class="fa-solid fa-filter"></i> Bộ lọc</h3>
                    </div>
                    
                    <form method="GET" action="{{ route('product') }}" class="filter-form-sidebar">
                        {{-- DANH MỤC --}}
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-tag"></i> Danh mục
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }}>
                                    <span>Tất cả</span>
                                </label>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <label class="filter-option">
                                            <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }}>
                                            <span>{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- KHOẢNG GIÁ --}}
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-dollar-sign"></i> Khoảng giá
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="" {{ request('price_range') == '' ? 'checked' : '' }}>
                                    <span>Tất cả</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="1" {{ request('price_range') == '1' ? 'checked' : '' }}>
                                    <span>Dưới 5 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="2" {{ request('price_range') == '2' ? 'checked' : '' }}>
                                    <span>5 - 10 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="3" {{ request('price_range') == '3' ? 'checked' : '' }}>
                                    <span>10 - 20 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="4" {{ request('price_range') == '4' ? 'checked' : '' }}>
                                    <span>20 - 30 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="5" {{ request('price_range') == '5' ? 'checked' : '' }}>
                                    <span>Trên 30 triệu</span>
                                </label>
                            </div>
                        </div>

                        {{-- SẮP XẾP --}}
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-sort"></i> Sắp xếp
                            </h4>
                            <select name="sort" class="filter-select-full">
                                <option value="">Mặc định</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z-A</option>
                            </select>
                        </div>

                        {{-- NÚT HÀNH ĐỘNG --}}
                        <div class="filter-actions-sidebar">
                            <button type="submit" class="btn-filter-apply-sidebar">
                                <i class="fa-solid fa-check"></i> Áp dụng
                            </button>
                            <a href="{{ route('product') }}" class="btn-filter-reset-sidebar">
                                <i class="fa-solid fa-rotate-right"></i> Xóa lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- CỘT BÊN PHẢI: DANH SÁCH SẢN PHẨM --}}
            <div class="col {{ (isset($showFilter) && $showFilter) ? 'l-9' : 'l-12' }} m-12 c-12">
                <div class="section-header">
                    <h2 class="section-header__title">Tất cả sản phẩm</h2>
                    <p class="section-header__subtitle">Những sản phẩm công nghệ hàng đầu với chất lượng đảm bảo và giá cả cạnh tranh</p>
                </div>

                @if(isset($products) && $products->isEmpty())
                    <p>Không có sản phẩm nào.</p>
                @else
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col {{ (isset($showFilter) && $showFilter) ? 'l-4' : 'l-3' }} m-6 c-12">
                                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="product-item">
                                    <div class="product-item__img-wrapper">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-item__img">
                                        @if(optional($product->created_at)->gt(now()->subDays(30)))
                                            <span class="product-item__badge">Mới</span>
                                        @endif
                                        <button class="product-item__like">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </div>

                                    <div class="product-item__content">
                                        <h3 class="product-item__name">{{ $product->name }}</h3>

                                        <div class="product-item__rating">
                                            @php
                                                $avgRating = $product->average_rating;
                                                $reviewCount = $product->review_count;
                                            @endphp
                                            
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($avgRating))
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif($i - 0.5 <= $avgRating)
                                                    <i class="fa-solid fa-star-half-alt"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                            
                                            @if($reviewCount > 0)
                                                <span class="product-item__review-count">({{ $reviewCount }})</span>
                                            @else
                                                <span class="product-item__review-count">(Chưa có đánh giá)</span>
                                            @endif
                                        </div>

                                        <div class="product-item__footer">
                                            <div class="product-item__price">
                                                <span class="product-item__price-current">
                                                    {{ number_format($product->price, 0, ',', '.') }} ₫
                                                </span>
                                                @if($product->old_price)
                                                    <span class="product-item__price-old">
                                                        {{ number_format($product->old_price, 0, ',', '.') }} ₫
                                                    </span>
                                                @endif
                                            </div>
                                            <button class="product-item__btn">
                                                <i class="fa-solid fa-cart-shopping"></i> Thêm
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
                        {{ $products->appends(request()->except('all_page'))->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
