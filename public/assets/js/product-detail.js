// Đợi web tải xong mới chạy code
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Tìm nút có class là .back-btn
    const backButton = document.querySelector('.back-btn');

    // 2. Nếu tìm thấy nút đó thì mới gán sự kiện (để tránh lỗi ở các trang khác)
    if (backButton) {
        backButton.addEventListener('click', function(event) {
            
            // Ngăn chặn hành vi mặc định của thẻ a (là nhảy lên đầu trang do href="#")
            event.preventDefault(); 
            
            // Lệnh quay lại trang trước đó (như nút Back của trình duyệt)
            // Giúp giữ nguyên vị trí cuộn chuột ở trang danh sách
            window.history.back(); 
        });
    }

});

// public/assets/js/product-detail.js

document.addEventListener("DOMContentLoaded", function () {
    
    // --- PHẦN 1: TĂNG GIẢM SỐ LƯỢNG ---
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');
    const qtyInput = document.querySelector('.qty-input');

    if (minusBtn && plusBtn && qtyInput) {
        plusBtn.addEventListener('click', function () {
            let val = parseInt(qtyInput.value) || 0;
            qtyInput.value = val + 1;
        });

        minusBtn.addEventListener('click', function () {
            let val = parseInt(qtyInput.value) || 0;
            if (val > 1) qtyInput.value = val - 1;
        });
    }

    // --- PHẦN 2: GỬI AJAX ADD TO CART (QUAN TRỌNG) ---
    const addCartForm = document.getElementById('add-to-cart-form');

    if (addCartForm) {
        addCartForm.addEventListener('submit', function(e) {
            e.preventDefault(); // 1. Chặn load trang

            const url = this.action;
            const formData = new FormData(this);

            // 2. Gửi Ajax
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    
                    // 3. Cập nhật Icon Header
                    const cartIconContainer = document.querySelector('.navbar__actions-item--cart');
                    let cartNotice = document.querySelector('.navbar__cart-notice');
                    
                    if (!cartNotice && cartIconContainer) {
                         // Nếu chưa có số (giỏ rỗng) thì tạo mới
                         cartNotice = document.createElement('span');
                         cartNotice.className = 'navbar__cart-notice';
                         cartIconContainer.prepend(cartNotice);
                    }
                    if(cartNotice) {
                        cartNotice.innerText = data.cartCount;
                        cartNotice.style.display = 'block';
                        cartNotice.style.animation = 'none';
                        cartNotice.offsetHeight; /* trigger reflow */
                        cartNotice.style.animation = 'shake 0.5s';
                    }
                    // 4. CẬP NHẬT NỘI DUNG MODAL (QUAN TRỌNG)
                    const cartBody = document.getElementById('cart-body-content');
                    if (cartBody) {
                        cartBody.innerHTML = data.cartHTML; // Thay thế HTML cũ bằng cái mới
                        
                        // 5. Gán lại sự kiện đóng modal cho các nút mới sinh ra
                        const closeBtns = cartBody.querySelectorAll('.close-modal-btn, .modal-cart__close-btn');
                        closeBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                document.querySelector('.modal-cart').classList.add('hidden');
                            });
                        });
                    }

                    // 6. Mở Modal ra cho khách thấy luôn
                    // Gọi hàm thông báo tự chế
                        showToast(data.message, 'success');
                    // document.querySelector('.modal-cart').classList.remove('hidden');
                }
            })
            .catch(error => console.error('Lỗi:', error));
        });
    }
});