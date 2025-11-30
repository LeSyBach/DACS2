{{-- FILE: resources/views/checkout/steps.blade.php --}}
@php
    $currentStep = $step ?? 1;
    
    // HÀM CHỈ TÍNH TOÁN MÀU DỰA TRÊN TRẠNG THÁI (Logic động)
    $getColor = function ($s) use ($currentStep) {
        return $s <= $currentStep ? '#009689' : '#ccc'; // Sử dụng màu cố định cho Blade
    };
    $getStatusClass = function ($s) use ($currentStep) {
        return $s <= $currentStep ? 'step-item--completed' : 'step-item--pending';
    };
@endphp

{{-- Khung chính: Sử dụng class CSS --}}
<div class="checkout-steps-bar">
    
    {{-- BƯỚC 1: THÔNG TIN --}}
    <div class="step-item {{ $getStatusClass(1) }}">
        {{-- Màu sắc động cho icon (backgroundColor) --}}
        <div class="step-icon" style="background-color: {{ $getColor(1) }};">1</div>
        {{-- Màu sắc động cho label --}}
        <span class="step-label" style="color: {{ $getColor(1) }};">Thông tin</span>
    </div>

    {{-- Dấu nối (Màu sắc động) --}}
    <div class="step-connector" style="background-color: {{ $getColor(2) }};"></div>


    {{-- BƯỚC 2: THANH TOÁN --}}
    <div class="step-item {{ $getStatusClass(2) }}">
        <div class="step-icon" style="background-color: {{ $getColor(2) }};">2</div>
        <span class="step-label" style="color: {{ $getColor(2) }};">Thanh toán</span>
    </div>

    {{-- Dấu nối (Màu sắc động) --}}
    <div class="step-connector" style="background-color: {{ $getColor(3) }};"></div>


    {{-- BƯỚC 3: HOÀN THÀNH --}}
    <div class="step-item {{ $getStatusClass(3) }}">
        <div class="step-icon" style="background-color: {{ $getColor(3) }};">3</div>
        <span class="step-label" style="color: {{ $getColor(3) }};">Hoàn thành</span>
    </div>
</div>