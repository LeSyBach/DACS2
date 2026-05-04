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
            
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
                <div class="col l-3 m-6 c-12">
                    <a href="<?php echo e(route('product.detail', ['id' => $product->id])); ?>" class="product-item">
                        
                        <div class="product-item__img-wrapper">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="product-item__img">
                            
                            <?php if($product->created_at > now()->subDays(30)): ?> 
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
                                    <span class="product-item__review-count">(<?php echo e($reviewCount); ?> đánh giá)</span>
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
            <?php echo e($featuredProducts->appends(request()->except('featured_page'))->links()); ?>

        </div>

    </div>
</div><?php /**PATH C:\xampp\htdocs\techstore\resources\views/home/featured-products.blade.php ENDPATH**/ ?>