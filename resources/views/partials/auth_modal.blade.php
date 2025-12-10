{{-- FILE: resources/views/partials/auth_modal.blade.php --}}
{{-- Đã sửa logic kiểm tra lỗi để tránh xung đột hiển thị --}}
<div class="modal auth-modal 
    @if(!$errors->any() && !session('show_forgot') && !session('show_otp_page') && !session('show_login_modal')) 
        hidden 
    @endif"
    data-has-error="@if($errors->any() || session('show_forgot') || session('show_otp_page') || session('show_login_modal')) true @else false @endif">
    <div class="modal__overlay"></div>

    <div class="modal__body">
        <div class="auth-container">

            {{-- CHỈ HIỂN THỊ ĐĂNG KÝ nếu có lỗi Đăng ký cụ thể (name, hoặc password_confirmation không khớp) --}}
            <div class="auth-form auth-form--register 
                @if(!$errors->has('name') && !$errors->has('password_confirmation')) 
                    hidden 
                @endif">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng ký</h3>
                    <span class="auth-form__note">Tạo tài khoản mới để trải nghiệm TechStore</span>
                </div>
                <form class="auth-form__form" method="POST" action="{{ route('register.post') }}">
                    @csrf
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-user"></i>
                        <input type="text" name="name" class="auth-form__input" placeholder="Họ và Tên" value="{{ old('name') }}">
                    </div>
                    @error('name') <span style="color:red">{{ $message }}</span> @enderror

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email của bạn" value="{{ old('email') }}">
                    </div>
                    @error('email') <span style="color:red">{{ $message }}</span> @enderror

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu">
                    </div>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu">
                    </div>
                    @error('password') <span style="color:red">{{ $message }}</span> @enderror

                    <button type="submit" class="auth-form__input-submit">Đăng ký</button>
                </form>
                <div class="auth-form__switch">
                    <span>Bạn đã có tài khoản?</span>
                    <a href="#" class="auth-form__switch-link switch-to-login">Đăng nhập</a>
                </div>
            </div>

            {{-- ẨN ĐĂNG NHẬP nếu có lỗi Đăng ký cụ thể HOẶC đang ở trang Quên mật khẩu --}}
            <div class="auth-form auth-form--login 
                @if($errors->has('name') || $errors->has('password_confirmation') || session('show_forgot') || session('show_otp_page')) 
                    hidden 
                @endif">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đăng Nhập</h3>
                    <span class="auth-form__note">Chào mừng bạn quay trở lại TechStore!</span>
                </div>
                <form class="auth-form__form" method="POST" action="{{ route('login.post') }}">
                    @csrf
                    @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email của bạn" value="{{ old('email') }}">
                    </div>
                    {{-- @error('email') <span style="color:red">{{ $message }}</span> @enderror --}}

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

            <div class="auth-form auth-form--forgot @if(!session('show_forgot') || session('show_otp_page')) hidden @endif">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Quên Mật Khẩu?</h3>
                    <span class="auth-form__note">Nhập email để nhận mã đặt lại mật khẩu</span>
                </div>
                <form class="auth-form__form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="auth-form__input" placeholder="Email đăng ký" value="{{ old('email') }}">
                    </div>
                    @error('email') <span style="color:red">{{ $message }}</span> @enderror

                    <button type="submit" class="auth-form__input-submit">Gửi mã đặt lại</button>
                </form>
                <div class="auth-form__switch">
                    <a href="#" class="auth-form__switch-link switch-to-login-from-forgot">Quay lại đăng nhập</a>
                </div>
            </div>

            <div class="auth-form auth-form--otp-newpass @if(!session('show_otp_page')) hidden @endif">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Đặt lại mật khẩu</h3>
                    <span class="auth-form__note">Nhập mã OTP và mật khẩu mới</span>
                </div>

                <form class="auth-form__form form-reset-password" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="email" id="reset-email-input" value="{{ old('email') }}"> 

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-shield-halved"></i>
                        <input type="text" name="otp" class="auth-form__input" placeholder="Nhập mã OTP">
                    </div>
                    @error('otp') <span style="color:red">{{ $message }}</span> @enderror

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu mới">
                    </div>

                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu">
                    </div>

                    @error('password') <span style="color:red">{{ $message }}</span> @enderror

                    <button type="submit" class="auth-form__input-submit">Xác nhận</button>
                </form>

                <div class="auth-form__switch">
                    <a href="#" class="auth-form__switch-link switch-to-forgot">Quay lại</a>
                </div>
            </div>


        </div>
    </div>
</div>