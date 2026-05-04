
<?php
    $currentStep = $step ?? 1;
    
    // HÀM CHỈ TÍNH TOÁN MÀU DỰA TRÊN TRẠNG THÁI (Logic động)
    $getColor = function ($s) use ($currentStep) {
        return $s <= $currentStep ? '#009689' : '#ccc'; // Sử dụng màu cố định cho Blade
    };
    $getStatusClass = function ($s) use ($currentStep) {
        return $s <= $currentStep ? 'step-item--completed' : 'step-item--pending';
    };
?>


<div class="checkout-steps-bar">
    
    
    <div class="step-item <?php echo e($getStatusClass(1)); ?>">
        
        <div class="step-icon" style="background-color: <?php echo e($getColor(1)); ?>;">1</div>
        
        <span class="step-label" style="color: <?php echo e($getColor(1)); ?>;">Thông tin</span>
    </div>

    
    <div class="step-connector" style="background-color: <?php echo e($getColor(2)); ?>;"></div>


    
    <div class="step-item <?php echo e($getStatusClass(2)); ?>">
        <div class="step-icon" style="background-color: <?php echo e($getColor(2)); ?>;">2</div>
        <span class="step-label" style="color: <?php echo e($getColor(2)); ?>;">Thanh toán</span>
    </div>

    
    <div class="step-connector" style="background-color: <?php echo e($getColor(3)); ?>;"></div>


    
    <div class="step-item <?php echo e($getStatusClass(3)); ?>">
        <div class="step-icon" style="background-color: <?php echo e($getColor(3)); ?>;">3</div>
        <span class="step-label" style="color: <?php echo e($getColor(3)); ?>;">Hoàn thành</span>
    </div>
</div><?php /**PATH C:\xampp\htdocs\techstore\resources\views/checkout/steps.blade.php ENDPATH**/ ?>