
{{-- FILE: resources/views/checkout/payment.blade.php --}}
@extends('layouts.app') 

@section('title', 'Thanh toán - Bước 2: Chọn phương thức')

@section('content')
    <div class="grid wide checkout-container">
        <a href="{{ route('checkout.show') }}" class="back-link">
            ← Quay lại
        </a>
        @include('checkout.steps', ['step' => 2]) 

        {{-- Form này gửi yêu cầu ĐẶT HÀNG cuối cùng --}}
        <form id="payment-form" method="POST" action="{{ route('checkout.place_order') }}">
            @csrf
            
            {{-- HÀNG CHÍNH CHỨA 3 CỘT ĐỘC LẬP: OPTIONS, CONTENT, SUMMARY --}}
            <div class="row">
                
                {{-- CỘT 1: TÙY CHỌN THANH TOÁN (l-3) --}}
                {{-- Đây là khối chứa các radio button COD/ZaloPay --}}
                <div class="col c-12 l-4 payment-options-wrapper">
                    <div class="checkout-card payment-options-card">
                        
                        <h3 class="options-heading">Choose thanh toán phương thức</h3>
                        
                        <div class="payment-options">
                            @error('payment_method')
                                <div class="alert alert-danger error-message">Vui lòng chọn phương thức thanh toán.</div>
                            @enderror
                            
                            {{-- OPTION 1: COD --}}
                            <div class="payment-options__option payment-options__option--selected" data-method="cod">
                                <label class="payment-options__label">
                                    <i class="fa-solid fa-truck"></i>
                                    <input type="radio" name="payment_method" value="cod" required checked class="payment-options__radio">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            
                            {{-- OPTION 2: ZALOPAY --}}
                            <div class="payment-options__option" data-method="zalopay">
                                <label class="payment-options__label">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <input type="radio" name="payment_method" value="zalopay" required class="payment-options__radio">
                                    Thanh toán bằng ZaloPay
                                </label>
                            </div>

                            {{-- OPTIONS KHÁC (ẨN) --}}
                            <div class="payment-options__option disabled-option">
                                <label class="payment-options__label"><i class="fa-solid fa-wallet"></i><input type="radio" name="payment_method" value="momo" disabled class="payment-options__radio">Ví MoMo</label>
                            </div>
                            <div class="payment-options__option disabled-option">
                                <label class="payment-options__label"><i class="fa-solid fa-bank"></i><input type="radio" name="payment_method" value="bank" disabled class="payment-options__radio">Chuyển khoản ngân hàng</label>
                            </div>
                            <div class="payment-options__option disabled-option">
                                <label class="payment-options__label"><i class="fa-solid fa-credit-card"></i><input type="radio" name="payment_method" value="credit" disabled class="payment-options__radio">Thẻ tín dụng/Ghi nợ</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-checkout">
                            <i class="fa-solid fa-check"></i> Xác nhận đặt hàng COD
                        </button>
                    </div>
                    
                    
                </div>
                
                {{-- CỘT 2: NỘI DUNG THANH TOÁN ĐỘNG (l-4) --}}
                {{-- Khối này sẽ hiển thị chi tiết COD hoặc QR Code --}}
                <div class="col c-12 l-4 payment-content-display-col">
                    <div class="checkout-card payment-display-card">
                        <div id="payment-content-display">
                            @include('checkout.payment_cod', ['grandTotal' => $grandTotal]) {{-- Mặc định load COD --}}
                        </div>
                    </div>
                </div>

                {{-- CỘT 3: TÓM TẮT ĐƠN HÀNG (l-5) --}}
                <div class="col c-12 l-4">
                    @include('checkout.summary', ['cartItems' => $cartItems])
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout_styles.css') }}">
@endpush

@push('scripts')
<script>
    function goBackStep() {
        // Hàm này sẽ quay trở lại trang web trước đó trong lịch sử trình duyệt.
        // Ví dụ: Quay lại từ Bước 2 (Thanh toán) về Bước 1 (Thông tin).
        window.history.back();
    }
</script>
@endpush

@push('scripts')
<script>
    // JS Logic để chuyển đổi nội dung (COD <=> ZALOPAY)
    document.addEventListener('DOMContentLoaded', function() {
        const options = document.querySelectorAll('.payment-options__option');
        const displayContainer = document.getElementById('payment-content-display');
        
        // Hàm để load nội dung động (Bạn cần tạo file blade riêng cho ZaloPay QR)
        function loadPaymentContent(method) {
            displayContainer.innerHTML = ''; 
            
            let content = '';
            
            // Tạm thời dùng AJAX để lấy nội dung HTML (hoặc dùng if/else/switch case)
            switch(method) {
                case 'cod':
                    // Giả định bạn có file payment_cod.blade.php
                    content = `@include('checkout.payment_cod')`; 
                    break;
                case 'zalopay':
                    // Giả định bạn có file payment_zalopay.blade.php (có thể chứa logic QR)
                    {{-- //content = `@include('checkout.payment_zalopay')`;  --}}
                    break;
                default:
                    content = `<p style="text-align: center; color: #999;">Vui lòng chọn phương thức thanh toán.</p>`;
            }
            
            displayContainer.innerHTML = content;
        }

        // Xử lý sự kiện click vào tùy chọn thanh toán
        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(o => o.classList.remove('payment-options__option--selected'));
                this.classList.add('payment-options__option--selected');

                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    loadPaymentContent(radio.value); 
                }
            });
        });
        
        // Load nội dung COD mặc định khi tải trang
        loadPaymentContent('cod');
    });
</script>
@endpush