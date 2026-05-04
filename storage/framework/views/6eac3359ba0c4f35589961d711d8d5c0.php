
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị</title>
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin_styles.css')); ?>">
</head>
<body>
    <div class="admin-login-container">
        
        <div class="login-form">
            
            <div class="login-form__header">
                
                <div class="login-form__icon-wrapper">
                    <i class="fa-solid fa-lock login-form__icon"></i>
                </div>
                
                <h1 class="login-form__title">Đăng nhập Admin</h1>
                <p class="login-form__subtitle">Vui lòng đăng nhập để truy cập quản trị viên</p>
            </div>
            
            
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <div class="alert"><?php echo e($message); ?></div> 
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <div class="alert"><?php echo e($message); ?></div> 
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <form method="POST" action="<?php echo e(route('admin.login.post')); ?>" class="login-form__body">
                <?php echo csrf_field(); ?>
                
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user input-wrapper__icon"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-input" 
                               placeholder="Nhập email đăng nhập" 
                               value="<?php echo e(old('email')); ?>" 
                               required 
                               autofocus>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-wrapper__icon"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-input" 
                               placeholder="Nhập mật khẩu" 
                               required>
                    </div>
                </div>
                
                
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/login.blade.php ENDPATH**/ ?>