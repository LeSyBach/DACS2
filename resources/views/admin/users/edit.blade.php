{{-- FILE: resources/views/admin/users/edit.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Chỉnh sửa Tài khoản: ' . $user->name)

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Chỉnh sửa Tài khoản</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="admin-table-card">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')

                    {{-- THÔNG TIN CƠ BẢN --}}
                    <div class="form-section">
                        <h2 class="section-sub-heading">
                            <i class="fas fa-user"></i> Thông tin cơ bản
                        </h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Họ và Tên <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-input @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" 
                                           required
                                           placeholder="Nhập họ và tên">
                                </div>
                                @error('name') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="form-input @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" 
                                           required
                                           placeholder="Nhập địa chỉ email">
                                </div>
                                @error('email') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    Số điện thoại
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="text" 
                                           name="phone" 
                                           id="phone" 
                                           class="form-input @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="Nhập số điện thoại">
                                </div>
                                @error('phone') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role" class="form-label">
                                    Quyền hạn <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-user-shield"></i>
                                    </span>
                                    <select name="role" 
                                            id="role" 
                                            class="form-input @error('role') is-invalid @enderror" 
                                            required>
                                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                    </select>
                                </div>
                                @error('role') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">
                                Địa chỉ
                            </label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3" 
                                          class="form-input @error('address') is-invalid @enderror"
                                          placeholder="Nhập địa chỉ đầy đủ">{{ old('address', $user->address) }}</textarea>
                            </div>
                            @error('address') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    {{-- ĐỔI MẬT KHẨU --}}
                    <div class="form-section">
                        <h2 class="section-sub-heading">
                            <i class="fas fa-lock"></i> Đổi mật khẩu
                        </h2>
                        <div class="alert-info">
                            <i class="fas fa-info-circle"></i>
                            <span>Để trống nếu không muốn thay đổi mật khẩu</span>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    Mật khẩu mới
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" 
                                           name="new_password" 
                                           id="new_password" 
                                           class="form-input @error('new_password') is-invalid @enderror"
                                           placeholder="Nhập mật khẩu mới">
                                </div>
                                @error('new_password') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">
                                    Xác nhận mật khẩu
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                    <input type="password" 
                                           name="new_password_confirmation" 
                                           id="new_password_confirmation" 
                                           class="form-input"
                                           placeholder="Nhập lại mật khẩu mới">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary">
                            <i class="fas fa-save"></i> Cập nhật Tài khoản
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn--secondary">
                            <i class="fas fa-times"></i> Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Form Sections */
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid var(--admin-border-color);
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--admin-text-color);
            margin-bottom: 8px;
            font-size: 14px;
        }

        /* Input Error */
        .input-error {
            display: block;
            color: var(--admin-danger);
            font-size: 13px;
            margin-top: 5px;
        }

        .input-error i {
            margin-right: 4px;
        }

        /* Alert Info */
        .alert-info {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0c5460;
            font-size: 14px;
        }

        .alert-info i {
            font-size: 18px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn--secondary {
            background: var(--admin-secondary);
            color: #fff;
            box-shadow: 0 2px 5px rgba(96, 125, 139, 0.3);
        }

        .btn--secondary:hover {
            background: #546e7a;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(96, 125, 139, 0.4);
        }

        /* Section Sub Heading với icon */
        .section-sub-heading i {
            margin-right: 8px;
            color: var(--admin-primary);
        }

        /* Textarea trong input-wrapper */
        .input-wrapper textarea.form-input {
            min-height: 80px;
            resize: vertical;
            padding: 14px 10px;
        }

        /* Select trong input-wrapper */
        .input-wrapper select.form-input {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection