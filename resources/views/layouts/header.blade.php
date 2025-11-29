<div class="header">
    <div class="grid">
        <div class="navbar">
            {{-- LOGO --}}
            <div class="navbar__heading">
                <a href="{{ route('index') }}" class="navbar__heading-link">
                    <h2 class="navbar__heading-text">TechStore</h2>
                </a>    
            </div>

            {{-- SEARCH --}}
            <div class="navbar__search">
                <input type="text" class="navbar__search-input" placeholder="Tìm kiếm sản phẩm...">
                <button class="navbar__search-btn">
                    <i class="navbar__search-icon fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
          
            {{-- MENU --}}
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
                {{-- <div class="navbar__actions-item navbar__actions-item--user">
                    <i class="navbar__actions-icon fa-regular fa-user"></i>
                </div> --}}

                @auth
                {{-- 1. ĐÃ ĐĂNG NHẬP (Authenticated) --}}
                    <div class="navbar__actions-item navbar__actions-item--logged-in">
                        <span class="navbar__user-name">{{ Auth::user()->name }}</span>
                        <i class="navbar__actions-icon fa-solid fa-caret-down"></i>
                    </div>
                    {{-- Dropdown Menu --}}
                    <div class="user-dropdown hidden">
                        <ul class="user-dropdown__list">
                            <li class="user-dropdown__item">
                                <a href="{{ route('profile.edit') }}" class="user-dropdown__link">
                                    <i class="fa-regular fa-user"></i> Trang cá nhân
                                </a>
                            </li>
                            <li class="user-dropdown__item">
                                <a href="" class="user-dropdown__link">
                                    <i class="fa-solid fa-box"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            <li class="user-dropdown__item">
                                {{-- Form Đăng xuất dùng POST (đã thiết lập trong web.php) --}}
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
                    {{-- 2. CHƯA ĐĂNG NHẬP (Guest) --}}
                    {{-- Giữ nguyên class để JS hiện Modal Auth --}}
                    <div class="navbar__actions-item navbar__actions-item--user">
                        <i class="navbar__actions-icon fa-regular fa-user"></i>
                    </div>
                @endguest
                
                {{-- ICON GIỎ HÀNG --}}
                <div class="navbar__actions-item navbar__actions-item--cart">
                    {{-- Sử dụng biến $cartCount từ AppServiceProvider --}}
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="navbar__cart-notice">{{ $cartCount }}</span>
                    @endif
                    <i class="navbar__actions-icon fa-solidfa-cart-shopping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart h-5 w-5">
                            <circle cx="8" cy="21" r="1">

                            </circle><circle cx="19" cy="21" r="1">

                            </circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">

                            </path>
                        </svg>
                    </i>  
                </div>

                {{-- === MODAL CART (KHUNG BAO NGOÀI) === --}}
                <div class="modal-cart hidden">
                    <div class="modal-cart__overlay"></div>
                    
                    {{-- ID 'cart-body-content' để JS tìm và thay thế nội dung khi Ajax chạy --}}
                    <div class="modal-cart__body" id="cart-body-content">
                        
                        {{-- Nhúng phần ruột giỏ hàng vào đây --}}
                        @include('partials.cart-mini')

                    </div> 
                </div>
                {{-- === HẾT MODAL === --}}

            </div> 
        </div> 
    </div> 
</div> 

{{-- Script đóng mở modal --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function attachCloseEvents() {
            const modal = document.querySelector('.modal-cart');
            const closeBtns = document.querySelectorAll('.close-modal-btn, .modal-cart__close-btn, .modal-cart__overlay');
            const openBtn = document.querySelector('.navbar__actions-item--cart');

            if(openBtn) {
                openBtn.onclick = function() { modal.classList.remove('hidden'); }
            }
            closeBtns.forEach(btn => {
                btn.onclick = function() { modal.classList.add('hidden'); }
            });
        }
        attachCloseEvents();
    });
</script>