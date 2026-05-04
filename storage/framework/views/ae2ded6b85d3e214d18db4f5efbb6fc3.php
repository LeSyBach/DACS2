
 

<?php $__env->startSection('title', 'Thanh toán - Bước 1: Thông tin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="checkout-wrapper grid wide">
        
        <a href="<?php echo e(route('index')); ?>" class="back-link">
            ← Quay lại
        </a>

        <?php echo $__env->make('checkout.steps', ['step' => 1], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

        <form method="POST" action="<?php echo e(route('checkout.process_info')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="row checkout-main-row">
                
                <div class="col c-12 l-7">
                    <div class="checkout-card info-card">
                        <h2 class="card-title">Thông tin giao hàng</h2>
                        
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                        <?php endif; ?>
                        
                        <div class="row info-form-row">
                            
                            
                            <div class="col c-12 m-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Họ và tên *</label>
                                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $defaultData->name)); ?>" required class="form-input">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col c-12 m-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Số điện thoại *</label>
                                    <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $defaultData->phone)); ?>" required class="form-input">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col c-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $defaultData->email)); ?>" required class="form-input">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col c-12">
                                <div class="form-group">
                                    <label for="address" class="form-label">Địa chỉ giao hàng *</label>
                                    <textarea name="address" id="address" required rows="2" class="form-input form-textarea"><?php echo e(old('address', $defaultData->address)); ?></textarea>
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-continue">Tiếp tục thanh toán</button>
                    </div>
                </div>

                
                <div class="col c-12 l-5">
                    <?php echo $__env->make('checkout.summary', ['cartItems' => $cartItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/checkout_styles.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/checkout/information.blade.php ENDPATH**/ ?>