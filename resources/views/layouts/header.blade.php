<div class="header">
    <div class="grid wide">
        <div class="navbar">
            {{-- NÚT HAMBURGER (3 GẠCH) - Chỉ hiện trên mobile/tablet --}}
            <button class="navbar__hamburger" id="hamburger-btn">
                <span class="navbar__hamburger-line"></span>
                <span class="navbar__hamburger-line"></span>
                <span class="navbar__hamburger-line"></span>
            </button>

            {{-- LOGO --}}
            <div class="navbar__heading">
                <a href="{{ route('index') }}" class="navbar__heading-link">
                    <h2 class="navbar__heading-text">TechStore</h2>
                </a>    
            </div>

            {{-- SEARCH --}}
            {{-- <div class="navbar__search">
                <input type="text" class="navbar__search-input" placeholder="Tìm kiếm sản phẩm...">
                <button class="navbar__search-btn">
                    <i class="navbar__search-icon fa-solid fa-magnifying-glass"></i>
                </button>
            </div> --}}

            
            {{-- SEARCH --}}
<form class="navbar__search" id="search-form" method="GET" action="{{ route('search') }}">
    <input 
        type="text" 
        class="navbar__search-input" 
        name="keyword"
        id="search-input"
        placeholder="Tìm kiếm sản phẩm..."
        value="{{ request('keyword') }}"
        autocomplete="off"
    >
    <button type="submit" class="navbar__search-btn">
        <i class="navbar__search-icon fa-solid fa-magnifying-glass"></i>
    </button>
    
    {{-- Search Results Dropdown --}}
    <div class="search-results" id="search-results" style="display: none;"></div>
</form>
         
          
            {{-- MENU DESKTOP (Ẩn trên mobile) --}}
            <ul class="navbar__menu">
                <li class="navbar__menu-item {{ request()->routeIs('index') ? 'active' : '' }}">
                    <a href="{{ route('index') }}" class="navbar__menu-item-link">Trang chủ</a>
                </li>
                <li class="navbar__menu-item {{ request()->routeIs('product*') ? 'active' : '' }}">
                    <a href="{{ route('product') }}" class="navbar__menu-item-link">Sản phẩm</a>
                </li>
                <li class="navbar__menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}" class="navbar__menu-item-link">Giới thiệu</a>
                </li>
                <li class="navbar__menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="navbar__menu-item-link">Liên hệ</a>
                </li>
            </ul>

            {{-- ACTIONS --}}
            <div class="navbar__actions">
                <div class="navbar__actions-item navbar__actions-item--notify">
                    <i class="navbar__actions-icon fa-regular fa-bell"></i>
                </div>

                @auth
                {{-- ĐÃ ĐĂNG NHẬP - Desktop --}}
                    <div class="navbar__actions-item navbar__actions-item--logged-in">
                        <span class="navbar__user-name">{{ Auth::user()->name }}</span>
                        <i class="navbar__actions-icon fa-solid fa-caret-down"></i>
                    </div>
                    {{-- Dropdown Menu Desktop --}}
                    <div class="user-dropdown hidden">
                        <ul class="user-dropdown__list">
                            <li class="user-dropdown__item">
                                <a href="{{ route('profile.edit') }}" class="user-dropdown__link">
                                    <i class="fa-regular fa-user"></i> Trang cá nhân
                                </a>
                            </li>
                            <li class="user-dropdown__item">
                                <a href="{{ route('orders') }}" class="user-dropdown__link">
                                    <i class="fa-solid fa-box"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            <li class="user-dropdown__item">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="user-dropdown__link user-dropdown__link--logout">
                                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                @guest
                    {{-- CHƯA ĐĂNG NHẬP - Desktop --}}
                    <div class="navbar__actions-item navbar__actions-item--user">
                        <i class="navbar__actions-icon fa-regular fa-user"></i>
                    </div>
                @endguest
                
                {{-- ICON GIỎ HÀNG --}}
                <div class="navbar__actions-item navbar__actions-item--cart">
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="navbar__cart-notice">{{ $cartCount }}</span>
                    @endif
                    <i class="navbar__actions-icon fa-solidfa-cart-shopping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart h-5 w-5">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                        </svg>
                    </i>  
                </div>

                {{-- MODAL CART --}}
                <div class="modal-cart hidden">
                    <div class="modal-cart__overlay"></div>
                    <div class="modal-cart__body" id="cart-body-content">
                        @include('partials.cart-mini')
                    </div> 
                </div>
            </div> 
        </div> 
    </div> 
</div>

{{-- ============================================ --}}
{{-- MOBILE MENU SIDEBAR --}}
{{-- ============================================ --}}
<div class="navbar__mobile-overlay" id="mobile-overlay"></div>
<div class="navbar__mobile-menu" id="mobile-menu">
    {{-- Header --}}
    <div class="navbar__mobile-header">
        <a href="{{ route('index') }}" class="navbar__mobile-logo">TechStore</a>
        <button class="navbar__mobile-close" id="mobile-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    {{-- Menu Items --}}
    <ul class="navbar__mobile-list">
        <li class="navbar__mobile-item {{ request()->routeIs('index') ? 'active' : '' }}">
            <a href="{{ route('index') }}" class="navbar__mobile-link">
                <i class="fa-solid fa-house"></i>
                Trang chủ
            </a>
        </li>
        <li class="navbar__mobile-item {{ request()->routeIs('product*') ? 'active' : '' }}">
            <a href="{{ route('product') }}" class="navbar__mobile-link">
                <i class="fa-solid fa-box"></i>
                Sản phẩm
            </a>
        </li>
        <li class="navbar__mobile-item {{ request()->routeIs('about') ? 'active' : '' }}">
            <a href="{{ route('about') }}" class="navbar__mobile-link">
                <i class="fa-solid fa-circle-info"></i>
                Giới thiệu
            </a>
        </li>
        <li class="navbar__mobile-item {{ request()->routeIs('contact') ? 'active' : '' }}">
            <a href="{{ route('contact') }}" class="navbar__mobile-link">
                <i class="fa-solid fa-envelope"></i>
                Liên hệ
            </a>
        </li>
    </ul>
    
    {{-- User Section --}}
    @auth
        {{-- Đã đăng nhập --}}
        <div class="navbar__mobile-user">
            <div class="navbar__mobile-user-info">
                <div class="navbar__mobile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="navbar__mobile-username">{{ Auth::user()->name }}</div>
                    <small style="color: #666; font-size: 1.2rem;">{{ Auth::user()->email }}</small>
                </div>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="navbar__mobile-link">
                <i class="fa-regular fa-user"></i>
                Trang cá nhân
            </a>
            <a href="{{ route('orders') }}" class="navbar__mobile-link" style="border-bottom: none;">
                <i class="fa-solid fa-box"></i>
                Đơn hàng của tôi
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="navbar__mobile-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Đăng xuất
                </button>
            </form>
        </div>
    @endauth
    
    @guest
        {{-- Chưa đăng nhập --}}
        {{-- <div class="navbar__mobile-guest">
            <p style="margin-bottom: 15px; color: #666; font-size: 1.3rem;">
                Đăng nhập để trải nghiệm đầy đủ tính năng
            </p>
            <button class="navbar__mobile-login-btn navbar__actions-item--user">
                <i class="fa-solid fa-right-to-bracket"></i>
                Đăng nhập
            </button>
            <button class="navbar__mobile-register-btn navbar__actions-item--user">
                <i class="fa-solid fa-user-plus"></i>
                Đăng ký
            </button>
        </div> --}}

        {{-- Trong phần @guest của mobile menu --}}
        <div class="navbar__mobile-guest">
            <p style="margin-bottom: 15px; color: #666; font-size: 1.3rem;">
                Đăng nhập để trải nghiệm đầy đủ tính năng
            </p>
            <button class="navbar__mobile-login-btn"> <!-- Xóa navbar__actions-item--user -->
                <i class="fa-solid fa-right-to-bracket"></i>
                Đăng nhập
            </button>
            <button class="navbar__mobile-register-btn"> <!-- Xóa navbar__actions-item--user -->
                <i class="fa-solid fa-user-plus"></i>
                Đăng ký
            </button>
        </div>
    @endguest
</div>
<script>
// ============================================
// XỬ LÝ CLICK ICON SEARCH CHỈ TRÊN MOBILE
// Thêm vào file JS hoặc trong <script> tag
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Lấy các elements
    const navbarSearch = document.querySelector('.navbar__search');
    const searchBtn = document.querySelector('.navbar__search-btn');
    const searchInput = document.querySelector('.navbar__search-input');
    
    // Kiểm tra có phải mobile không
    function isMobile() {
        return window.innerWidth < 740;
    }
    
    // Click vào button search (icon kính lúp)
    if (searchBtn && navbarSearch) {
        searchBtn.addEventListener('click', function(e) {
            
            // CHỈ xử lý trên mobile
            if (isMobile()) {
                e.preventDefault(); // Ngăn submit
                
                // Toggle class active
                if (navbarSearch.classList.contains('active')) {
                    // Đang mở → Đóng lại
                    navbarSearch.classList.remove('active');
                    searchInput.blur();
                } else {
                    // Đang đóng → Mở ra (xuống dưới)
                    navbarSearch.classList.add('active');
                    
                    // Focus vào input sau animation
                    setTimeout(() => {
                        searchInput.focus();
                    }, 300);
                }
            }
            // Trên tablet/desktop (>= 740px): giữ nguyên hành vi mặc định (submit search)
        });
    }
    
    // Click vào overlay/ngoài search để đóng (chỉ trên mobile)
    document.addEventListener('click', function(e) {
        if (isMobile() && navbarSearch && navbarSearch.classList.contains('active')) {
            // Nếu click không phải vào search box
            if (!navbarSearch.contains(e.target)) {
                navbarSearch.classList.remove('active');
                searchInput.blur();
            }
        }
    });
    
    // Nhấn ESC để đóng search
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMobile() && navbarSearch && navbarSearch.classList.contains('active')) {
            navbarSearch.classList.remove('active');
            searchInput.blur();
        }
    });
    
    // Xử lý khi resize window
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Nếu chuyển từ mobile sang tablet/desktop thì đóng search
            if (!isMobile() && navbarSearch && navbarSearch.classList.contains('active')) {
                navbarSearch.classList.remove('active');
            }
        }, 250);
    });
});
</script>
