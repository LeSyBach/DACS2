<?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $statusMap = [
            'pending' => ['label' => 'Chưa duyệt', 'class' => 'warning'],
            'processing' => ['label' => 'Đang xử lý', 'class' => 'secondary'],
            'shipped' => ['label' => 'Đang giao', 'class' => 'info'],
            'completed' => ['label' => 'Hoàn thành', 'class' => 'success'],
            'cancelled' => ['label' => 'Đã hủy', 'class' => 'danger'],
        ];
        
        $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'secondary'];
    ?>

    <tr class="order-row">
        <td data-label="Mã ĐH">#<?php echo e($order->id); ?></td>
        <td data-label="Tên KH"><?php echo e($order->customer_name); ?></td>
        <td data-label="Ngày đặt"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
        <td data-label="Tổng tiền" class="price-col"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?>₫</td>
        <td data-label="Địa chỉ"><?php echo e(Str::limit($order->shipping_address, 30)); ?></td>
        <td data-label="SĐT"><?php echo e($order->customer_phone); ?></td>

        <td data-label="Trạng thái">
            <span class="badge status-<?php echo e($status['class']); ?>">
                <?php echo e($status['label']); ?>

            </span>
        </td>

        <td data-label="Hành động">
            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i> Xem
            </a>
            <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="8" style="text-align: center; padding: 40px;">
            <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
            <p style="color: #999; font-size: 16px;">
                <?php if(request('search') || request('status')): ?>
                    Không tìm thấy đơn hàng nào phù hợp
                <?php else: ?>
                    Chưa có đơn hàng nào
                <?php endif; ?>
            </p>
        </td>
    </tr>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/orders/partials/table_rows.blade.php ENDPATH**/ ?>