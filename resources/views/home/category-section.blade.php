{{-- <div class="category-section">
    <div class="grid wide">
        <h2 class="category-heading">Danh mục sản phẩm</h2>
        <p class="category-subtitle">
            Khám phá các danh mục sản phẩm công nghệ đa dạng với chất lượng cao
        </p>

        <div class="row">
           
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3>Điện thoại</h3>
                    <p>156 sản phẩm</p>
                </div>
            </div>

        
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-laptop"></i>
                    </div>
                    <h3>Máy tính xách tay</h3>
                    <p>89 sản phẩm</p>
                </div>
            </div>

            
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-headphones"></i>
                    </div>
                    <h3>Tai nghe</h3>
                    <p>234 sản phẩm</p>
                </div>
            </div>

            
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3>Đồng hồ thông minh</h3>
                    <p>67 sản phẩm</p>
                </div>
            </div>

           
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <h3>Máy ảnh</h3>
                    <p>45 sản phẩm</p>
                </div>
            </div>

           
            <div class="col l-2 m-4 c-6">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                    <h3>Chơi game</h3>
                    <p>78 sản phẩm</p>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="category-section">
    <div class="grid wide">
        <h2 class="category-heading">Danh mục sản phẩm</h2>
        <p class="category-subtitle">
            Khám phá các danh mục sản phẩm công nghệ đa dạng với chất lượng cao
        </p>

        <div class="row">
            @foreach($categories as $category)
            <div class="col l-2 m-4 c-6">
                <a href="" class="category-card">
                    <div class="category-icon">
                        <i class="fas {{ $category->icon }}"></i>
                    </div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->products_count }} sản phẩm</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>