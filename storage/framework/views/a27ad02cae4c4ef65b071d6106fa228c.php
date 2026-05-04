
<div class="modal auth-modal 
    <?php if(!$errors->any() && !session('show_forgot') && !session('show_otp_page') && !session('show_login_modal')): ?> 
        hidden 
    <?php endif; ?>"
    data-has-error="<?php if($errors->any() || session('show_forgot') || session('show_otp_page') || session('show_login_modal')): ?> true <?php else: ?> false <?php endif; ?>">
    <div class="modal__overlay"></div>

    <div class="modal__body">
        <div class="auth-container">

            
            <div class="auth-form auth-form--register 
                <?php if(!$errors->has('name') && !$errors->has('password_confirmation')): ?> 
                    hidden 
                <?php endif; ?>">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng ký</h3>
                    <span class="auth-form__note">Tạo tài khoản mới để trải nghiệm TechStore</span>
                </div>
                <form class="auth-form__form" method="POST" action="<?php echo e(route('register.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-user"></i>
                        <input type="text" name="name" class="auth-form__input" placeholder="Họ và Tên" value="<?php echo e(old('name')); ?>">
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email của bạn" value="<?php echo e(old('email')); ?>">
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu">
                    </div>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu">
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit" class="auth-form__input-submit">Đăng ký</button>
                </form>
                <div class="auth-form__switch">
                    <span>Bạn đã có tài khoản?</span>
                    <a href="#" class="auth-form__switch-link switch-to-login">Đăng nhập</a>
                </div>
            </div>

            
            <div class="auth-form auth-form--login 
                <?php if($errors->has('name') || $errors->has('password_confirmation') || session('show_forgot') || session('show_otp_page')): ?> 
                    hidden 
                <?php endif; ?>">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng Nhập</h3>
                    <span class="auth-form__note">Chào mừng bạn quay trở lại TechStore!</span>
                </div>
                <form class="auth-form__form" method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email của bạn" value="<?php echo e(old('email')); ?>">
                    </div>
                    

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu">
                    </div>

                    <div class="auth-form__remember-forgot">
                        <div class="auth-form__input-group--remember">
                            <input type="checkbox" name="remember" class="auth-form__remember-checkbox">
                            <label class="auth-form__remember-label">Ghi nhớ đăng nhập</label>
                        </div>
                        <div class="auth-form__forgot-password">
                            <a href="#" class="auth-form__forgot-password-link switch-to-forgot">
                                Quên mật khẩu
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="auth-form__input-submit">Đăng nhập</button>
                </form>
                <div class="auth-form__switch">
                    <span>Bạn chưa có tài khoản?</span>
                    <a href="#" class="auth-form__switch-link switch-to-register">Đăng ký</a>
                </div>
            </div>

            <div class="auth-form auth-form--forgot <?php if(!session('show_forgot') || session('show_otp_page')): ?> hidden <?php endif; ?>">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Quên Mật Khẩu?</h3>
                    <span class="auth-form__note">Nhập email để nhận mã đặt lại mật khẩu</span>
                </div>
                <form class="auth-form__form" method="POST" action="<?php echo e(route('password.email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email đăng ký" value="<?php echo e(old('email')); ?>">
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit" class="auth-form__input-submit">Gửi mã đặt lại</button>
                </form>
                <div class="auth-form__switch">
                    <a href="#" class="auth-form__switch-link switch-to-login-from-forgot">Quay lại đăng nhập</a>
                </div>
            </div>

            <div class="auth-form auth-form--otp-newpass <?php if(!session('show_otp_page')): ?> hidden <?php endif; ?>">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đặt lại mật khẩu</h3>
                    <span class="auth-form__note">Nhập mã OTP và mật khẩu mới</span>
                </div>

                <form class="auth-form__form form-reset-password" method="POST" action="<?php echo e(route('password.update')); ?>">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="email" id="reset-email-input" value="<?php echo e(old('email')); ?>"> 

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-shield-halved"></i>
                        <input type="text" name="otp" class="auth-form__input" placeholder="Nhập mã OTP">
                    </div>
                    <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu mới">
                    </div>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu">
                    </div>

                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:red"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit" class="auth-form__input-submit">Xác nhận</button>
                </form>

                <div class="auth-form__switch">
                    <a href="#" class="auth-form__switch-link switch-to-forgot">Quay lại</a>
                </div>
            </div>


        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\techstore\resources\views/partials/auth_modal.blade.php ENDPATH**/ ?>