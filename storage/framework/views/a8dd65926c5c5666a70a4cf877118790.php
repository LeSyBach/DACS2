
 

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="l-12">
        <h1 class="admin-page-heading">Tổng quan Hệ thống</h1>
        
        
        <div class="admin-stats-row">
            
            
            <?php echo $__env->make('admin.partials.stat_card', [
                'title' => 'Đơn Hàng Đang Chờ', 
                'value' => number_format($pendingOrders), 
                'icon' => 'fa-bell', 
                'color' => 'orange'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            
            <?php echo $__env->make('admin.partials.stat_card', [
                'title' => 'Doanh Thu Đã TT', 
                'value' => number_format($totalRevenue, 0, ',', '.') . ' ₫',
                'icon' => 'fa-dollar-sign',
                'color' => 'blue'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            
            <?php echo $__env->make('admin.partials.stat_card', [
                'title' => 'Tổng Khách Hàng', 
                'value' => number_format($totalCustomers),
                'icon' => 'fa-users',
                'color' => 'green'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <?php echo $__env->make('admin.partials.stat_card', [
                'title' => 'Tổng Số Đơn', 
                'value' => number_format($totalOrders),
                'icon' => 'fa-receipt',
                'color' => 'teal'
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        
        
        <h2 class="section-sub-heading">Thống kê Sản phẩm theo Danh mục</h2>
        <div class="admin-category-stats">
            
            <?php
                // Mảng màu sắc luân phiên
                $colors = ['green', 'blue', 'orange', 'teal', 'purple', 'red'];
                $i = 0;
            ?>
            
            <?php $__currentLoopData = $categoryStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('admin.partials.stat_card', [
                    'title' => $category->name, 
                    'value' => number_format($category->products_count),
                    'icon' => 'fa-box',
                    'color' => $colors[$i++ % count($colors)]
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </div>
        
        
        
        
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>