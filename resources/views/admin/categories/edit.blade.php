{{-- FILE: resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Chỉnh sửa Danh mục: ' . $category->name)

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Chỉnh sửa Danh mục</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="admin-table-card" style="max-width: 800px;">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                       value="{{ old('name', $category->name) }}" 
                                       required
                                       placeholder="Nhập tên danh mục">
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
                                       value="{{ old('icon', $category->icon) }}"
                                       placeholder="Ví dụ: fa-mobile-screen-button">
                            </div>
                            <small class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Nhập class icon từ Font Awesome. Ví dụ: fa-mobile-screen-button, fa-laptop, fa-headphones
                            </small>
                            @error('icon') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        {{-- PREVIEW ICON --}}
                        <div class="icon-preview-box" id="iconPreviewBox">
                            <label class="form-label">Xem trước icon:</label>
                            <div class="icon-preview">
                                <i id="iconPreview" class="fas {{ $category->icon }}"></i>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary btn--lg">
                            <i class="fas fa-save"></i> Cập nhật Danh mục
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
                preview.className = 'fas ' + iconClass;
                previewBox.style.display = 'block';
            } else {
                previewBox.style.display = 'none';
            }
        });
    </script>
@endsection