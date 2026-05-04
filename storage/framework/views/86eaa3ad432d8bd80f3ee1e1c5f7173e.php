
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Admin | <?php echo $__env->yieldContent('title'); ?> - TechStore</title>
    
    
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin_styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/grid.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/base.css')); ?>">


    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div id="admin-wrapper">
        
        
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
        
        <div id="content-wrapper">
            
            <?php echo $__env->make('admin.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

            <main class="admin-main-content">
                
                <div class="container-fluid admin-content-padding">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
            
            
            <?php echo $__env->make('admin.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
        </div>
    </div>
    
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/layouts/guest.blade.php ENDPATH**/ ?>