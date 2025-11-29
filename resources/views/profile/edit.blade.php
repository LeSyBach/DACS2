{{-- FILE: resources/views/profile/edit.blade.php --}}
@extends('layouts.app') 

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
    
    <div class="grid wide profile-page-wrapper">
        <div class="row no-gutters"> 
            <div class="col c-12 m-12 l-12 no-padding"> 
                
                {{-- Khối chính (Card) --}}
                <div class="profile-edit-card">
                    
                    <h1 class="main-heading">
                        <i class="fa-regular fa-user"></i> QUẢN LÝ TÀI KHOẢN
                    </h1>
                    
                    {{-- Hiển thị thông báo thành công --}}
                    {{-- @if (session('success'))
                        <div class="alert success-alert">
                            {{ session('success') }}
                        </div>
                    @endif --}}
                    
                    
                    {{-- =============================================== --}}
                    {{-- 1. FORM CẬP NHẬT THÔNG TIN & ĐỊA CHỈ --}}
                    {{-- Gửi đến route('profile.update') --}}
                    {{-- =============================================== --}}
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        
                        <div class="section-group info-group">
                            <h2 class="section-heading primary-color">
                                <i class="fa-solid fa-address-card"></i> CẬP NHẬT HỒ SƠ
                            </h2>

                            <div class="row">
                                
                                {{-- Cột 1: Tên và Điện thoại (4/12) --}}
                                <div class="col c-12 m-6 l-4">
                                    <div class="form-input-group">
                                        <label for="name">Họ và Tên <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="form-input">
                                        @error('name') <span class="input-error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-input-group">
                                        <label for="phone">Điện thoại</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
                                        @error('phone') <span class="input-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                {{-- Cột 2: Email (4/12) --}}
                                <div class="col c-12 m-6 l-4">
                                    <div class="form-input-group">
                                        <label for="email">Email <span class="required">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="form-input">
                                        @error('email') <span class="input-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                {{-- Cột 3: Địa chỉ Giao hàng (4/12) --}}
                                <div class="col c-12 l-4">
                                    <div class="form-input-group">
                                        <label for="address">Địa chỉ chi tiết (Giao hàng) <span class="required">*</span></label>
                                        <textarea name="address" id="address" required rows="6" class="form-textarea">{{ old('address', $user->address) }}</textarea>
                                        @error('address') <span class="input-error">{{ $message }}</span> @enderror
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
                        
                    </form> {{-- <--- ĐÓNG FORM CẬP NHẬT HỒ SƠ --}}


                    {{-- =============================================== --}}
                    {{-- 2. FORM ĐỔI MẬT KHẨU --}}
                    {{-- Gửi đến route('profile.password') --}}
                    {{-- =============================================== --}}
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        <div class="section-group password-group">
                            <h2 class="section-heading danger-color">
                                <i class="fa-solid fa-lock"></i> ĐỔI MẬT KHẨU
                            </h2>

                            <div class="row">
                                {{-- Mật khẩu mới (l-6) --}}
                                <div class="col c-12 m-6 l-6">
                                    <div class="form-input-group">
                                        <label for="new_password">Mật khẩu mới</label>
                                        <input type="password" name="new_password" id="new_password" class="form-input">
                                        @error('new_password') <span class="input-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                {{-- Xác nhận mật khẩu mới (l-6) --}}
                                <div class="col c-12 m-6 l-6">
                                    <div class="form-input-group">
                                        <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input">
                                        @error('new_password_confirmation') <span class="input-error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-danger btn-change-password">
                                <i class="fa-solid fa-arrows-rotate"></i> THAY ĐỔI MẬT KHẨU
                            </button>
                        </div>
                    </form> {{-- <--- ĐÓNG FORM ĐỔI MẬT KHẨU --}}
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/edit.css') }}">
@endpush