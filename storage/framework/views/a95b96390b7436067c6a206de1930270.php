
 

<?php $__env->startSection('title', 'Chỉnh sửa hồ sơ'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid wide profile-page-wrapper">
        <div class="row no-gutters"> 
            <div class="col c-12 m-12 l-12 no-padding"> 
                
                
                <div class="profile-edit-card">
                    
                    <h1 class="main-heading">
                        <i class="fa-regular fa-user"></i> QUẢN LÝ TÀI KHOẢN
                    </h1>
                    
                    
                    
                    
                    
                    

                    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <div class="section-group info-group">
                            <h2 class="section-heading primary-color">
                                <i class="fa-solid fa-address-card"></i> CẬP NHẬT HỒ SƠ
                            </h2>

                            <div class="row">
                                
                                
                                <div class="col c-12 m-6 l-4">
                                    <div class="form-input-group">
                                        <label for="name">Họ và Tên <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required class="form-input">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-input-group">
                                        <label for="phone">Điện thoại</label>
                                        <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="form-input">
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
                                
                                
                                <div class="col c-12 m-6 l-4">
                                    <div class="form-input-group">
                                        <label for="email">Email <span class="required">*</span></label>
                                        <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required class="form-input">
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
                                
                                
                                <div class="col c-12 l-4">
                                    <div class="form-input-group">
                                        <label for="address">Địa chỉ chi tiết (Giao hàng) <span class="required">*</span></label>
                                        <textarea name="address" id="address" required rows="6" class="form-textarea"><?php echo e(old('address', $user->address)); ?></textarea>
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
                        </div>

                        <button type="reset" class="btn btn-secondary btn-reset"
                                style="background-color: #6c757d; color: white; padding: 12px 25px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; transition: background-color 0.3s;"
                                onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                            <i class="fa-solid fa-rotate-left" style="margin-right: 8px;"></i> HỦY THAY ĐỔI
                        </button>
                        
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="fa-solid fa-save"></i> CẬP NHẬT THÔNG TIN
                        </button>
                        
                    </form> 


                    
                    
                    <form method="POST" action="<?php echo e(route('profile.password')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="section-group password-group">
                            <h2 class="section-heading danger-color">
                                <i class="fa-solid fa-lock"></i> ĐỔI MẬT KHẨU
                            </h2>

                            <div class="row">
                                
                                <div class="col c-12 m-6 l-6">
                                    <div class="form-input-group">
                                        <label for="new_password">Mật khẩu mới</label>
                                        <input type="password" name="new_password" id="new_password" class="form-input">
                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="input-error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                
                                <div class="col c-12 m-6 l-6">
                                    <div class="form-input-group">
                                        <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input">
                                        <?php $__errorArgs = ['new_password_confirmation'];
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
                            
                            <button type="submit" class="btn btn-danger btn-change-password">
                                <i class="fa-solid fa-arrows-rotate"></i> THAY ĐỔI MẬT KHẨU
                            </button>
                        </div>
                    </form> 
                    
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/edit.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/profile/edit.blade.php ENDPATH**/ ?>