{{-- FILE: resources/views/reviews/partials/review-modal-dynamic.blade.php --}}
<div id="reviewModalDynamic" class="review-modal" style="display: none;">
    <div class="review-modal-overlay" onclick="closeReviewModalDynamic()"></div>
    <div class="review-modal-content">
        <button class="review-modal-close" onclick="closeReviewModalDynamic()">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="review-modal-title">
            <i class="fas fa-star"></i> Đánh giá sản phẩm
        </h3>

        <p class="review-product-name" id="reviewProductName"></p>

        <form action="" method="POST" class="review-form" id="reviewFormDynamic">
            @csrf

            {{-- RATING --}}
            <div class="form-group">
                <label class="form-label">Chọn số sao <span class="required">*</span></label>
                <div class="star-rating" id="starRatingDynamic">
                    <input type="radio" name="rating" value="5" id="star5d" required>
                    <label for="star5d"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="4" id="star4d">
                    <label for="star4d"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="3" id="star3d">
                    <label for="star3d"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="2" id="star2d">
                    <label for="star2d"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" name="rating" value="1" id="star1d">
                    <label for="star1d"><i class="fas fa-star"></i></label>
                </div>
                <span class="rating-text" id="ratingTextDynamic"></span>
            </div>

            {{-- COMMENT --}}
            <div class="form-group">
                <label for="commentDynamic" class="form-label">Nhận xét của bạn</label>
                <textarea name="comment" 
                          id="commentDynamic" 
                          rows="5" 
                          class="form-control" 
                          placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
            </div>

            {{-- BUTTONS --}}
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeReviewModalDynamic()">
                    Hủy
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Gửi đánh giá
                </button>
            </div>
        </form>
    </div>
</div>

@push('css')
<style>
.review-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.review-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
}

.review-modal-content {
    position: relative;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.review-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: transparent;
    border: none;
    font-size: 24px;
    color: #999;
    cursor: pointer;
    transition: color 0.3s;
}

.review-modal-close:hover {
    color: #333;
}

.review-modal-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.review-modal-title i {
    color: #ffc107;
}

.review-product-name {
    color: #666;
    margin-bottom: 25px;
    font-size: 14px;
}

.review-form .form-group {
    margin-bottom: 25px;
}

.review-form .form-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: #333;
}

.required {
    color: #dc3545;
}

/* STAR RATING */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 32px;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #ffc107;
}

.rating-text {
    display: block;
    margin-top: 10px;
    color: #666;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #0066cc;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
}

.btn-cancel {
    background: #f0f0f0;
    color: #333;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.3s;
}

.btn-cancel:hover {
    background: #e0e0e0;
}

.btn-submit {
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

.btn-submit:hover {
    background: #0052a3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

@media (max-width: 768px) {
    .review-modal-content {
        padding: 20px;
        width: 95%;
    }
    
    .star-rating label {
        font-size: 28px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentProductId = null;
let currentProductName = '';

function openReviewModalForProduct(productId, productName) {
    currentProductId = productId;
    currentProductName = productName;
    
    // Set form action using route helper
    const form = document.getElementById('reviewFormDynamic');
    form.action = `{{ url('/product') }}/${productId}/review`;
    
    // Set product name
    document.getElementById('reviewProductName').textContent = productName;
    
    // Reset form
    form.reset();
    document.getElementById('ratingTextDynamic').textContent = '';
    
    // Show modal
    document.getElementById('reviewModalDynamic').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeReviewModalDynamic() {
    document.getElementById('reviewModalDynamic').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Update rating text
document.querySelectorAll('#starRatingDynamic input').forEach(input => {
    input.addEventListener('change', function() {
        const ratingTexts = {
            1: '⭐ Rất tệ',
            2: '⭐⭐ Tệ',
            3: '⭐⭐⭐ Bình thường',
            4: '⭐⭐⭐⭐ Tốt',
            5: '⭐⭐⭐⭐⭐ Tuyệt vời'
        };
        document.getElementById('ratingTextDynamic').textContent = ratingTexts[this.value] || '';
    });
});

// Close modal when pressing Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReviewModalDynamic();
    }
});
</script>
@endpush
