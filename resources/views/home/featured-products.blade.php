<div class="featured-products" id="featured-products-container">
    <div class="grid wide">
        <div class="row">
            <div class="col c-12">
                <div class="section-header">
                    <h2 class="section-header__title">Sản phẩm nổi bật</h2>
                    <p class="section-header__subtitle">Những sản phẩm công nghệ hàng đầu với chất lượng đảm bảo và giá cả cạnh tranh</p>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- BẮT ĐẦU VÒNG LẶP --}}
            @foreach($featuredProducts as $product)
            
                <div class="col l-3 m-6 c-12">
                    <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="product-item">
                        
                        <div class="product-item__img-wrapper">
                            <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" class="product-item__img">
                            
                            @if($product->created_at > now()->subDays(30)) 
                                <span class="product-item__badge">Mới</span>
                            @endif
                            
                            <button class="product-item__like">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>

                        <div class="product-item__content">
                            <h3 class="product-item__name">{{ $product->name }}</h3>
                            
                            <div class="product-item__rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="product-item__review-count">({{ $product->quantity }} đã bán)</span>
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
            {{-- KẾT THÚC VÒNG LẶP --}}
        </div>
        
        {{-- <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $featuredProducts->links() }}
        </div> --}}

        <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $featuredProducts->appends(request()->except('featured_page'))->links() }}
        </div>

    </div>
</div>