{{-- FILE: resources/views/checkout/summary.blade.php --}}

<div class="checkout-summary-card">
    <h3 class="modal-cart__heading">Đơn hàng của bạn</h3>

    <ul class="summary-product-list">
        @php
            $subtotal = 0;
            $shippingFee = 30000; // Phí vận chuyển mặc định (ví dụ)
            $taxRate = 0.10; // 10% VAT (ví dụ)
        @endphp

        @foreach($cartItems as $item)
            @php
                // Xử lý dữ liệu cho Session Array và DB Model
                if (is_object($item)) { 
                    $price = $item->product->price ?? 0;
                    $quantity = $item->quantity;
                    $productName = $item->product->name ?? 'Sản phẩm không rõ';
                } else {
                    $price = $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 0;
                    $productName = $item['name'];
                }
                $itemTotal = $price * $quantity;
                $subtotal += $itemTotal;
            @endphp
            
            <li class="summary-product-item">
                <span class="summary-product-name">{{ $productName }} (x{{ $quantity }})</span>
                <span class="summary-product-price">{{ number_format($itemTotal, 0, ',', '.') }}₫</span>
            </li>
        @endforeach
    </ul>

    <hr class="summary-divider">

    <div class="summary-details">
        <p class="summary-row">
            <span class="summary-label">Tạm tính:</span>
            <span class="summary-value">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
        </p>
        
        <p class="summary-row">
            <span class="summary-label">Phí vận chuyển:</span>
            <span class="summary-value">{{ number_format($shippingFee, 0, ',', '.') }}₫</span>
        </p>

        @php
            $vat = ($subtotal + $shippingFee) * $taxRate;
            $grandTotal = $subtotal + $shippingFee + $vat;
        @endphp
        
        <p class="summary-row">
            <span class="summary-label">Thuế GTGT (10%):</span>
            <span class="summary-value">{{ number_format($vat, 0, ',', '.') }}₫</span>
        </p>
    </div>

    <hr class="summary-divider">

    <div class="summary-total">
        <span>Tổng cộng:</span>
        <span id="grand-total">{{ number_format($grandTotal, 0, ',', '.') }}₫</span>
    </div>
</div>
