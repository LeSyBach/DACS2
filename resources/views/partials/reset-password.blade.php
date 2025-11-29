{{-- FORM 4: ĐẶT LẠI MẬT KHẨU (OTP + NEW PASS) --}}
            <div class="auth-form auth-form--reset-pass hidden">
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Xác nhận và Đặt lại</h3>
                    <span class="auth-form__note" id="otp-status-message">Vui lòng nhập mã OTP và mật khẩu mới.</span>
                </div>
                {{-- Action: Gửi dữ liệu OTP + Pass mới để Controller reset DB --}}
                <form class="auth-form__form ajax-reset-form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    
                    {{-- Input ẩn chứa Email đã nhập (sẽ được JS điền vào) --}}
                    <input type="hidden" name="email" id="reset-pass-email-input"> 
                    
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-key"></i>
                        <input type="text" name="otp" class="auth-form__input" placeholder="Mã OTP (6 chữ số)" required>
                    </div>
                    @error('otp') <span style="color: red; font-size: 1.2rem; display: block;">{{ $message }}</span> @enderror


                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password" class="auth-form__input" placeholder="Mật khẩu mới" required>
                    </div>
                    
                    <div class="auth-form__input-group">
                        <i class="auth-form__input-icon fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" class="auth-form__input" placeholder="Nhập lại mật khẩu mới" required>
                    </div>
                    @error('password') <span style="color: red; font-size: 1.2rem; display: block;">{{ $message }}</span> @enderror

                    <button type="submit" class="auth-form__input-submit">Đặt lại mật khẩu</button>
                </form>
                <div class="auth-form__switch">
                    <a href="#" class="auth-form__switch-link switch-to-forgot">Gửi lại mã OTP?</a>
                </div>
            </div>