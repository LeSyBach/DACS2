


<?php $__env->startSection('title', 'Quản lý Danh mục'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Danh sách Danh mục</h1>
            
            <div class="page-header-actions">
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn--primary">
                    <i class="fas fa-plus"></i> Thêm Danh mục mới
                </a>
            </div>
            
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="admin-table-card">
                <div class="order-list-table">
                    <table class="table order-table category-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Tên Danh mục</th>
                                <th>Slug (Đường dẫn)</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="ID"><?php echo e($category->id); ?></td>
                                    <td data-label="Icon">
                                        <div class="category-icon">
                                            <i class="fas <?php echo e($category->icon); ?>"></i>
                                        </div>
                                    </td>
                                    <td data-label="Tên Danh mục"><?php echo e($category->name); ?></td>
                                    <td data-label="Slug">
                                        <span class="badge status-secondary"><?php echo e($category->slug); ?></span>
                                    </td>
                                    <td data-label="Hành động">
                                        <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa danh mục này sẽ ảnh hưởng đến các sản phẩm liên quan. Bạn có chắc chắn?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-links mt-4">
                    <?php echo e($categories->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>