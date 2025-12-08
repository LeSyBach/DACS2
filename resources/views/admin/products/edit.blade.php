{{-- FILE: resources/views/admin/products/edit.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Chỉnh sửa Sản phẩm: ' . $product->name)

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Chỉnh sửa Sản phẩm</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="admin-table-card">
                {{-- Form cần enctype="multipart/form-data" để tải ảnh --}}
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- THÔNG TIN CƠ BẢN --}}
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-box"></i>
                            <h2 class="section-title">Thông tin cơ bản</h2>
                        </div>

                        <div class="form-grid form-grid--2col">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Tên Sản phẩm <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-input @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $product->name) }}" 
                                           required
                                           placeholder="Nhập tên sản phẩm">
                                </div>
                                @error('name') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="form-label">
                                    Danh mục <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-folder"></i>
                                    </span>
                                    <select name="category_id" id="category_id" class="form-input" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price" class="form-label">
                                    Giá Bán (₫) <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" 
                                           name="price" 
                                           id="price" 
                                           class="form-input @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $product->price) }}" 
                                           required
                                           placeholder="0">
                                </div>
                                @error('price') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="old_price" class="form-label">
                                    Giá cũ (Giảm giá)
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-percentage"></i>
                                    </span>
                                    <input type="number" 
                                           name="old_price" 
                                           id="old_price" 
                                           class="form-input @error('old_price') is-invalid @enderror" 
                                           value="{{ old('old_price', $product->old_price) }}"
                                           placeholder="0">
                                </div>
                                @error('old_price') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-label">
                                    Số Lượng Tồn Kho <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity" 
                                           class="form-input @error('quantity') is-invalid @enderror" 
                                           value="{{ old('quantity', $product->quantity) }}" 
                                           required
                                           placeholder="0">
                                </div>
                                @error('quantity') 
                                    <span class="input-error">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tùy chọn</label>
                                <div class="form-check-wrapper">
                                    <input type="checkbox" 
                                           name="is_featured" 
                                           id="is_featured" 
                                           class="form-check-input" 
                                           value="1" 
                                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label for="is_featured" class="form-check-label">
                                        <i class="fas fa-star"></i> Hiển thị ở trang chủ (Nổi bật)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HÌNH ẢNH --}}
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-image"></i>
                            <h2 class="section-title">Hình ảnh sản phẩm</h2>
                        </div>

                        <div class="current-image-section">
                            <label class="form-label">Ảnh Hiện tại:</label>
                            <div class="current-image-wrapper">
                                <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" id="currentImage">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="image" class="form-label">
                                Chọn Ảnh mới (Tùy chọn)
                            </label>
                            <div class="image-upload-wrapper">
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       class="form-control-file"
                                       accept="image/*">
                                <div id="imagePreview" class="image-preview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Chọn ảnh mới để thay đổi</p>
                                </div>
                            </div>
                            @error('image') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    {{-- MÔ TẢ --}}
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-align-left"></i>
                            <h2 class="section-title">Mô tả sản phẩm</h2>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Mô tả ngắn</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-comment"></i>
                                </span>
                                <textarea name="description" 
                                          id="description" 
                                          rows="3" 
                                          class="form-input @error('description') is-invalid @enderror"
                                          placeholder="Nhập mô tả ngắn về sản phẩm">{{ old('description', $product->description) }}</textarea>
                            </div>
                            @error('description') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">Nội dung chi tiết</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <textarea name="content" 
                                          id="content" 
                                          rows="6" 
                                          class="form-input @error('content') is-invalid @enderror"
                                          placeholder="Nhập nội dung chi tiết về sản phẩm">{{ old('content', $product->content) }}</textarea>
                            </div>
                            @error('content') 
                                <span class="input-error">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary btn--lg">
                            <i class="fas fa-save"></i> Cập nhật Sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn--secondary btn--lg">
                            <i class="fas fa-times"></i> Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript cho Image Preview --}}
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<i class="fas fa-cloud-upload-alt"></i><p>Chọn ảnh mới để thay đổi</p>';
            }
        });
    </script>
@endsection