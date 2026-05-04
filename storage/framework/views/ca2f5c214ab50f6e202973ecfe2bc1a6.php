

 

<?php $__env->startSection('title', 'Thanh toán - Bước 2: Chọn phương thức'); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid wide checkout-container">
        <a href="<?php echo e(route('checkout.show')); ?>" class="back-link">
            ← Quay lại
        </a>
        <?php echo $__env->make('checkout.steps', ['step' => 2], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

        
        <form id="payment-form" method="POST" action="<?php echo e(route('checkout.place_order')); ?>">
            <?php echo csrf_field(); ?>
            
            
            <div class="row">
                
                
                
                <div class="col c-12 l-4 payment-options-wrapper">
                    <div class="checkout-card payment-options-card">
                        
                        <h3 class="options-heading">Chọn phương thức thanh toán</h3>
                        
                        <div class="payment-options">
                            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-danger error-message">Vui lòng chọn phương thức thanh toán.</div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            
                            <div class="payment-options__option payment-options__option--selected" data-method="cod">
                                <label class="payment-options__label">
                                    <i class="fa-solid fa-truck"></i>
                                    <input type="radio" name="payment_method" value="cod" required checked class="payment-options__radio">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            
                            
                            <div class="payment-options__option" data-method="zalopay">
                                <label class="payment-options__label">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <input type="radio" name="payment_method" value="zalopay" required class="payment-options__radio">
                                    Thanh toán bằng ZaloPay
                                </label>
                            </div>

                            
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
                
                
                
                <div class="col c-12 l-4 payment-content-display-col">
                    <div class="checkout-card payment-display-card">
                        <div id="payment-content-display">
                            <?php echo $__env->make('checkout.payment_cod', ['grandTotal' => $grandTotal], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
                        </div>
                    </div>
                </div>

                
                <div class="col c-12 l-4">
                    <?php echo $__env->make('checkout.summary', ['cartItems' => $cartItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/checkout_styles.css')); ?>">
    <style>
        /* Custom CSS cho spacing và font size */
        .payment-options__label {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .payment-options__label i {
            margin-left: 8px;
        }
        
        .payment-options__label {
            font-size: 15px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function goBackStep() {
        // Hàm này sẽ quay trở lại trang web trước đó trong lịch sử trình duyệt.
        // Ví dụ: Quay lại từ Bước 2 (Thanh toán) về Bước 1 (Thông tin).
        window.history.back();
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
                    content = `<?php echo $__env->make('checkout.payment_cod', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>`; 
                    break;
                case 'zalopay':
                    // Giả định bạn có file payment_zalopay.blade.php (có thể chứa logic QR)
                    content = `<?php echo $__env->make('checkout.payment_zalopay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>`; 
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/checkout/payment.blade.php ENDPATH**/ ?>