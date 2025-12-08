{{-- FILE: resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Danh sách Sản phẩm</h1>
            
            <div class="page-header-actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn--primary">
                    <i class="fas fa-plus"></i> Thêm Sản phẩm mới
                </a>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="admin-table-card">
                {{-- KHỐI CÔNG CỤ TÌM KIẾM/LỌC --}}
                <div class="table-controls">
                    <div class="filter-buttons">
                        <button class="btn-filter active" data-filter="all">Tất cả</button>
                        <button class="btn-filter" data-filter="featured">Nổi bật</button>
                        <button class="btn-filter" data-filter="in-stock">Còn hàng</button>
                        <button class="btn-filter" data-filter="out-of-stock">Hết hàng</button>
                    </div>
                    
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm..." class="form-control-sm">
                    </div>
                </div>

                {{-- <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm" >
                    <div class="table-controls">
                        <div class="filter-buttons">
                            <button class="btn-filter active" data-filter="all">Tất cả</button>
                            <button class="btn-filter" data-filter="featured">Nổi bật</button>
                            <button class="btn-filter" data-filter="in-stock">Còn hàng</button>
                            <button class="btn-filter" data-filter="out-of-stock">Hết hàng</button>
                        </div>
                        
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm..." class="form-control-sm">
                        </div>
                    </div>
                </form> --}}

                {{-- BẢNG DANH SÁCH SẢN PHẨM --}}
                <div class="order-list-table">
                    <table class="table order-table product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên Sản phẩm</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th>Số lượng</th>
                                <th>Nổi bật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            @foreach ($products as $product)
                                <tr class="product-row" 
                                    data-featured="{{ $product->is_featured ? '1' : '0' }}" 
                                    data-stock="{{ $product->quantity > 0 ? 'in' : 'out' }}"
                                    data-name="{{ strtolower($product->name) }}">
                                    <td data-label="ID">{{ $product->id }}</td>
                                    <td data-label="Ảnh">
                                        <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" class="product-thumb">
                                    </td>
                                    <td data-label="Tên SP">{{ $product->name }}</td>
                                    <td data-label="Giá" class="price-col">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                    <td data-label="Danh mục">
                                        <span class="badge status-secondary">{{ $product->category->name ?? 'Không rõ' }}</span>
                                    </td>
                                    <td data-label="Số lượng">
                                        <span class="badge {{ $product->quantity > 0 ? 'status-success' : 'status-danger' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td data-label="Nổi bật">
                                        <span class="badge {{ $product->is_featured ? 'status-success' : 'status-secondary' }}">
                                            {{ $product->is_featured ? 'Có' : 'Không' }}
                                        </span>
                                    </td>
                                    <td data-label="Hành động">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Phân trang --}}
                <div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript cho Filter và Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter buttons
            const filterButtons = document.querySelectorAll('.btn-filter');
            const productRows = document.querySelectorAll('.product-row');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    productRows.forEach(row => {
                        if (filter === 'all') {
                            row.style.display = '';
                        } else if (filter === 'featured') {
                            row.style.display = row.getAttribute('data-featured') === '1' ? '' : 'none';
                        } else if (filter === 'in-stock') {
                            row.style.display = row.getAttribute('data-stock') === 'in' ? '' : 'none';
                        } else if (filter === 'out-of-stock') {
                            row.style.display = row.getAttribute('data-stock') === 'out' ? '' : 'none';
                        }
                    });
                });
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                productRows.forEach(row => {
                    const name = row.getAttribute('data-name');
                    row.style.display = name.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    </script>
@endsection