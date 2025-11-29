<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - @yield('title')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @stack('css') 
</head>
<body>

    {{-- 1. HEADER --}}
    @include('layouts.header')

    {{-- 2. NỘI DUNG CHÍNH --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- 3. FOOTER --}}
    @include('layouts.footer')

    {{-- 4. MODAL ĐĂNG NHẬP/ĐĂNG KÝ --}}
    @include('partials.auth_modal')

    {{-- 5. JS CHÍNH --}}
    <script src="{{ asset('assets/js/modal.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- 6. XỬ LÝ THÔNG BÁO (FLASH MESSAGE) --}}
    {{-- Đoạn này phải nằm trong body và SAU khi load main.js --}}
    
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("{{ session('success') }}", 'success');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("{{ session('error') }}", 'error');
            });
        </script>
    @endif

    {{-- 7. JS RIÊNG CỦA TỪNG TRANG --}}
    @stack('scripts')
    
</body>



<script>
document.addEventListener('DOMContentLoaded', function() {

    // Animate từng sản phẩm
    function revealOnScroll(containerId) {
        const items = document.querySelectorAll(containerId + ' .product-item');
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target); // chỉ animate 1 lần
                }
            });
        }, { threshold: 0.1 });

        items.forEach(item => observer.observe(item));
    }

    // Lần đầu load
    revealOnScroll('#featured-products-container');
    revealOnScroll('#all-products-container');

    

    // Load page AJAX
    function loadPage(url, containerId) {
        const scrollPos = window.scrollY; // lưu scroll
        fetch(url)
            .then(res => res.text())
            .then(html => {
                document.querySelector(containerId).innerHTML = html;
                animateProducts(containerId); // animate sản phẩm mới
                window.scrollTo({ top: scrollPos }); // giữ scroll
            })
            .catch(err => console.error(err));
    }

    animateProducts('#featured-products-container');
    animateProducts('#all-products-container');

    // Pagination Featured Products
    document.querySelector('#featured-products-container')?.addEventListener('click', function(e){
        if(e.target.tagName==='A' && e.target.closest('.pagination-wrapper')) {
            e.preventDefault();
            loadPage(e.target.href, '#featured-products-container');
        }
    });

    // Pagination All Products
    document.querySelector('#all-products-container')?.addEventListener('click', function(e){
        if(e.target.tagName==='A' && e.target.closest('.pagination-wrapper')) {
            e.preventDefault();
            loadPage(e.target.href, '#all-products-container');
        }
    });

});

</script>

</html>