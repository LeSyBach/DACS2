


<?php $__env->startSection('title', 'Chi tiết Đơn hàng #' . $order->id); ?>

<?php $__env->startSection('content'); ?>
    
    
    <?php
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login'); 
        }
        // Tính toán Tạm tính (Subtotal)
        $shipping_fee = 30000;
        $subtotal = $order->total_price - $shipping_fee; 
    ?>

    
    <div class="page-header-actions">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Quay lại Danh sách
        </a>
    </div>

    <h1 class="admin-page-heading">Chi tiết Đơn hàng #<?php echo e($order->id); ?></h1>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="order-detail-layout mb-4">
        
        <div class="order-detail-main">
            <div class="admin-table-card">
                <div class="card-header-custom">
                    <i class="fas fa-user-circle"></i>
                    <h3 class="card-title">Thông tin Khách hàng & Giao hàng</h3>
                </div>
                <div class="card-body-custom">
                    <div class="info-grid">
                        <div class="info-item">
                            <label><i class="fas fa-user"></i> Tên Khách hàng:</label>
                            <span><?php echo e($order->customer_name); ?></span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-calendar"></i> Ngày đặt:</label>
                            <span><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-envelope"></i> Email:</label>
                            <span><?php echo e($order->customer_email); ?></span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-map-marker-alt"></i> Địa chỉ:</label>
                            <span><?php echo e($order->shipping_address); ?></span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-phone"></i> Điện thoại:</label>
                            <span><?php echo e($order->customer_phone); ?></span>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-sticky-note"></i> Ghi chú:</label>
                            <span><?php echo e($order->note ?? 'Không có'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="order-detail-sidebar">
            <div class="admin-table-card">
                <div class="card-header-custom">
                    <i class="fas fa-info-circle"></i>
                    <h3 class="card-title">Trạng thái Đơn hàng</h3>
                </div>
                <div class="card-body-custom">
                    <div class="status-info">
                        <div class="status-item">
                            <label>Trạng thái ĐH:</label>
                            <span class="badge status-<?php echo e($order->status); ?>">
                                <?php echo e(strtoupper($order->status)); ?>

                            </span>
                        </div>
                        <div class="status-item">
                            <label>Trạng thái TT:</label>
                            <span class="badge status-<?php echo e($order->payment_status == 'paid' ? 'success' : 'warning'); ?>">
                                <?php echo e(strtoupper($order->payment_status)); ?>

                            </span>
                        </div>
                        <div class="status-item">
                            <label>Phương thức TT:</label>
                            <span class="payment-method"><?php echo e(strtoupper($order->payment_method)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="admin-table-card mb-4">
        <div class="card-header-custom">
            <i class="fas fa-boxes-stacked"></i>
            <h3 class="card-title">Sản phẩm đã mua</h3>
        </div>
        <div class="card-body-custom p-0">
            <div class="order-list-table">
                <table class="table order-table order-detail-table">
                    <thead>
                        <tr>
                            <th>Tên Sản phẩm</th>
                            <th>Đơn Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="Tên SP"><?php echo e($item->product_name); ?></td>
                                <td data-label="Đơn giá" class="price-col"><?php echo e(number_format($item->price, 0, ',', '.')); ?>₫</td>
                                <td data-label="SL"><?php echo e($item->quantity); ?></td>
                                <td data-label="Thành tiền" class="price-col"><?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?>₫</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tạm tính:</strong></td>
                            <td class="price-col"><?php echo e(number_format($subtotal, 0, ',', '.')); ?>₫</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Phí Vận chuyển:</strong></td>
                            <td class="price-col"><?php echo e(number_format($shipping_fee, 0, ',', '.')); ?>₫</td>
                        </tr>
                        <tr class="grand-total-row">
                            <td colspan="3" class="text-right"><strong>TỔNG THANH TOÁN:</strong></td>
                            <td class="grand-total-price"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?>₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    
    <div class="order-detail-layout">
        
        <div class="order-detail-main">
            <div class="admin-table-card">
                <div class="card-header-custom card-header-primary">
                    <i class="fas fa-arrows-rotate"></i>
                    <h3 class="card-title">Cập nhật Trạng thái</h3>
                </div>
                <div class="card-body-custom">
                    <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="status" class="form-label">Chuyển Trạng thái:</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </span>
                                <select name="status" id="status" class="form-input" required>
                                    <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Đang chờ xử lý</option>
                                    <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Đang xử lý</option>
                                    <option value="shipped" <?php echo e($order->status == 'shipped' ? 'selected' : ''); ?>>Đã giao hàng</option>
                                    <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>Đã hoàn thành</option>
                                    <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary btn--block mt-3">
                            <i class="fas fa-check"></i> Cập nhật
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="order-detail-sidebar">
            <?php if($order->status == 'pending'): ?>
                <div class="admin-table-card">
                    <div class="card-header-custom card-header-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3 class="card-title">Hành động</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="action-buttons">
                            
                            <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="btn btn-success btn--block">
                                    <i class="fas fa-check-circle"></i> Duyệt hóa đơn
                                </button>
                            </form>
                            
                            
                            <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" class="mt-3">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn--block" onclick="return confirm('Bạn có chắc chắn muốn HỦY đơn hàng này không?')">
                                    <i class="fas fa-times-circle"></i> Hủy đơn hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="admin-table-card">
                    <div class="card-header-custom">
                        <i class="fas fa-info-circle"></i>
                        <h3 class="card-title">Thông báo</h3>
                    </div>
                    <div class="card-body-custom">
                        <p style="text-align: center; color: #666; padding: 20px 0;">
                            Đơn hàng đã được xử lý
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>