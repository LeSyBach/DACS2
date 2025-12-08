{{-- FILE: resources/views/checkout/payment_zalopay.blade.php --}}
{{-- Sử dụng $grandTotal được truyền từ Controller/AJAX --}}
@php
    // Gán giá trị mặc định nếu biến không tồn tại (để tránh lỗi)
    $grandTotalDisplay = number_format($grandTotal ?? 0, 0, ',', '.') . ' ₫';
@endphp

<div class="zalopay-content payment-content-block">
    
    <h3 class="zalopay-content__heading">Thanh toán qua ZaloPay</h3>
    <p class="zalopay-content__instruction">Vui lòng quét mã QR để hoàn tất giao dịch.</p>
    
    {{-- KHỐI HIỂN THỊ QR CODE --}}
    <div class="zalopay-qr__display" id="zalopay-qr-area">
        {{-- Nơi QR Code sẽ được tạo (bằng JS/AJAX sau khi order được tạo) --}}
        
        {{-- Tạm thời hiển thị ảnh placeholder hoặc loading icon --}}
        <i class="fa-solid fa-spinner fa-spin" style="font-size: 32px; color: #ccc;"></i>
        <p style="margin-top: 10px; font-size: 14px; color: #555;">Đang tạo giao dịch...</p>
        
    </div>
    
    {{-- KHỐI TỔNG TIỀN VÀ HƯỚNG DẪN --}}
    <div class="zalopay-content__total-box">
        <span class="zalopay-content__total-label">Tổng tiền:</span>
        <div class="zalopay-content__total-amount" style="color: #0070c7;">{{ $grandTotalDisplay }}</div>
    </div>
    <p class="zalopay-content__expiry-note">
        Mã giao dịch sẽ hết hạn sau 15 phút.
    </p>

    <div class="zalopay-content__warning-box">
        <i class="fa-solid fa-circle-exclamation" style="color: #ff9800; margin-right: 5px;"></i>
        <span class="cod-content__warning-text">Vui lòng không đóng trang này cho đến khi thanh toán hoàn tất.</span>
    </div>

</div>