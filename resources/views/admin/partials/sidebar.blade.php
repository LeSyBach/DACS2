{{-- FILE: resources/views/admin/partials/sidebar.blade.php --}}
<aside id="sidebar">
    <div class="sidebar__header">
        {{-- Tên thương hiệu/Hệ thống --}}
        <h3>TechStore Admin</h3>
    </div>
    
    <ul class="sidebar__nav">
        
        {{-- 1. Dashboard --}}
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
        </li>
        
        {{-- 2. Quản lý Đơn hàng --}}
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" 
               class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i> Quản lý Đơn hàng
            </a>
        </li>
        
        {{-- 3. Quản lý Sản phẩm --}}
        <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" 
               class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cube"></i> Quản lý Sản phẩm
            </a>
        </li>
        
        {{-- 4. Quản lý Danh mục --}}
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" 
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Quản lý Danh mục
            </a>
        </li>
        
        {{-- 5. Quản lý Tài khoản (THAY THẾ Khách hàng) --}}
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Quản lý Tài khoản
            </a>
        </li>
        
    </ul>
    
    {{-- FOOTER SIDEBAR - NÚT ĐĂNG XUẤT --}}
    <div class="sidebar__footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout-sidebar">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>