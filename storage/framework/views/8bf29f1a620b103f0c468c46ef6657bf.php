<div class="modal-cart__header">
  <h3 class="modal-cart__heading">Giỏ hàng</h3>
  <span class="modal-cart__close-btn">&times;</span>
</div>




<?php if(
    empty($cartData) 
    || (is_object($cartData) && $cartData->isEmpty()) 
    || (is_array($cartData) && count($cartData) == 0)
): ?>
  
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
<?php else: ?>
  
  <?php
      $totalCartPrice = 0;
  ?>

  
  <div class="modal-cart__products">
    <ul class="modal-cart__product-list">
      <?php $__currentLoopData = $cartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          // Xử lý dữ liệu Giỏ hàng (Mảng Session vs. Model DB)
          if ($item instanceof \App\Models\CartItem) {
              // Dữ liệu từ Database (Đã đăng nhập)
              $cartItemId  = $item->id;  // ID của cart_item (QUAN TRỌNG)
              $id          = $item->product_id; 
              $product     = $item->product;
              $variant     = $item->variant;
              $quantity    = $item->quantity;
              $price       = $variant ? $variant->price : ($product->price ?? 0);
              $productName = $product->name ?? 'Sản phẩm không rõ';
              $image       = ($variant && $variant->image) ? $variant->image_url : ($product->image_url ?? '');
              $variantName = $variant ? $variant->display_name : null;
          } else {
              // Dữ liệu từ Session (Chưa đăng nhập)
              // cartItemId phải khớp với key trong session cart (product_id:variant_id hoặc product_id:0)
              $cartItemId  = $item['product_id'] . ':' . ($item['variant_id'] ?? '0');
              $id          = $item['product_id'] ?? null;
              $quantity    = $item['quantity'];
              $price       = $item['price'];
              $productName = $item['name'];
              $image       = $item['image'];
              $variantName = $item['variant_name'] ?? null;
          }
          
          $itemTotal       = $price * $quantity;
          $totalCartPrice += $itemTotal;
        ?>

        
        <?php if($id): ?> 
          <li class="modal-cart__product-item" id="cart-item-<?php echo e($cartItemId); ?>">
            <img src="<?php echo e($image); ?>" alt="<?php echo e($productName); ?>" class="modal-cart__product-img">
            
            <div class="modal-cart__product-info">
              <h4 class="modal-cart__product-name">
                <?php echo e($productName); ?>

                <?php if($variantName): ?>
                  <span class="variant-badge"><?php echo e($variantName); ?></span>
                <?php endif; ?>
              </h4>
              
              <div class="modal-cart__actions">
                <div class="modal-cart__quantity-control">
                  <a href="javascript:void(0)" 
                     data-url="<?php echo e(route('cart.update', ['id' => $cartItemId, 'action' => 'decrease'])); ?>" 
                     data-id="<?php echo e($cartItemId); ?>" 
                     class="modal-cart__btn--decrease ajax-cart-btn"
                     style="text-decoration: none; display:flex; align-items:center; justify-content:center;">
                    -
                  </a>
                  
                  <span class="modal-cart__quantity" id="qty-<?php echo e($cartItemId); ?>"><?php echo e($quantity); ?></span>
                  
                  <a href="javascript:void(0)" 
                     data-url="<?php echo e(route('cart.update', ['id' => $cartItemId, 'action' => 'increase'])); ?>" 
                     data-id="<?php echo e($cartItemId); ?>" 
                     class="modal-cart__btn--increase ajax-cart-btn"
                     style="text-decoration: none; display:flex; align-items:center; justify-content:center;">
                    +
                  </a>
                </div>
                
                <a href="javascript:void(0)" 
                   data-id="<?php echo e($cartItemId); ?>" 
                   data-url="<?php echo e(route('cart.remove', ['id' => $cartItemId])); ?>" 
                   class="modal-cart__remove-btn ajax-remove-btn">
                  <i class="modal-cart__remove-icon fa-regular fa-trash-can"></i>
                </a>
              </div>
              
              <span class="modal-cart__product-price" id="price-<?php echo e($cartItemId); ?>">
                <?php echo e(number_format($itemTotal, 0, ',', '.')); ?> ₫
              </span>
            </div>
          </li>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
    <div class="modal__cart-footer">
      <div class="modal-cart__summary">
        <div class="modal-cart__row modal-cart__total">
          <span class="modal-cart__label">Tổng cộng:</span>
          <span class="modal-cart__value" id="cart-total">
            <?php echo e(number_format($totalCartPrice, 0, ',', '.')); ?> ₫
          </span>
        </div>
      </div>
      <div class="modal-cart__checkout">
        <a href="<?php echo e(route('checkout.show')); ?>" class="modal-cart__btn modal-cart__btn--checkout" 
           style="text-align: center; text-decoration: none; display: block;">
          Thanh toán
        </a>
        <button class="modal-cart__btn modal-cart__btn--continue close-modal-btn">
          Tiếp tục mua sắm
        </button>
      </div>
    </div>
  </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/partials/cart-mini.blade.php ENDPATH**/ ?>