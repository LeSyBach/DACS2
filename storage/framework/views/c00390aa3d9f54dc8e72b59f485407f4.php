
 

<?php $__env->startSection('title', 'Chi tiết Đơn hàng #' . $order->id); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid wide customer-order-wrapper">
        <div class="row">
            <div class="col c-12 m-12 l-12"> 
                
                <div class="customer-order-detail-card">
                    
                    <div class="customer-detail-header">
                        <h1 class="customer-order-heading">
                            <i class="fa-solid fa-receipt"></i> CHI TIẾT ĐƠN HÀNG #<?php echo e($order->id); ?>

                        </h1>
                        
                        <a href="<?php echo e(route('orders')); ?>" class="customer-btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <?php
                        $orderStatusMap = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang chuẩn bị',
                            'shipped' => 'Đang giao',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy',
                        ];

                        $paymentStatusMap = [
                            'pending' => 'Chờ thanh toán',
                            'unpaid' => 'Chưa thanh toán',
                            'paid' => 'Đã thanh toán',
                            'failed' => 'Thất bại',
                        ];

                        $paymentMethodMap = [
                            'cod' => 'Thanh toán khi nhận hàng (COD)',
                            'zalopay' => 'ZaloPay',
                        ];

                        $getTranslated = function ($key, $map) {
                            return $map[$key] ?? strtoupper($key);
                        };

                        $orderStatusKey = $order->status;
                        $paymentStatusKey = $order->payment_status;
                        $paymentMethodKey = $order->payment_method;
                        
                        $shippingFee = 30000;
                        $subtotal = $order->total_price - $shippingFee;
                    ?>

                    
                    <div class="customer-order-tracking">
                        <div class="customer-tracking-step <?php echo e(in_array($orderStatusKey, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : ''); ?>">
                            <div class="customer-step-icon"><i class="fas fa-clipboard-check"></i></div>
                            <div class="customer-step-label">Đã đặt</div>
                        </div>
                        <div class="customer-tracking-step <?php echo e(in_array($orderStatusKey, ['processing', 'shipped', 'completed']) ? 'active' : ''); ?>">
                            <div class="customer-step-icon"><i class="fas fa-box"></i></div>
                            <div class="customer-step-label">Chuẩn bị</div>
                        </div>
                        <div class="customer-tracking-step <?php echo e(in_array($orderStatusKey, ['shipped', 'completed']) ? 'active' : ''); ?>">
                            <div class="customer-step-icon"><i class="fas fa-shipping-fast"></i></div>
                            <div class="customer-step-label">Đang giao</div>
                        </div>
                        <div class="customer-tracking-step <?php echo e($orderStatusKey === 'completed' ? 'active' : ''); ?>">
                            <div class="customer-step-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="customer-step-label">Hoàn thành</div>
                        </div>
                    </div>

                    
                    <div class="customer-detail-section">
                        <div class="row">
                            <div class="col c-12 m-6 l-6">
                                <div class="customer-info-box">
                                    <h2 class="customer-section-title">
                                        <i class="fas fa-info-circle"></i> Thông tin đơn hàng
                                    </h2>
                                    <div class="customer-info-content">
                                        <div class="customer-info-row">
                                            <label><i class="far fa-calendar"></i> Ngày đặt:</label>
                                            <span><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-credit-card"></i> Thanh toán:</label>
                                            <span><?php echo e($getTranslated($paymentMethodKey, $paymentMethodMap)); ?></span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-box"></i> Trạng thái:</label>
                                            <span class="customer-badge customer-status-<?php echo e($orderStatusKey); ?>">
                                                <?php echo e($getTranslated($orderStatusKey, $orderStatusMap)); ?>

                                            </span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-money-bill-wave"></i> TT Thanh toán:</label>
                                            <span class="customer-badge customer-payment-<?php echo e($paymentStatusKey); ?>">
                                                <?php echo e($getTranslated($paymentStatusKey, $paymentStatusMap)); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col c-12 m-6 l-6">
                                <div class="customer-info-box">
                                    <h2 class="customer-section-title">
                                        <i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng
                                    </h2>
                                    <div class="customer-info-content">
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-user"></i> Người nhận:</label>
                                            <span><?php echo e($order->customer_name); ?></span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-phone"></i> Điện thoại:</label>
                                            <span><?php echo e($order->customer_phone); ?></span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-envelope"></i> Email:</label>
                                            <span><?php echo e($order->customer_email); ?></span>
                                        </div>
                                        <div class="customer-info-row">
                                            <label><i class="fas fa-map-marked-alt"></i> Địa chỉ:</label>
                                            <span><?php echo e($order->shipping_address); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
<div class="customer-detail-section">
    <h2 class="customer-section-title">
        <i class="fas fa-shopping-bag"></i> Sản phẩm đã mua
    </h2>
    
    <div class="customer-products-summary-wrapper">
        
        <div class="customer-products-list">
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="customer-product-item">
                    <div class="customer-product-image">
                        <?php
                            $image = $item->variant ? $item->variant->image_url : $item->product->image_url;
                        ?>
                        <img src="<?php echo e($image); ?>" 
                             alt="<?php echo e($item->product->name); ?>" 
                             onerror="this.src='<?php echo e(asset('images/placeholder.png')); ?>'">
                    </div>
                    <div class="customer-product-info">
                        <h3 class="customer-product-name">
                            <?php echo e($item->product_name); ?>

                            <?php if($item->variant): ?>
                                <span class="variant-badge" style="font-size: 0.85em; color: #666; font-weight: normal; display: block; margin-top: 4px;">
                                    <i class="fa-solid fa-tag"></i> <?php echo e($item->variant->display_name); ?>

                                </span>
                            <?php endif; ?>
                        </h3>
                        <div class="customer-product-meta">
                            <span class="customer-product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>₫</span>
                            <span class="customer-product-qty">x <?php echo e($item->quantity); ?></span>
                        </div>
                        
                        
                        <?php if($order->status === 'completed' && $order->payment_status === 'paid'): ?>
                            <?php
                                $userReviewed = App\Models\Review::userReviewed(auth()->id(), $item->product_id);
                            ?>
                            
                            <?php if(!$userReviewed): ?>
                                <button class="btn-review-product" onclick="openReviewModalForProduct(<?php echo e($item->product_id); ?>, '<?php echo e(addslashes($item->product_name)); ?>')">
                                    <i class="fas fa-star"></i> Đánh giá sản phẩm
                                </button>
                            <?php else: ?>
                                <span class="reviewed-badge">
                                    <i class="fas fa-check-circle"></i> Đã đánh giá
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="customer-product-total">
                        <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?>₫
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="customer-summary-box">
            <div class="customer-summary-row">
                <span>Tạm tính:</span>
                <span><?php echo e(number_format($subtotal, 0, ',', '.')); ?>₫</span>
            </div>
            <div class="customer-summary-row">
                <span>Phí vận chuyển:</span>
                <span><?php echo e(number_format($shippingFee, 0, ',', '.')); ?>₫</span>
            </div>
            <div class="customer-summary-divider"></div>
            <div class="customer-summary-row customer-grand-total">
                <span>TỔNG THANH TOÁN:</span>
                <span class="customer-total-price"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?>₫</span>
            </div>
        </div>
    </div>
</div>
                    
                </div>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make('reviews.partials.review-modal-dynamic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/oder.css')); ?>">
    <style>
    .btn-review-product {
        background: #0066cc;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        margin-top: 8px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-review-product:hover {
        background: #0052a3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
    }
    
    .reviewed-badge {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        margin-top: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .reviewed-badge i {
        color: #4caf50;
    }
    </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/profile/order_detail.blade.php ENDPATH**/ ?>