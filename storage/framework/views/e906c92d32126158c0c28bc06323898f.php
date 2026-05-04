
<aside id="sidebar">
    <div class="sidebar__header">
        
        <h3>TechStore Admin</h3>
    </div>
    
    <ul class="sidebar__nav">
        
        
        <li class="nav-item">
            <a href="<?php echo e(route('admin.dashboard')); ?>" 
               class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-box-open"></i> Quản lý Đơn hàng
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-cube"></i> Quản lý Sản phẩm
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-tags"></i> Quản lý Danh mục
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-users-gear"></i> Quản lý Tài khoản
            </a>
        </li>
        
    </ul>
    
    
    <div class="sidebar__footer">
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-logout-sidebar">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>