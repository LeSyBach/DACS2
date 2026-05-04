

<div class="category-section">
    <div class="grid wide">
        <h2 class="category-heading">Danh mục sản phẩm</h2>
        <p class="category-subtitle">
            Khám phá các danh mục sản phẩm công nghệ đa dạng với chất lượng cao
        </p>

        <div class="row">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col l-2 m-4 c-6">
                <a href="" class="category-card">
                    <div class="category-icon">
                        <i class="fas <?php echo e($category->icon); ?>"></i>
                    </div>
                    <h3><?php echo e($category->name); ?></h3>
                    <p><?php echo e($category->products_count); ?> sản phẩm</p>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\techstore\resources\views/home/category-section.blade.php ENDPATH**/ ?>