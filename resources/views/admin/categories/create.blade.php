{{-- FILE: resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Thêm Danh mục Mới')

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Thêm Danh mục Mới</h1>

            <div class="admin-table-card" style="max-width: 800px;">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    {{-- THÔNG TIN DANH MỤC --}}
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-folder"></i>
                            <h2 class="section-title">Thông tin danh mục</h2>
                        </div>

                        <div class="form-group">
                            <label for="name" class="form-label">
                                Tên Danh mục <span class="text-danger">*</span>
                            </label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="Nhập tên danh mục (VD: Điện thoại, Laptop...)">
                            </div>
                            @error('name') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="icon" class="form-label">
                                Icon (Font Awesome)
                            </label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-icons"></i>
                                </span>
                                <input type="text" 
                                       name="icon" 
                                       id="icon" 
                                       class="form-input @error('icon') is-invalid @enderror" 
                                       value="{{ old('icon') }}"
                                       placeholder="Ví dụ: fa-mobile-screen-button">
                            </div>
                            <small class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Nhập class icon từ Font Awesome. Ví dụ: fa-mobile-screen-button, fa-laptop, fa-headphones, fa-tablet
                            </small>
                            @error('icon') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        {{-- PREVIEW ICON --}}
                        <div class="icon-preview-box" id="iconPreviewBox" style="display: none;">
                            <label class="form-label">Xem trước icon:</label>
                            <div class="icon-preview">
                                <i id="iconPreview" class="fas fa-question"></i>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary btn--lg">
                            <i class="fas fa-save"></i> Lưu Danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn--secondary btn--lg">
                            <i class="fas fa-times"></i> Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript cho Icon Preview --}}
    <script>
        document.getElementById('icon').addEventListener('input', function(e) {
            const iconClass = e.target.value.trim();
            const preview = document.getElementById('iconPreview');
            const previewBox = document.getElementById('iconPreviewBox');
            
            if (iconClass) {
                // Xóa 'fa-' nếu người dùng nhập thừa
                const cleanClass = iconClass.replace(/^fa-/, '');
                preview.className = 'fas fa-' + cleanClass;
                previewBox.style.display = 'block';
            } else {
                preview.className = 'fas fa-question';
                previewBox.style.display = 'none';
            }
        });
    </script>
@endsection