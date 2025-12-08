{{-- FILE: resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.guest')

@section('title', 'Quản lý Tài khoản')

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Danh sách Tài khoản</h1>
            
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="admin-table-card">
                
                {{-- KHỐI CÔNG CỤ TÌM KIẾM/LỌC --}}
                <div class="table-controls">
                    
                    <div class="filter-buttons">
                        {{-- Nút lọc theo quyền hạn --}}
                        <button class="btn-filter active" data-filter="all">Tất cả</button>
                        <button class="btn-filter" data-filter="admin">Admin</button>
                        <button class="btn-filter" data-filter="customer">Customer</button>
                    </div>
                    
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên, email..." class="form-control-sm">
                    </div>
                </div>

                {{-- BẢNG DANH SÁCH TÀI KHOẢN --}}
                <div class="order-list-table">
                    <table class="table order-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>Quyền hạn</th>
                                <th>Ngày đăng ký</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            @foreach ($users as $user)
                                <tr class="user-row" data-role="{{ $user->role }}">
                                    <td data-label="ID">{{ $user->id }}</td>
                                    <td data-label="Họ Tên">{{ $user->name }}</td>
                                    <td data-label="Email">{{ $user->email }}</td>
                                    <td data-label="Điện thoại">{{ $user->phone ?? 'N/A' }}</td>
                                    <td data-label="Quyền hạn">
                                        <span class="badge status-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td data-label="Ngày đăng ký">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td data-label="Hành động">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa tài khoản này sẽ xóa tất cả đơn hàng liên quan. Bạn có chắc chắn?')">
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
                <div class="pagination-links mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript cho Filter và Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter buttons
            const filterButtons = document.querySelectorAll('.btn-filter');
            const userRows = document.querySelectorAll('.user-row');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    userRows.forEach(row => {
                        if (filter === 'all') {
                            row.style.display = '';
                        } else {
                            const role = row.getAttribute('data-role');
                            row.style.display = (role === filter) ? '' : 'none';
                        }
                    });
                });
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                userRows.forEach(row => {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection