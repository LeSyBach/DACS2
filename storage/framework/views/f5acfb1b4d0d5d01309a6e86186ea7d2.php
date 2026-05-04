<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>TechStore - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23009689'/><text x='50%' y='90%' font-size='90' text-anchor='middle' fill='white'>T</text></svg>">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome-free-6.7.2-web/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/grid.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
    

    <?php echo $__env->yieldPushContent('css'); ?> 
</head>
<body>

    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('partials.auth_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="<?php echo e(asset('assets/js/modal.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

    
    
    
    <?php if(session('success')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("<?php echo e(session('success')); ?>", 'success');
            });
        </script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("<?php echo e(session('error')); ?>", 'error');
            });
        </script>
    <?php endif; ?>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    
</body>



<script>
document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // ANIMATION KHI SCROLL
    // ========================================
    function revealOnScroll(containerId) {
        const items = document.querySelectorAll(containerId + ' .product-item');
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        items.forEach(item => observer.observe(item));
    }

    // ========================================
    // LOAD TRANG BẰNG AJAX (KHÔNG RELOAD)
    // ========================================
    function loadPage(url, containerId) {
        // Lưu vị trí scroll hiện tại
        const currentScrollY = window.scrollY;
        
        // Hiện loading (optional)
        const container = document.querySelector(containerId);
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(html => {
            // Parse HTML response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Lấy phần content mới
            const newContent = doc.querySelector(containerId);
            
            if (newContent) {
                // Thay thế content
                container.innerHTML = newContent.innerHTML;
                
                // Reset style
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                
                // Animate sản phẩm mới
                revealOnScroll(containerId);
                
                // Giữ nguyên vị trí scroll
                

                const containerTop = container.offsetTop - 100; // -100px để có khoảng cách
                window.scrollTo({
                    top: containerTop,
                    behavior: 'smooth'
                });
                
                // Update URL (optional - không reload page)
                window.history.pushState({}, '', url);
            }
        })
        .catch(err => {
            console.error('Error loading page:', err);
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            alert('Có lỗi xảy ra khi tải trang. Vui lòng thử lại.');
        });
    }

    // ========================================
    // XỬ LÝ CLICK PAGINATION
    // ========================================
    
    // Pagination cho Featured Products
    function handleFeaturedPagination(e) {
        // Kiểm tra xem có phải link pagination không
        const link = e.target.closest('a');
        if (!link) return;
        
        const paginationWrapper = link.closest('.pagination-wrapper');
        if (!paginationWrapper) return;
        
        // Chỉ xử lý nếu trong container featured products
        const featuredContainer = link.closest('#featured-products-container');
        if (!featuredContainer) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const url = link.getAttribute('href');
        if (url && url !== '#') {
            loadPage(url, '#featured-products-container');
        }
    }

    // Pagination cho All Products
    function handleAllPagination(e) {
        const link = e.target.closest('a');
        if (!link) return;
        
        const paginationWrapper = link.closest('.pagination-wrapper');
        if (!paginationWrapper) return;
        
        const allContainer = link.closest('#all-products-container');
        if (!allContainer) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const url = link.getAttribute('href');
        if (url && url !== '#') {
            loadPage(url, '#all-products-container');
        }
    }

    // Gắn sự kiện
    const featuredContainer = document.querySelector('#featured-products-container');
    const allContainer = document.querySelector('#all-products-container');

    if (featuredContainer) {
        featuredContainer.addEventListener('click', handleFeaturedPagination);
    }

    if (allContainer) {
        allContainer.addEventListener('click', handleAllPagination);
    }

    // ========================================
    // ANIMATE PRODUCTS KHI LOAD LẦN ĐẦU
    // ========================================
    revealOnScroll('#featured-products-container');
    revealOnScroll('#all-products-container');

    // ========================================
    // XỬ LÝ NÚT BACK/FORWARD CỦA TRÌNH DUYỆT
    // ========================================
    window.addEventListener('popstate', function(e) {
        location.reload(); // Reload khi người dùng nhấn back/forward
    });

});

</script>




<script>

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    let searchTimeout;

    // Live Search (gõ xong 500ms mới search)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const keyword = this.value.trim();
            
            if (keyword.length >= 2) {
                searchTimeout = setTimeout(() => liveSearch(keyword), 500);
            } else {
                searchResults.style.display = 'none';
            }
        });
    }

    // Hàm tìm kiếm live
    function liveSearch(keyword) {
        fetch(`<?php echo e(route('search')); ?>?keyword=${encodeURIComponent(keyword)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data.all, 'text/html');
            const products = doc.querySelectorAll('.product-item');
            
            if (products.length === 0) {
                searchResults.innerHTML = '<div class="search-no-results">Không tìm thấy sản phẩm nào</div>';
            } else {
                let resultsHTML = '';
                products.forEach((product, index) => {
                    if (index < 5) {
                        // ✅ FIX: Kiểm tra nếu product chính là thẻ <a>
                        let linkElement;
                        
                        if (product.tagName === 'A') {
                            linkElement = product; // product chính là thẻ <a>
                        } else {
                            linkElement = product.querySelector('a'); // tìm thẻ <a> bên trong
                        }
                        
                        const link = linkElement ? linkElement.getAttribute('href') : '#';
                        const img = product.querySelector('.product-item__img')?.src || '';
                        const name = product.querySelector('.product-item__name')?.textContent || '';
                        const price = product.querySelector('.product-item__price-current')?.textContent || '';
                        
                        resultsHTML += `
                            <a href="${link}" class="search-result-item">
                                <img src="${img}" alt="${name}" class="search-result-img">
                                <div class="search-result-info">
                                    <div class="search-result-name">${name}</div>
                                    <div class="search-result-price">${price}</div>
                                </div>
                            </a>
                        `;
                    }
                });
                
                if (products.length > 5) {
                    resultsHTML += `<div style="padding: 10px; text-align: center; background: #f5f5f5;">
                        <small>Và ${products.length - 5} sản phẩm khác...</small>
                    </div>`;
                }
                
                searchResults.innerHTML = resultsHTML;
            }
            
            searchResults.style.display = 'block';
        })
        .catch(err => {
            console.error('Search error:', err);
        });
    }

    // Submit form search
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const keyword = searchInput.value.trim();
            
            if (keyword.length < 2) {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất 2 ký tự');
            }
            
            searchResults.style.display = 'none';
        });
    }

    // Đóng dropdown khi click bên ngoài
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Đóng dropdown khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.style.display = 'none';
        }
    });
});
</script>

</html><?php /**PATH C:\xampp\htdocs\techstore\resources\views/layouts/app.blade.php ENDPATH**/ ?>