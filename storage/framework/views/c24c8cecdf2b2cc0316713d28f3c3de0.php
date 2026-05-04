


<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
    <section class="product-detail">
        <div class="grid wide">
            
            
            <div class="row">
                <div class="col c-12">
                    <a href="<?php echo e(route('index')); ?>" class="back-btn">
                        <i class="fa-solid fa-chevron-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="product-container">
                <div class="row">
                    
                    
                    <div class="col l-5 m-6 c-12">
                        <div class="gallery">
                            <div class="gallery__main">
                                <?php
                                    $displayImage = ($defaultVariant && $defaultVariant->image) ? $defaultVariant->image_url : $product->image_url;
                                ?>
                                <img src="<?php echo e($displayImage); ?>" alt="<?php echo e($product->name); ?>" class="gallery__img" id="main-img">
                                
                                <div class="gallery__badges">
                                    
                                    <?php if($product->created_at > now()->subDays(30)): ?>
                                        <span class="badge badge--new">Mới</span>
                                    <?php endif; ?>
                                    
                                    
                                    <?php if($product->old_price && $product->old_price > $product->price): ?>
                                        <?php
                                            $percent = round((($product->old_price - $product->price) / $product->old_price) * 100);
                                        ?>
                                        <span class="badge badge--sale">-<?php echo e($percent); ?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col l-7 m-6 c-12">
                        <div class="info">
                            
                            <p class="info__cate">
                                <?php echo e($product->category ? $product->category->name : 'Sản phẩm'); ?>

                            </p>
                            
                            <h1 class="info__title"><?php echo e($product->name); ?></h1>
                            
                            <div class="info__meta">
                                <div class="rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span>(<?php echo e($product->review_count ?? 0); ?> đánh giá)</span>
                                </div>
                                <span class="meta-divider">|</span>
                                <span class="status" id="stock-status">
                                    <?php
                                        $stock = $defaultVariant ? $defaultVariant->stock : $product->quantity;
                                    ?>
                                    <?php if($stock > 0): ?>
                                        <span style="color: #00c030;">Còn hàng: <strong id="stock-quantity"><?php echo e($stock); ?></strong></span>
                                    <?php else: ?>
                                        <span style="color: #ff424f;">Hết hàng</span>
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="price-box">
                                <div class="price-box__main">
                                    <span class="current-price">
                                        <?php if($defaultVariant): ?>
                                            <?php echo e(number_format($defaultVariant->price, 0, ',', '.')); ?> ₫
                                        <?php else: ?>
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?> ₫
                                        <?php endif; ?>
                                    </span>
                                    <?php if($defaultVariant && $defaultVariant->old_price): ?>
                                        <span class="old-price">
                                            <?php echo e(number_format($defaultVariant->old_price, 0, ',', '.')); ?> ₫
                                        </span>
                                    <?php elseif($product->old_price): ?>
                                        <span class="old-price">
                                            <?php echo e(number_format($product->old_price, 0, ',', '.')); ?> ₫
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php
                                    $oldPrice = $defaultVariant ? $defaultVariant->old_price : $product->old_price;
                                    $currentPrice = $defaultVariant ? $defaultVariant->price : $product->price;
                                ?>
                                
                                <?php if($oldPrice && $oldPrice > $currentPrice): ?>
                                    <div class="price-box__save">
                                        Tiết kiệm: <?php echo e(number_format($oldPrice - $currentPrice, 0, ',', '.')); ?> ₫
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="info__desc">
                                <?php echo e($product->description); ?>

                            </p>

                            <?php if($product->variants->count() > 0): ?>
                                
                                <div class="variants-selection">
                                    
                                    <?php
                                        $colors = $product->variants->pluck('color')->unique()->filter();
                                    ?>
                                    
                                    <?php if($colors->count() > 0): ?>
                                        <div class="variant-group">
                                            <label class="variant-label">
                                                <i class="fa-solid fa-palette"></i> Màu sắc:
                                                <span class="selected-value" id="selected-color">
                                                    <?php echo e($defaultVariant->color ?? $colors->first()); ?>

                                                </span>
                                            </label>
                                            <div class="variant-options" id="color-options">
                                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <button 
                                                        type="button" 
                                                        class="variant-option <?php echo e(($defaultVariant && $defaultVariant->color == $color) || (!$defaultVariant && $loop->first) ? 'active' : ''); ?>"
                                                        data-type="color"
                                                        data-value="<?php echo e($color); ?>">
                                                        <?php echo e($color); ?>

                                                    </button>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <?php
                                        $storages = $product->variants->pluck('storage')->unique()->filter();
                                    ?>
                                    
                                    <?php if($storages->count() > 0): ?>
                                        <div class="variant-group">
                                            <label class="variant-label">
                                                <i class="fa-solid fa-microchip"></i> Dung lượng:
                                                <span class="selected-value" id="selected-storage">
                                                    <?php echo e($defaultVariant->storage ?? $storages->first()); ?>

                                                </span>
                                            </label>
                                            <div class="variant-options" id="storage-options">
                                                <?php $__currentLoopData = $storages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <button 
                                                        type="button" 
                                                        class="variant-option <?php echo e(($defaultVariant && $defaultVariant->storage == $storage) || (!$defaultVariant && $loop->first) ? 'active' : ''); ?>"
                                                        data-type="storage"
                                                        data-value="<?php echo e($storage); ?>">
                                                        <?php echo e($storage); ?>

                                                    </button>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            
                            
                            <form id="add-to-cart-form" action="<?php echo e(route('cart.add', ['id' => $product->id])); ?>" method="POST" class="actions">
                                <?php echo csrf_field(); ?>
                                
                                
                                <input type="hidden" name="variant_id" id="selected-variant-id" value="<?php echo e($defaultVariant->id ?? ''); ?>">
                                
                                <div class="quantity">
                                    
                                    <button type="button" class="qty-btn minus">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    
                                    
                                    <input type="number" name="quantity" value="1" class="qty-input" min="1" max="<?php echo e($defaultVariant->stock ?? $product->quantity); ?>">
                                    
                                    
                                    <button type="button" class="qty-btn plus">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                                
                                
                                <button type="submit" class="btn-buy">
                                    <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ
                                </button>
                                
                                <button type="button" class="btn-heart">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>

                            <div class="divider"></div>

                            
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

    
    <section class="product-reviews-section">
        <div class="grid wide">
            <div class="product-reviews">
                <?php echo $__env->make('reviews.partials.reviews-list', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/product-detail.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    
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
    <script src="<?php echo e(asset('assets/js/product-detail.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/product/product-detail.blade.php ENDPATH**/ ?>