{{-- FILE: resources/views/admin/partials/header.blade.php --}}
<header id="admin-header">
    <div class="header__left">
        <h2 class="page-title">@yield('title', 'Dashboard')</h2>
    </div>
    <div class="header__right">
        {{-- Có thể thêm thông tin admin hoặc notifications ở đây --}}
        {{-- <span class="admin-name">Xin chào, {{ Auth::user()->name }}</span> --}}
        
        {{-- Có thể thêm icon notifications, settings, etc --}}
        {{-- <button class="btn-icon">
            <i class="fa-solid fa-bell"></i>
        </button> --}}
    </div>
</header>