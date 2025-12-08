{{-- FILE: resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị</title>
    
    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin_styles.css') }}">
</head>
<body>
    <div class="admin-login-container">
        {{-- CARD: LOGIN-FORM --}}
        <div class="login-form">
            
            <div class="login-form__header">
                {{-- Icon Khóa --}}
                <div class="login-form__icon-wrapper">
                    <i class="fa-solid fa-lock login-form__icon"></i>
                </div>
                
                <h1 class="login-form__title">Đăng nhập Admin</h1>
                <p class="login-form__subtitle">Vui lòng đăng nhập để truy cập quản trị viên</p>
            </div>
            
            {{-- Hiển thị thông báo lỗi --}}
            @error('email') 
                <div class="alert">{{ $message }}</div> 
            @enderror
            @error('password') 
                <div class="alert">{{ $message }}</div> 
            @enderror

            <form method="POST" action="{{ route('admin.login.post') }}" class="login-form__body">
                @csrf
                
                {{-- Email --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user input-wrapper__icon"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-input" 
                               placeholder="Nhập email đăng nhập" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                    </div>
                </div>
                
                {{-- Mật khẩu --}}
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
                
                {{-- Nút Đăng nhập --}}
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>
        </div>
    </div>
</body>
</html>