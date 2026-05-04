
<div class="reviews-container">
    
    <div class="reviews-header">
        <h2 class="reviews-title">
            <i class="fas fa-star"></i> Đánh giá sản phẩm
        </h2>
        
        <?php
            $avgRating = $product->average_rating;
            $reviewCount = $product->review_count;
        ?>

        
        <div class="rating-summary">
            <div class="rating-score">
                <span class="score-number"><?php echo e(number_format($avgRating, 1)); ?></span>
                <div class="score-stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= floor($avgRating)): ?>
                            <i class="fas fa-star"></i>
                        <?php elseif($i - 0.5 <= $avgRating): ?>
                            <i class="fas fa-star-half-alt"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="score-count">(<?php echo e($reviewCount); ?> đánh giá)</span>
            </div>
        </div>
    </div>

    
    <div class="reviews-list">
        <?php $__empty_1 = true; $__currentLoopData = $product->approvedReviews()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="reviewer-details">
                            <h4 class="reviewer-name"><?php echo e($review->user->name); ?></h4>
                            <div class="review-rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= $review->rating ? 'active' : ''); ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="review-date">
                        <?php echo e($review->created_at->diffForHumans()); ?>

                    </div>
                </div>
                
                <?php if($review->comment): ?>
                    <div class="review-content">
                        <p><?php echo e($review->comment); ?></p>
                    </div>
                <?php endif; ?>

                
                <?php if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin')): ?>
                    <form action="<?php echo e(route('review.destroy', $review->id)); ?>" method="POST" class="review-delete-form" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-delete-review">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="no-reviews">
                <i class="far fa-comment-dots"></i>
                <p>Chưa có đánh giá nào cho sản phẩm này</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
.reviews-container {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    margin-top: 30px;
}

.reviews-header {
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.reviews-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.reviews-title i {
    color: #ffc107;
    margin-right: 8px;
}

.rating-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.rating-score {
    display: flex;
    align-items: center;
    gap: 15px;
}

.score-number {
    font-size: 48px;
    font-weight: bold;
    color: #333;
}

.score-stars {
    display: flex;
    gap: 3px;
}

.score-stars i {
    font-size: 20px;
    color: #ffc107;
}

.score-count {
    color: #666;
    font-size: 14px;
}

.btn-write-review {
    background: #0066cc;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-write-review:hover {
    background: #0052a3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.review-item {
    border-bottom: 1px solid #f0f0f0;
    padding: 25px 0;
    position: relative;
}

.review-item:last-child {
    border-bottom: none;
}

.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.reviewer-info {
    display: flex;
    gap: 15px;
}

.reviewer-avatar i {
    font-size: 48px;
    color: #ddd;
}

.reviewer-name {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.review-rating {
    display: flex;
    gap: 3px;
}

.review-rating i {
    font-size: 14px;
    color: #ddd;
}

.review-rating i.active {
    color: #ffc107;
}

.review-date {
    color: #999;
    font-size: 13px;
}

.review-content p {
    color: #555;
    line-height: 1.6;
    margin: 0;
}

.no-reviews {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

.no-reviews i {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.no-reviews p {
    font-size: 16px;
    margin-bottom: 20px;
}

.btn-delete-review {
    background: transparent;
    border: 1px solid #dc3545;
    color: #dc3545;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    margin-top: 10px;
    transition: all 0.3s;
}

.btn-delete-review:hover {
    background: #dc3545;
    color: #fff;
}

@media (max-width: 768px) {
    .reviews-container {
        padding: 20px;
    }
    
    .rating-summary {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .score-number {
        font-size: 36px;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\techstore\resources\views/reviews/partials/reviews-list.blade.php ENDPATH**/ ?>