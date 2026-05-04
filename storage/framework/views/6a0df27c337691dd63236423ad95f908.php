
 

<?php $__env->startSection('title', 'Lỗi 404 - Không tìm thấy trang'); ?>

<?php $__env->startSection('content'); ?>
    <div class="error-page-container">
        <div class="error-card">
            
            <span class="error-code">404</span>
            
            <h1 class="error-heading">Rất tiếc! Không tìm thấy trang này.</h1>
            
            <p class="error-message">
                Liên kết bạn truy cập có thể đã bị hỏng, bị xóa hoặc không còn tồn tại.
            </p>
            
            <div class="error-actions">
                <a href="<?php echo e(route('index')); ?>" class="btn btn-primary btn-home">
                    <i class="fa-solid fa-house"></i> Quay lại Trang chủ
                </a>
                
                
                <a href="<?php echo e(route('product')); ?>" class="btn btn-secondary btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Xem Sản phẩm
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/errors.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/errors/404.blade.php ENDPATH**/ ?>