
<?php if($variants->count() > 0): ?>
<div class="order-list-table">
    <table class="table order-table">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Màu sắc</th>
                <th>Bộ nhớ</th>
                <th>SKU</th>
                <th>Giá cũ</th>
                <th>Giá bán</th>
                <th>Tồn kho</th>
                <th>Mặc định</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="<?php echo e($variant->is_default ? 'is-default' : ''); ?>">
                <td data-label="Ảnh">
                    <?php if($variant->image): ?>
                    <img src="<?php echo e(asset('storage/' . $variant->image)); ?>" 
                         alt="Variant" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                    <?php else: ?>
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                         alt="Product" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; opacity: 0.5;">
                    <?php endif; ?>
                </td>
                <td data-label="Màu sắc">
                    <?php if($variant->color): ?>
                    <span class="badge status-secondary"><?php echo e($variant->color); ?></span>
                    <?php else: ?>
                    <span style="color: #999;">—</span>
                    <?php endif; ?>
                </td>
                <td data-label="Bộ nhớ">
                    <?php if($variant->storage): ?>
                    <span class="badge status-info"><?php echo e($variant->storage); ?></span>
                    <?php else: ?>
                    <span style="color: #999;">—</span>
                    <?php endif; ?>
                </td>
                <td data-label="SKU">
                    <code style="background: #f4f4f4; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        <?php echo e($variant->sku); ?>

                    </code>
                </td>
                <td data-label="Giá cũ" class="price-col">
                    <span style="color: #999; text-decoration: <?php echo e($variant->hasDiscount() ? 'line-through' : 'none'); ?>;">
                        <?php echo e(number_format($variant->old_price, 0, ',', '.')); ?>₫
                    </span>
                </td>
                <td data-label="Giá bán" class="price-col">
                    <?php if($variant->hasDiscount()): ?>
                    <span style="color: #e74c3c; font-weight: 600;">
                        <?php echo e(number_format($variant->price, 0, ',', '.')); ?>₫
                    </span>
                    <span class="badge status-danger" style="font-size: 11px;">
                        -<?php echo e($variant->discount_percent); ?>%
                    </span>
                    <?php else: ?>
                    <span style="color: #999;">—</span>
                    <?php endif; ?>
                </td>
                <td data-label="Tồn kho">
                    <span class="badge <?php echo e($variant->stock > 0 ? 'status-success' : 'status-danger'); ?>">
                        <?php echo e($variant->stock); ?>

                    </span>
                </td>
                <td data-label="Mặc định">
                    <?php if($variant->is_default): ?>
                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 20px;" title="Biến thể mặc định"></i>
                    <?php else: ?>
                    <button type="button"
                            onclick="setDefaultVariant(<?php echo e($variant->id); ?>)"
                            style="background: none; border: none; cursor: pointer; color: #999; font-size: 18px;"
                            title="Đặt làm mặc định">
                        <i class="far fa-circle"></i>
                    </button>
                    <?php endif; ?>
                </td>
                <td data-label="Hành động">
                    
                    <button type="button" 
                            class="btn btn-sm btn-info"
                            style="margin-right: 5px;"
                            onclick="editVariant(<?php echo e($variant->id); ?>, '<?php echo e($variant->color); ?>', '<?php echo e($variant->storage); ?>', <?php echo e($variant->old_price); ?>, <?php echo e($variant->price ?? 'null'); ?>, <?php echo e($variant->stock); ?>, <?php echo e($variant->is_default ? 'true' : 'false'); ?>, '<?php echo e($variant->image ? asset('storage/' . $variant->image) : ''); ?>')">
                        <i class="fas fa-edit"></i> Sửa
                    </button>
                    
                    
                    <button type="button" 
                            class="btn btn-sm btn-danger"
                            onclick="deleteVariant(<?php echo e($variant->id); ?>)">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div style="text-align: center; padding: 60px 20px;">
    <i class="fas fa-box-open" style="font-size: 64px; color: #ddd;"></i>
    <p style="color: #999; margin-top: 20px; font-size: 16px;">
        Chưa có biến thể nào cho sản phẩm này.
    </p>
    <p style="color: #666;">
        Hãy thêm biến thể đầu tiên bằng form ở trên!
    </p>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/products/partials/variants-table.blade.php ENDPATH**/ ?>