

<div class="checkout-summary-card">
    <h3 class="modal-cart__heading">Đơn hàng của bạn</h3>

    <ul class="summary-product-list">
        <?php
            $subtotal = 0;
            $shippingFee = 30000; 
        ?>

        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Xử lý dữ liệu cho Session Array và DB Model
                if (is_object($item)) { 
                    $variant = $item->variant ?? null;
                    $price = $variant ? $variant->price : ($item->product->price ?? 0);
                    $quantity = $item->quantity;
                    $productName = $item->product->name ?? 'Sản phẩm không rõ';
                    $variantName = $variant ? $variant->display_name : null;
                } else {
                    $price = $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 0;
                    $productName = $item['name'];
                    $variantName = $item['variant_name'] ?? null;
                }
                $itemTotal = $price * $quantity;
                $subtotal += $itemTotal;
            ?>
            
            <li class="summary-product-item">
                <span class="summary-product-name">
                    <?php echo e($productName); ?>

                    <?php if($variantName): ?>
                        <small style="color: #666; font-weight: normal;">(<?php echo e($variantName); ?>)</small>
                    <?php endif; ?>
                    (x<?php echo e($quantity); ?>)
                </span>
                <span class="summary-product-price"><?php echo e(number_format($itemTotal, 0, ',', '.')); ?>₫</span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <hr class="summary-divider">

    <div class="summary-details">
        <p class="summary-row">
            <span class="summary-label">Tạm tính:</span>
            <span class="summary-value"><?php echo e(number_format($subtotal, 0, ',', '.')); ?>₫</span>
        </p>
        
        <p class="summary-row">
            <span class="summary-label">Phí vận chuyển:</span>
            <span class="summary-value"><?php echo e(number_format($shippingFee, 0, ',', '.')); ?>₫</span>
        </p>
        
        

        <?php
            $grandTotal = $subtotal + $shippingFee;
        ?>
    </div>

    <hr class="summary-divider">

    <div class="summary-total">
        <span>Tổng cộng:</span>
        <span id="grand-total"><?php echo e(number_format($grandTotal, 0, ',', '.')); ?>₫</span>
    </div>
</div><?php /**PATH C:\xampp\htdocs\techstore\resources\views/checkout/summary.blade.php ENDPATH**/ ?>