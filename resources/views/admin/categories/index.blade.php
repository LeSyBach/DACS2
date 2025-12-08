{{-- FILE: resources/views/admin/categories/index.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Quản lý Danh mục')

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Danh sách Danh mục</h1>
            
            <div class="page-header-actions">
                <a href="{{ route('admin.categories.create') }}" class="btn btn--primary">
                    <i class="fas fa-plus"></i> Thêm Danh mục mới
                </a>
            </div>
            
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

            <div class="admin-table-card">
                <div class="order-list-table">
                    <table class="table order-table category-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Tên Danh mục</th>
                                <th>Slug (Đường dẫn)</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td data-label="ID">{{ $category->id }}</td>
                                    <td data-label="Icon">
                                        <div class="category-icon">
                                            <i class="fas {{ $category->icon }}"></i>
                                        </div>
                                    </td>
                                    <td data-label="Tên Danh mục">{{ $category->name }}</td>
                                    <td data-label="Slug">
                                        <span class="badge status-secondary">{{ $category->slug }}</span>
                                    </td>
                                    <td data-label="Hành động">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa danh mục này sẽ ảnh hưởng đến các sản phẩm liên quan. Bạn có chắc chắn?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-links mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection