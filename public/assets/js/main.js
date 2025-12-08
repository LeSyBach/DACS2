// File: assets/js/main.js

// quay lai

function goBackStep() {
    // Hàm này sẽ quay trở lại trang web trước đó trong lịch sử trình duyệt.
    // Ví dụ: Quay lại từ Bước 2 (Thanh toán) về Bước 1 (Thông tin).
    window.history.back();
}



// 1. Định nghĩa hàm xử lý (Logic giữ nguyên)
function highlightActiveMenu() {
    const currentPath = window.location.pathname;
    let currentFile = currentPath.split("/").pop();
    
    if (currentFile === "") currentFile = "index.html";

    const menuLinks = document.querySelectorAll('.navbar__menu-item-link');

    if (menuLinks.length === 0) return;

    menuLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (!linkHref || linkHref === "#") return;

        // So sánh: Link trong menu vs File hiện tại
        if (linkHref === currentFile) {
            // Xóa active cũ (phòng hờ)
            document.querySelectorAll('.navbar__menu-item.active').forEach(el => {
                el.classList.remove('active');
            });
            // Thêm active mới
            link.parentElement.classList.add('active');
        }
    });
}

// --- 2. PHẦN KÍCH HOẠT THÔNG MINH (SỬA Ở ĐÂY) ---

document.addEventListener("DOMContentLoaded", function() {
    
    // TRƯỜNG HỢP 1: Menu viết thẳng trong HTML (Trang chủ)
    // Kiểm tra xem có menu chưa? Nếu có rồi thì chạy luôn!
    if (document.querySelector('.navbar__menu-item-link')) {
        console.log("Phát hiện menu có sẵn (HTML tĩnh), kích hoạt ngay...");
        highlightActiveMenu();
    }

    // TRƯỜNG HỢP 2: Menu load động (Các trang con)
    // Vẫn lắng nghe sự kiện phòng khi menu chưa tải xong
    document.addEventListener('headerLoaded', function() {
        console.log("Nhận tín hiệu Header Loaded, kích hoạt menu...");
        highlightActiveMenu();
    });

});

document.addEventListener("DOMContentLoaded", function() {
    
    // --- XỬ LÝ NÚT TĂNG GIẢM (AJAX) ---
    // Dùng event delegation (lắng nghe từ document) để chạy được ngay cả khi load lại ajax
    document.body.addEventListener('click', function(e) {
        
        // Kiểm tra xem có bấm vào nút tăng/giảm có class 'ajax-cart-btn' không
        if (e.target.closest('.ajax-cart-btn')) {
            e.preventDefault(); // Chặn load trang
            
            const btn = e.target.closest('.ajax-cart-btn');
            const url = btn.getAttribute('data-url');
            const id = btn.getAttribute('data-id');

            // Gọi lên Server
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // TRƯỜNG HỢP 1: Cập nhật số lượng
                    if (data.status === 'update') {
                        document.getElementById('qty-' + id).innerText = data.newQty;
                        document.getElementById('price-' + id).innerText = data.newPrice;
                        document.getElementById('cart-total').innerText = data.newTotal;
                    } 
                    // TRƯỜNG HỢP 2: Xóa sản phẩm (khi giảm về 0)
                    else if (data.status === 'remove') {
                        document.getElementById('cart-item-' + id).remove();
                        document.getElementById('cart-total').innerText = data.total;
                        const cartNotice = document.querySelector(".navbar__cart-notice");
                        if (cartNotice) {
                            cartNotice.innerText = data.count;
                            if (data.count == 0) {
                                cartNotice.style.display = "none"; // ẩn badge khi giỏ rỗng
                            } else {
                                cartNotice.style.display = "inline-block";
                            }
                        }

                        // Nếu giỏ hàng rỗng thì render giao diện trống
                        if (data.count === 0 && data.cartHTML) {
                            const cartBody = document.getElementById('cart-body-content');
                            if (cartBody) cartBody.innerHTML = data.cartHTML;
                        }
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }
    });

    // --- XỬ LÝ NÚT XÓA (AJAX) ---
    document.body.addEventListener('click', function(e) {
        // Tìm nút xóa (hoặc icon bên trong nó)
        const removeBtn = e.target.closest('.ajax-remove-btn');
        
        if (removeBtn) {
            e.preventDefault(); // Chặn load trang
            
            const url = removeBtn.getAttribute('data-url');

            // Gọi lên Server
            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    
                    // 1. CẬP NHẬT SỐ LƯỢNG TRÊN HEADER
                    const cartNotice = document.querySelector('.navbar__cart-notice');
                    if (cartNotice) {
                        cartNotice.innerText = data.cartCount;
                        // Nếu số lượng = 0 thì ẩn cái số đỏ đi
                        if (data.cartCount == 0) {
                            cartNotice.style.display = 'none';
                        }
                    }

                    // 2. CẬP NHẬT TOÀN BỘ NỘI DUNG MODAL (QUAN TRỌNG)
                    // Thay vì xóa dòng li, ta thay thế cả cụm HTML mới từ Server gửi về
                    const cartBody = document.getElementById('cart-body-content');
                    if (cartBody) {
                        cartBody.innerHTML = data.cartHTML;
                        
                        // --- GÁN LẠI SỰ KIỆN ĐÓNG MODAL ---
                        // (Vì nút đóng cũ đã bị xóa theo HTML cũ)
                        const closeBtns = cartBody.querySelectorAll('.close-modal-btn, .modal-cart__close-btn');
                        closeBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                document.querySelector('.modal-cart').classList.add('hidden');
                            });
                        });
                    }

                    // 3. Hiện thông báo đẹp
                    if (typeof showToast === 'function') {
                        showToast(data.message, 'success'); // Thông báo xanh
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => console.error('Lỗi:', error));
        }
    });

});


// Hàm hiển thị thông báo (Global)
function showToast(message, type = 'success') {
    // 1. Tìm hoặc tạo hộp đựng (Container)
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    // 2. Tạo thẻ thông báo
    const toast = document.createElement('div');
    toast.classList.add('toast-message');
    
    // Kiểm tra loại thông báo để đổi icon/màu
    let iconClass = 'fa-check-circle';
    if (type === 'error') {
        toast.classList.add('error');
        iconClass = 'fa-circle-exclamation';
    }

    // 3. Điền nội dung HTML
    toast.innerHTML = `
        <i class="fa-solid ${iconClass}"></i>
        <span>${message}</span>
    `;

    // 4. Thêm vào màn hình
    container.appendChild(toast);

    // 5. Tự động xóa sau 3.5 giây (3s hiện + 0.5s hiệu ứng biến mất)
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.5s ease forwards';
        setTimeout(() => {
            if(toast && toast.parentElement) toast.remove();
        }, 500);
    }, 3000);
}



// ============================================
// HAMBURGER MENU - MOBILE NAVIGATION
// Thêm vào cuối file main.js hoặc tạo file riêng
// ============================================

(function() {
    'use strict';
    
    // Lấy các elements
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileClose = document.getElementById('mobile-close');
    const body = document.body;
    
    // Kiểm tra elements có tồn tại không
    if (!hamburgerBtn || !mobileMenu || !mobileOverlay || !mobileClose) {
        console.warn('Hamburger menu elements not found');
        return;
    }
    
    // ============================================
    // HÀM MỞ MENU
    // ============================================
    function openMobileMenu() {
        hamburgerBtn.classList.add('active');
        mobileMenu.classList.add('active');
        mobileOverlay.classList.add('active');
        body.classList.add('menu-open');
    }
    
    // ============================================
    // HÀM ĐÓNG MENU
    // ============================================
    function closeMobileMenu() {
        hamburgerBtn.classList.remove('active');
        mobileMenu.classList.remove('active');
        mobileOverlay.classList.remove('active');
        body.classList.remove('menu-open');
    }
    
    // ============================================
    // EVENT LISTENERS
    // ============================================
    
    // Click nút hamburger
    hamburgerBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });
    
    // Click nút close (X)
    mobileClose.addEventListener('click', function(e) {
        e.stopPropagation();
        closeMobileMenu();
    });
    
    // Click overlay (nền tối)
    mobileOverlay.addEventListener('click', function() {
        closeMobileMenu();
    });
    
    // Click vào menu item sẽ đóng menu (cho UX tốt hơn)
    const mobileLinks = mobileMenu.querySelectorAll('.navbar__mobile-link');
    mobileLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Đóng menu sau khi click (với delay nhỏ để animation mượt)
            setTimeout(closeMobileMenu, 150);
        });
    });
    
    // Đóng menu khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // Đóng menu khi resize về desktop
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 1023 && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        }, 250);
    });
    
    // ============================================
    // XỬ LÝ NÚT ĐĂNG NHẬP/ĐĂNG KÝ TRONG MOBILE MENU
    // ============================================
    
    // Lấy các nút đăng nhập/đăng ký trong mobile menu
    const mobileLoginButtons = mobileMenu.querySelectorAll('.navbar__mobile-login-btn, .navbar__mobile-register-btn');
    
    mobileLoginButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            // Đóng mobile menu
            closeMobileMenu();
            
            // Trigger click vào nút user desktop để mở modal auth
            const desktopUserBtn = document.querySelector('.navbar__actions-item--user');
            if (desktopUserBtn) {
                setTimeout(function() {
                    desktopUserBtn.click();
                }, 300);
            }
        });
    });
    
    // ============================================
    // PREVENT SCROLL WHEN MENU OPEN
    // ============================================
    
    // Lưu vị trí scroll khi mở menu
    let scrollPosition = 0;
    
    const originalOpenMenu = openMobileMenu;
    openMobileMenu = function() {
        scrollPosition = window.pageYOffset;
        body.style.position = 'fixed';
        body.style.top = `-${scrollPosition}px`;
        body.style.width = '100%';
        originalOpenMenu();
    };
    
    const originalCloseMenu = closeMobileMenu;
    closeMobileMenu = function() {
        body.style.position = '';
        body.style.top = '';
        body.style.width = '';
        window.scrollTo(0, scrollPosition);
        originalCloseMenu();
    };
    
    console.log('✅ Hamburger menu initialized successfully');
    
})();



