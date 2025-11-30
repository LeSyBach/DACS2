{{-- FILE: resources/views/checkout/payment_cod.blade.php --}}

<div class="cod-content payment-content-block">
    
    <div class="cod-header">
        <i class="fa-solid fa-truck-fast cod-header__icon"></i>
    </div>

    <h3 class="cod-content__heading">Thanh toán khi nhận hàng</h3>
    
    <p class="cod-content__delivery-info">Giao hàng 2-3 ngày làm việc</p>
    
    <div class="cod-content__money-box">
        <i class="fa-solid fa-money-bill-wave cod-content__money-icon"></i>
        <span class="cod-content__money-label">Bạn cần chuẩn bị số tiền:</span>
        <div class="cod-content__total-amount">
            {{-- SỬ DỤNG $grandTotal ĐƯỢC TRUYỀN TỪ CheckoutController --}}
            {{ number_format($grandTotal ?? 0, 0, ',', '.') }} ₫
        </div>
        <p class="cod-content__money-text">Vui lòng chuẩn bị số tiền chính xác để thanh toán cho người gửi hàng</p>
    </div>
    
    <div class="cod-content__warning-box">
        <span class="cod-content__warning-label">Lưu ý:</span> 
        <span class="cod-content__warning-text">Kiểm tra kỹ năng sản phẩm trước khi thanh toán</span>
    </div>
</div>