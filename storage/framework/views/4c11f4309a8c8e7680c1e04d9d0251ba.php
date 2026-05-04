
<div class="product-all" id="all-products-container">
    <div class="grid wide">
        <div class="row">
            <?php if(isset($showFilter) && $showFilter): ?>
            
            <div class="col l-3 m-12 c-12">
                <div class="product-filter-sidebar">
                    <div class="filter-header">
                        <h3><i class="fa-solid fa-filter"></i> Bộ lọc</h3>
                    </div>
                    
                    <form method="GET" action="<?php echo e(route('product')); ?>" class="filter-form-sidebar">
                        
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-tag"></i> Danh mục
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="category" value="" <?php echo e(request('category') == '' ? 'checked' : ''); ?>>
                                    <span>Tất cả</span>
                                </label>
                                <?php if(isset($categories)): ?>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="filter-option">
                                            <input type="radio" name="category" value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'checked' : ''); ?>>
                                            <span><?php echo e($category->name); ?></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-dollar-sign"></i> Khoảng giá
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="" <?php echo e(request('price_range') == '' ? 'checked' : ''); ?>>
                                    <span>Tất cả</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="1" <?php echo e(request('price_range') == '1' ? 'checked' : ''); ?>>
                                    <span>Dưới 5 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="2" <?php echo e(request('price_range') == '2' ? 'checked' : ''); ?>>
                                    <span>5 - 10 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="3" <?php echo e(request('price_range') == '3' ? 'checked' : ''); ?>>
                                    <span>10 - 20 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="4" <?php echo e(request('price_range') == '4' ? 'checked' : ''); ?>>
                                    <span>20 - 30 triệu</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="price_range" value="5" <?php echo e(request('price_range') == '5' ? 'checked' : ''); ?>>
                                    <span>Trên 30 triệu</span>
                                </label>
                            </div>
                        </div>

                        
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fa-solid fa-sort"></i> Sắp xếp
                            </h4>
                            <select name="sort" class="filter-select-full">
                                <option value="">Mặc định</option>
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Mới nhất</option>
                                <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Giá: Thấp → Cao</option>
                                <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Giá: Cao → Thấp</option>
                                <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>>Tên: A-Z</option>
                                <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>Tên: Z-A</option>
                            </select>
                        </div>

                        
                        <div class="filter-actions-sidebar">
                            <button type="submit" class="btn-filter-apply-sidebar">
                                <i class="fa-solid fa-check"></i> Áp dụng
                            </button>
                            <a href="<?php echo e(route('product')); ?>" class="btn-filter-reset-sidebar">
                                <i class="fa-solid fa-rotate-right"></i> Xóa lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="col <?php echo e((isset($showFilter) && $showFilter) ? 'l-9' : 'l-12'); ?> m-12 c-12">
                <div class="section-header">
                    <h2 class="section-header__title">Tất cả sản phẩm</h2>
                    <p class="section-header__subtitle">Những sản phẩm công nghệ hàng đầu với chất lượng đảm bảo và giá cả cạnh tranh</p>
                </div>

                <?php if(isset($products) && $products->isEmpty()): ?>
                    <p>Không có sản phẩm nào.</p>
                <?php else: ?>
                    <div class="row">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col <?php echo e((isset($showFilter) && $showFilter) ? 'l-4' : 'l-3'); ?> m-6 c-12">
                                <a href="<?php echo e(route('product.detail', ['id' => $product->id])); ?>" class="product-item">
                                    <div class="product-item__img-wrapper">
                                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="product-item__img">
                                        <?php if(optional($product->created_at)->gt(now()->subDays(30))): ?>
                                            <span class="product-item__badge">Mới</span>
                                        <?php endif; ?>
                                        <button class="product-item__like">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </div>

                                    <div class="product-item__content">
                                        <h3 class="product-item__name"><?php echo e($product->name); ?></h3>

                                        <div class="product-item__rating">
                                            <?php
                                                $avgRating = $product->average_rating;
                                                $reviewCount = $product->review_count;
                                            ?>
                                            
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= floor($avgRating)): ?>
                                                    <i class="fa-solid fa-star"></i>
                                                <?php elseif($i - 0.5 <= $avgRating): ?>
                                                    <i class="fa-solid fa-star-half-alt"></i>
                                                <?php else: ?>
                                                    <i class="fa-regular fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            
                                            <?php if($reviewCount > 0): ?>
                                                <span class="product-item__review-count">(<?php echo e($reviewCount); ?>)</span>
                                            <?php else: ?>
                                                <span class="product-item__review-count">(Chưa có đánh giá)</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-item__footer">
                                            <div class="product-item__price">
                                                <span class="product-item__price-current">
                                                    <?php echo e(number_format($product->price, 0, ',', '.')); ?> ₫
                                                </span>
                                                <?php if($product->old_price): ?>
                                                    <span class="product-item__price-old">
                                                        <?php echo e(number_format($product->old_price, 0, ',', '.')); ?> ₫
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <button class="product-item__btn">
                                                <i class="fa-solid fa-cart-shopping"></i> Thêm
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
                        <?php echo e($products->appends(request()->except('all_page'))->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\techstore\resources\views/home/product-all.blade.php ENDPATH**/ ?>