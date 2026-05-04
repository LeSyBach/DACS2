// Đợi web tải xong mới chạy code
document.addEventListener("DOMContentLoaded", function () {
    // 1. Tìm nút có class là .back-btn
    const backButton = document.querySelector(".back-btn");

    // 2. Nếu tìm thấy nút đó thì mới gán sự kiện (để tránh lỗi ở các trang khác)
    if (backButton) {
        backButton.addEventListener("click", function (event) {
            // Ngăn chặn hành vi mặc định của thẻ a (là nhảy lên đầu trang do href="#")
            event.preventDefault();

            // Lệnh quay lại trang trước đó (như nút Back của trình duyệt)
            // Giúp giữ nguyên vị trí cuộn chuột ở trang danh sách
            window.history.back();
        });
    }

    // ========================================
    // XỬ LÝ CHỌN BIẾN THỂ SẢN PHẨM
    // ========================================
    if (typeof productVariants !== "undefined" && productVariants.length > 0) {
        let selectedColor = null;
        let selectedStorage = null;

        // Khởi tạo giá trị mặc định
        if (typeof defaultVariant !== "undefined" && defaultVariant) {
            selectedColor = defaultVariant.color;
            selectedStorage = defaultVariant.storage;
        }

        // Xử lý khi click chọn màu hoặc dung lượng
        const variantButtons = document.querySelectorAll(".variant-option");

        variantButtons.forEach((button) => {
            button.addEventListener("click", function (event) {
                // QUAN TRỌNG: Ngăn form submit khi click vào button variant
                event.preventDefault();
                event.stopPropagation();

                // Không cho click vào button bị disabled
                if (this.disabled || this.classList.contains("unavailable")) {
                    return;
                }

                const type = this.getAttribute("data-type");
                const value = this.getAttribute("data-value");

                // Nếu click vào button đang active thì bỏ chọn
                if (this.classList.contains("active")) {
                    this.classList.remove("active");
                    if (type === "color") {
                        selectedColor = null;
                        document.getElementById("selected-color").textContent =
                            "Chưa chọn";
                    } else if (type === "storage") {
                        selectedStorage = null;
                        document.getElementById(
                            "selected-storage"
                        ).textContent = "Chưa chọn";
                    }
                } else {
                    // Bỏ active khỏi các button cùng type
                    document
                        .querySelectorAll(
                            `.variant-option[data-type="${type}"]`
                        )
                        .forEach((btn) => {
                            btn.classList.remove("active");
                        });

                    // Thêm active vào button được chọn
                    this.classList.add("active");

                    // Cập nhật giá trị đã chọn
                    if (type === "color") {
                        selectedColor = value;
                        document.getElementById("selected-color").textContent =
                            value;
                    } else if (type === "storage") {
                        selectedStorage = value;
                        document.getElementById(
                            "selected-storage"
                        ).textContent = value;
                    }
                }

                // Cập nhật trạng thái available của các option khác
                updateAvailableOptions();

                // Tìm variant phù hợp
                updateProductInfo();
            });
        });

        // Hàm cập nhật các option có thể chọn (chỉ làm highlight, không disable)
        function updateAvailableOptions() {
            // Reset tất cả về trạng thái bình thường
            document.querySelectorAll(".variant-option").forEach((btn) => {
                btn.classList.remove("unavailable");
                btn.disabled = false;
                btn.style.opacity = "1";
                btn.style.cursor = "pointer";
            });

            // DISABLE các biến thể hết hàng
            document.querySelectorAll(".variant-option").forEach((btn) => {
                const type = btn.getAttribute("data-type");
                const value = btn.getAttribute("data-value");

                // Kiểm tra xem tổ hợp này có stock không
                let hasStock = false;

                if (type === "color") {
                    // Nếu đã chọn storage, kiểm tra tổ hợp color + storage
                    if (selectedStorage) {
                        const variant = productVariants.find(
                            (v) =>
                                v.color === value &&
                                v.storage === selectedStorage &&
                                v.stock > 0
                        );
                        hasStock = !!variant;
                    } else {
                        // Chưa chọn storage, kiểm tra xem màu này có bất kỳ biến thể nào còn hàng không
                        hasStock = productVariants.some(
                            (v) => v.color === value && v.stock > 0
                        );
                    }
                } else if (type === "storage") {
                    // Nếu đã chọn color, kiểm tra tổ hợp color + storage
                    if (selectedColor) {
                        const variant = productVariants.find(
                            (v) =>
                                v.storage === value &&
                                v.color === selectedColor &&
                                v.stock > 0
                        );
                        hasStock = !!variant;
                    } else {
                        // Chưa chọn color, kiểm tra xem dung lượng này có bất kỳ biến thể nào còn hàng không
                        hasStock = productVariants.some(
                            (v) => v.storage === value && v.stock > 0
                        );
                    }
                }

                // Nếu không còn stock, disable button
                if (!hasStock) {
                    btn.disabled = true;
                    btn.style.opacity = "0.4";
                    btn.style.cursor = "not-allowed";
                    btn.classList.add("unavailable");
                    btn.title = "Hết hàng";
                }
            });

            // Nếu đã chọn màu, highlight các dung lượng có sẵn
            if (selectedColor) {
                const availableStorages = productVariants
                    .filter((v) => v.color === selectedColor)
                    .map((v) => v.storage);

                document
                    .querySelectorAll('.variant-option[data-type="storage"]')
                    .forEach((btn) => {
                        const storage = btn.getAttribute("data-value");
                        if (!availableStorages.includes(storage)) {
                            btn.classList.add("unavailable");
                        }
                    });
            }

            // Nếu đã chọn dung lượng, highlight các màu có sẵn
            if (selectedStorage) {
                const availableColors = productVariants
                    .filter((v) => v.storage === selectedStorage)
                    .map((v) => v.color);

                document
                    .querySelectorAll('.variant-option[data-type="color"]')
                    .forEach((btn) => {
                        const color = btn.getAttribute("data-value");
                        if (!availableColors.includes(color)) {
                            btn.classList.add("unavailable");
                        }
                    });
            }
        }

        function updateProductInfo() {
            const btnBuy = document.querySelector(".btn-buy");

            // Kiểm tra xem đã chọn đủ cả màu VÀ dung lượng chưa
            const needsColor = productVariants.some((v) => v.color);
            const needsStorage = productVariants.some((v) => v.storage);

            // Nếu chưa chọn đủ thì disable nút
            if (
                (needsColor && !selectedColor) ||
                (needsStorage && !selectedStorage)
            ) {
                if (btnBuy) {
                    btnBuy.disabled = true;
                    btnBuy.style.opacity = "0.5";
                    btnBuy.title = "Vui lòng chọn đầy đủ các tùy chọn";
                }
                return;
            }

            // Tìm variant khớp CHÍNH XÁC với color và storage đã chọn
            const matchedVariant = productVariants.find((variant) => {
                return (
                    variant.color === selectedColor &&
                    variant.storage === selectedStorage
                );
            });

            if (matchedVariant) {
                // Cập nhật giá
                const currentPrice = document.querySelector(".current-price");
                const oldPrice = document.querySelector(".old-price");
                const savePrice = document.querySelector(".price-box__save");

                if (currentPrice) {
                    currentPrice.textContent =
                        new Intl.NumberFormat("vi-VN").format(
                            matchedVariant.price
                        ) + " ₫";
                }

                if (
                    matchedVariant.old_price &&
                    matchedVariant.old_price > matchedVariant.price
                ) {
                    if (oldPrice) {
                        oldPrice.textContent =
                            new Intl.NumberFormat("vi-VN").format(
                                matchedVariant.old_price
                            ) + " ₫";
                        oldPrice.style.display = "inline";
                    }
                    if (savePrice) {
                        const saved =
                            matchedVariant.old_price - matchedVariant.price;
                        savePrice.textContent =
                            "Tiết kiệm: " +
                            new Intl.NumberFormat("vi-VN").format(saved) +
                            " ₫";
                        savePrice.style.display = "block";
                    }
                } else {
                    if (oldPrice) oldPrice.style.display = "none";
                    if (savePrice) savePrice.style.display = "none";
                }

                // Cập nhật ảnh theo biến thể
                const mainImg = document.getElementById("main-img");
                if (mainImg) {
                    // Ưu tiên dùng image_url (đã xử lý đầy đủ), fallback về image
                    mainImg.src =
                        matchedVariant.image_url || matchedVariant.image;
                }

                // Cập nhật stock và giới hạn input
                const qtyInput = document.querySelector(".qty-input");
                if (qtyInput) {
                    qtyInput.setAttribute("max", matchedVariant.stock);
                    // Nếu giá trị hiện tại lớn hơn stock, giảm xuống
                    if (parseInt(qtyInput.value) > matchedVariant.stock) {
                        qtyInput.value =
                            matchedVariant.stock > 0 ? matchedVariant.stock : 1;
                    }
                    // Nếu stock = 0, set input = 0 và disable
                    if (matchedVariant.stock <= 0) {
                        qtyInput.value = 0;
                        qtyInput.disabled = true;
                    } else {
                        qtyInput.disabled = false;
                    }
                }

                // Cập nhật trạng thái còn hàng và hiển thị số lượng
                const stockStatus = document.getElementById("stock-status");
                const stockQuantity = document.getElementById("stock-quantity");
                if (stockStatus) {
                    if (matchedVariant.stock > 0) {
                        stockStatus.innerHTML =
                            '<span style="color: #00c030;">Còn hàng: <strong id="stock-quantity">' +
                            matchedVariant.stock +
                            "</strong></span>";
                    } else {
                        stockStatus.innerHTML =
                            '<span style="color: #ff424f;">Hết hàng</span>';
                    }
                }

                // Cập nhật variant_id vào form
                const variantIdInput = document.getElementById(
                    "selected-variant-id"
                );
                if (variantIdInput) {
                    variantIdInput.value = matchedVariant.id;
                    console.log(
                        "Updated variant_id to:",
                        matchedVariant.id,
                        "Color:",
                        matchedVariant.color,
                        "Storage:",
                        matchedVariant.storage
                    );
                }

                // Cập nhật button thêm giỏ hàng
                const btnBuy = document.querySelector(".btn-buy");
                if (btnBuy) {
                    if (matchedVariant.stock > 0) {
                        btnBuy.disabled = false;
                        btnBuy.style.opacity = "1";
                        btnBuy.title = "Thêm vào giỏ hàng";
                    } else {
                        btnBuy.disabled = true;
                        btnBuy.style.opacity = "0.5";
                        btnBuy.title = "Hết hàng";
                    }
                }
            }
        }

        // Gọi lần đầu để hiển thị thông tin variant mặc định và cập nhật available options
        updateAvailableOptions();
        updateProductInfo();
    }
});

// public/assets/js/product-detail.js

document.addEventListener("DOMContentLoaded", function () {
    // --- PHẦN 1: TĂNG GIẢM SỐ LƯỢNG VỚI GIỚI HẠN ---
    const minusBtn = document.querySelector(".qty-btn.minus");
    const plusBtn = document.querySelector(".qty-btn.plus");
    const qtyInput = document.querySelector(".qty-input");

    if (minusBtn && plusBtn && qtyInput) {
        // Xử lý nút tăng
        plusBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn form submit
            let val = parseInt(qtyInput.value) || 0;
            let max = parseInt(qtyInput.getAttribute("max")) || 999;
            if (val < max) {
                qtyInput.value = val + 1;
            }
        });

        // Xử lý nút giảm
        minusBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn form submit
            let val = parseInt(qtyInput.value) || 0;
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        });

        // Xử lý khi nhập trực tiếp vào input
        qtyInput.addEventListener("input", function () {
            let val = parseInt(this.value) || 0;
            let max = parseInt(this.getAttribute("max")) || 999;
            let min = parseInt(this.getAttribute("min")) || 1;

            // Giới hạn giá trị
            if (val > max) {
                this.value = max;
            } else if (val < min) {
                this.value = min;
            }
        });
    }

    // --- PHẦN 2: GỬI AJAX ADD TO CART (QUAN TRỌNG) ---
    const addCartForm = document.getElementById("add-to-cart-form");

    if (addCartForm) {
        addCartForm.addEventListener("submit", function (e) {
            e.preventDefault(); // 1. Chặn load trang

            // Kiểm tra số lượng trước khi submit
            const qtyInput = document.querySelector(".qty-input");
            const quantity = parseInt(qtyInput.value) || 0;
            const maxStock = parseInt(qtyInput.getAttribute("max")) || 0;

            if (quantity <= 0) {
                showToast("Vui lòng chọn số lượng!", "error");
                return;
            }

            if (quantity > maxStock) {
                showToast(`Chỉ còn ${maxStock} sản phẩm trong kho!`, "error");
                qtyInput.value = maxStock;
                return;
            }

            const url = this.action;
            const formData = new FormData(this);

            // Debug: Log form data
            console.log("Form submitting with data:");
            for (let [key, value] of formData.entries()) {
                console.log(key + ": " + value);
            }

            // 2. Gửi Ajax
            fetch(url, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // 3. Cập nhật Icon Header
                        const cartIconContainer = document.querySelector(
                            ".navbar__actions-item--cart"
                        );
                        let cartNotice = document.querySelector(
                            ".navbar__cart-notice"
                        );

                        if (!cartNotice && cartIconContainer) {
                            // Nếu chưa có số (giỏ rỗng) thì tạo mới
                            cartNotice = document.createElement("span");
                            cartNotice.className = "navbar__cart-notice";
                            cartIconContainer.prepend(cartNotice);
                        }
                        if (cartNotice) {
                            cartNotice.innerText = data.cartCount;
                            cartNotice.style.display = "block";
                            cartNotice.style.animation = "none";
                            cartNotice.offsetHeight; /* trigger reflow */
                            cartNotice.style.animation = "shake 0.5s";
                        }
                        // 4. CẬP NHẬT NỘI DUNG MODAL (QUAN TRỌNG)
                        const cartBody =
                            document.getElementById("cart-body-content");
                        if (cartBody) {
                            cartBody.innerHTML = data.cartHTML; // Thay thế HTML cũ bằng cái mới

                            // 5. Gán lại sự kiện đóng modal cho các nút mới sinh ra
                            const closeBtns = cartBody.querySelectorAll(
                                ".close-modal-btn, .modal-cart__close-btn"
                            );
                            closeBtns.forEach((btn) => {
                                btn.addEventListener("click", function () {
                                    document
                                        .querySelector(".modal-cart")
                                        .classList.add("hidden");
                                });
                            });
                        }

                        // 6. Mở Modal ra cho khách thấy luôn
                        // Gọi hàm thông báo tự chế
                        showToast(data.message, "success");
                        // document.querySelector('.modal-cart').classList.remove('hidden');
                    }
                })
                .catch((error) => console.error("Lỗi:", error));
        });
    }
});
