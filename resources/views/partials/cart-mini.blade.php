<div class="modal-cart__header">
  <h3 class="modal-cart__heading">Giỏ hàng</h3>
  <span class="modal-cart__close-btn">&times;</span>
</div>

{{-- SỬ DỤNG BIẾN $cartData được truyền từ CartController --}}
{{-- Nếu $cartData là một Collection Eloquent, chúng ta dùng count() hoặc isEmpty() --}}
{{-- @if(empty($cartData) || $cartData->isEmpty() || count($cartData) == 0) --}}
@if(
    empty($cartData) 
    || (is_object($cartData) && $cartData->isEmpty()) 
    || (is_array($cartData) && count($cartData) == 0)
)
  {{-- GIỎ RỖNG --}}
  <div class="modal-cart__empty" style="display: block;">
    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" 
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
         stroke-linecap="round" stroke-linejoin="round" 
         class="lucide lucide-shopping-bag h-16 w-16 text-gray-300">
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
      <path d="M3 6h18"></path>
      <path d="M16 10a4 4 0 0 1-8 0"></path>
    </svg>
    <p class="modal-cart__empty-text">Giỏ hàng trống</p>
    <button class="modal-cart__continue-btn close-modal-btn">Tiếp tục mua sắm</button>
  </div>
@else
  {{-- Khởi tạo tổng tiền --}}
  @php
      $totalCartPrice = 0;
  @endphp

  {{-- CÓ HÀNG --}}
  <div class="modal-cart__products">
    <ul class="modal-cart__product-list">
      @foreach($cartData as $item)
        @php
          // Xử lý dữ liệu Giỏ hàng (Mảng Session vs. Model DB)
          if ($item instanceof \App\Models\CartItem) {
              // Dữ liệu từ Database (Đã đăng nhập)
              $id          = $item->product_id; 
              $product     = $item->product; 
              $quantity    = $item->quantity;
              $price       = $product->price ?? 0;
              $productName = $product->name ?? 'Sản phẩm không rõ';
              $image       = $product->image ?? '';
          } else {
              // Dữ liệu từ Session (Chưa đăng nhập)
              $id          = $item['product_id'] ?? null;
              $quantity    = $item['quantity'];
              $price       = $item['price'];
              $productName = $item['name'];
              $image       = $item['image'];
          }
          
          $itemTotal       = $price * $quantity;
          $totalCartPrice += $itemTotal;
        @endphp

        {{-- Đảm bảo sản phẩm có ID để hiển thị --}}
        @if($id) 
          <li class="modal-cart__product-item" id="cart-item-{{ $id }}">
            <img src="{{ $image }}" alt="{{ $productName }}" class="modal-cart__product-img">
            
            <div class="modal-cart__product-info">
              <h4 class="modal-cart__product-name">{{ $productName }}</h4>
              
              <div class="modal-cart__actions">
                <div class="modal-cart__quantity-control">
                  <a href="javascript:void(0)" 
                     data-url="{{ route('cart.update', ['id' => $id, 'action' => 'decrease']) }}" 
                     data-id="{{ $id }}" 
                     class="modal-cart__btn--decrease ajax-cart-btn"
                     style="text-decoration: none; display:flex; align-items:center; justify-content:center;">
                    -
                  </a>
                  
                  <span class="modal-cart__quantity" id="qty-{{ $id }}">{{ $quantity }}</span>
                  
                  <a href="javascript:void(0)" 
                     data-url="{{ route('cart.update', ['id' => $id, 'action' => 'increase']) }}" 
                     data-id="{{ $id }}" 
                     class="modal-cart__btn--increase ajax-cart-btn"
                     style="text-decoration: none; display:flex; align-items:center; justify-content:center;">
                    +
                  </a>
                </div>
                
                <a href="javascript:void(0)" 
                   data-id="{{ $id }}" 
                   data-url="{{ route('cart.remove', ['id' => $id]) }}" 
                   class="modal-cart__remove-btn ajax-remove-btn">
                  <i class="modal-cart__remove-icon fa-regular fa-trash-can"></i>
                </a>
              </div>
              
              <span class="modal-cart__product-price" id="price-{{ $id }}">
                {{ number_format($itemTotal, 0, ',', '.') }} ₫
              </span>
            </div>
          </li>
        @endif
      @endforeach
    </ul>
    
    <div class="modal__cart-footer">
      <div class="modal-cart__summary">
        <div class="modal-cart__row modal-cart__total">
          <span class="modal-cart__label">Tổng cộng:</span>
          <span class="modal-cart__value" id="cart-total">
            {{ number_format($totalCartPrice, 0, ',', '.') }} ₫
          </span>
        </div>
      </div>
      <div class="modal-cart__checkout">
        <a href="{{ route('checkout.show') }}" class="modal-cart__btn modal-cart__btn--checkout" 
           style="text-align: center; text-decoration: none; display: block;">
          Thanh toán
        </a>
        <button class="modal-cart__btn modal-cart__btn--continue close-modal-btn">
          Tiếp tục mua sắm
        </button>
      </div>
    </div>
  </div>
@endif