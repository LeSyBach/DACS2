


<?php $__env->startSection('title', 'Quản lý biến thể - ' . $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="l-12">
        
        
        <div class="page-header-actions">
            <h1 class="admin-page-heading">
                <i class="fas fa-palette"></i> Biến thể: <?php echo e($product->name); ?>

            </h1>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn--secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        
        <div id="alert-container"></div>

        
        <div class="admin-table-card">
            <div class="card-header-custom">
                <i class="fas fa-info-circle"></i>
                <h3 class="card-title">Thông tin sản phẩm</h3>
            </div>
            <div class="card-body-custom">
                <div class="info-grid">
                    <div class="info-item">
                        <label><i class="fas fa-image"></i> Ảnh:</label>
                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                             alt="<?php echo e($product->name); ?>" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-tag"></i> Tên sản phẩm:</label>
                        <span><?php echo e($product->name); ?></span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-list"></i> Danh mục:</label>
                        <span><?php echo e($product->category->name ?? 'Chưa phân loại'); ?></span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-cube"></i> Số biến thể:</label>
                        <span class="badge status-success" id="variant-count"><?php echo e($product->variants->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="admin-table-card">
            <div class="card-header-custom">
                <i class="fas fa-plus-circle" id="form-icon"></i>
                <h3 class="card-title" id="form-title">Thêm biến thể mới</h3>
            </div>
            <div class="card-body-custom">
                <form id="variant-form" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="variant-id" value="">
                    <input type="hidden" id="form-action" value="store">
                    
                    
                    <div class="variant-form-row">
                        <div class="variant-form-col variant-form-col--half">
                            <div class="form-group">
                                <label for="color" class="form-label">Màu sắc</label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-palette"></i>
                                    </span>
                                    <input type="text" 
                                           name="color" 
                                           id="color" 
                                           class="form-input" 
                                           placeholder="VD: Đen, Trắng">
                                </div>
                                <small class="form-text text-danger" id="error-color"></small>
                            </div>
                        </div>

                        <div class="variant-form-col variant-form-col--half">
                            <div class="form-group">
                                <label for="storage" class="form-label">Bộ nhớ</label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-memory"></i>
                                    </span>
                                    <input type="text" 
                                           name="storage" 
                                           id="storage" 
                                           class="form-input" 
                                           placeholder="VD: 128GB, 256GB">
                                </div>
                                <small class="form-text text-danger" id="error-storage"></small>
                            </div>
                        </div>
                    </div>

                    
                    <div class="variant-form-row">
                        <div class="variant-form-col variant-form-col--third">
                            <div class="form-group">
                                <label for="old_price" class="form-label">
                                    Giá cũ (₫) <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <input type="number" 
                                           name="old_price" 
                                           id="old_price" 
                                           class="form-input" 
                                           min="0" 
                                           step="1000"
                                           required
                                           placeholder="30000000">
                                </div>
                                <small class="form-text text-danger" id="error-old_price"></small>
                            </div>
                        </div>

                        <div class="variant-form-col variant-form-col--third">
                            <div class="form-group">
                                <label for="price" class="form-label">
                                    Giá bán (₫)
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" 
                                           name="price" 
                                           id="price" 
                                           class="form-input" 
                                           min="0" 
                                           step="1000"
                                           placeholder="25990000">
                                </div>
                                <small class="form-text">Để trống nếu không giảm giá</small>
                                <small class="form-text text-danger" id="error-price"></small>
                            </div>
                        </div>

                        <div class="variant-form-col variant-form-col--third">
                            <div class="form-group">
                                <label for="stock" class="form-label">
                                    Tồn kho <span class="text-danger">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-wrapper__icon">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                    <input type="number" 
                                           name="stock" 
                                           id="stock" 
                                           class="form-input" 
                                           min="0" 
                                           required
                                           value="0">
                                </div>
                                <small class="form-text text-danger" id="error-stock"></small>
                            </div>
                        </div>
                    </div>

                    
                    <div class="variant-form-row">
                        <div class="variant-form-col variant-form-col--full">
                            
                            <div id="current-image-section" style="display: none; margin-bottom: 15px;">
                                <label class="form-label">Ảnh hiện tại:</label>
                                <div>
                                    <img id="current-variant-image" 
                                         src="" 
                                         alt="Current" 
                                         style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid #ddd;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image" class="form-label" id="image-label">Ảnh riêng</label>
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       class="form-input"
                                       accept="image/*"
                                       onchange="previewVariantImage(event)">
                                <small class="form-text" id="image-hint">JPEG, PNG, GIF (max 2MB). Nếu không chọn, sẽ dùng ảnh sản phẩm gốc.</small>
                                <small class="form-text text-danger" id="error-image"></small>
                            </div>
                            
                            
                            <div id="variant-image-preview" style="display: none; margin-top: 15px;">
                                <label class="form-label">Xem trước ảnh mới:</label>
                                <div style="position: relative; display: inline-block;">
                                    <img id="variant-preview-img" 
                                         src="" 
                                         alt="Preview" 
                                         style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #28a745;">
                                    <button type="button" 
                                            onclick="removeVariantPreview()" 
                                            style="position: absolute; top: -10px; right: -10px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-size: 18px; line-height: 1;">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_default" id="is_default" value="1" style="width: 18px; height: 18px;">
                            <span>Đặt làm biến thể mặc định</span>
                        </label>
                    </div>

                    
                    <div class="form-actions">
                        
                        <button type="submit" id="btn-add" class="btn btn--primary">
                            <i class="fas fa-plus"></i> Thêm biến thể
                        </button>

                        
                        <button type="submit" id="btn-update" class="btn btn--success" style="display: none;">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>

                        
                        <button type="button" id="btn-cancel" class="btn btn--secondary" style="display: none;" onclick="cancelEdit()">
                            <i class="fas fa-times"></i> Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="admin-table-card">
            <div class="card-header-custom">
                <i class="fas fa-list"></i>
                <h3 class="card-title">Danh sách biến thể (<span id="variant-count-table"><?php echo e($product->variants->count()); ?></span>)</h3>
            </div>
            <div class="card-body-custom p-0">
                <div id="variants-list">
                    <?php echo $__env->make('admin.products.partials.variants-table', ['variants' => $product->variants, 'product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>

    </div>
</div>


<style>
/* ===== LAYOUT FORM VARIANT - DÙNG FLEXBOX ===== */
.variant-form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Khoảng cách giữa các ô */
    margin-bottom: 20px;
}

/* Mỗi cột chiếm 50% (2 cột) */
.variant-form-col--half {
    flex: 1 1 calc(50% - 10px); /* 50% trừ đi gap/2 */
    min-width: 250px;
}

/* Mỗi cột chiếm 33.33% (3 cột) */
.variant-form-col--third {
    flex: 1 1 calc(33.333% - 14px); /* 33.33% trừ đi gap */
    min-width: 220px;
}

/* Chiếm toàn bộ chiều rộng */
.variant-form-col--full {
    flex: 1 1 100%;
}

.form-group {
    margin-bottom: 0;
    display: flex;
    flex-direction: column;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .variant-form-col--half,
    .variant-form-col--third {
        flex: 1 1 100%; /* 1 cột trên mobile */
        min-width: 100%;
    }
    
    .variant-form-row {
        gap: 15px;
    }
}

/* ===== CÁC STYLE KHÁC ===== */
tr.is-default {
    background-color: #e8f5e9 !important;
}

input[type="checkbox"] {
    cursor: pointer;
}

.text-danger {
    color: #dc3545;
    font-size: 13px;
    display: block;
    margin-top: 5px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.form-input {
    border: 1px solid #ddd;
    transition: border-color 0.3s;
}

.form-input:focus {
    border-color: #4CAF50;
    outline: none;
}

.form-input.error {
    border-color: #dc3545 !important;
}
</style>


<script>
const productId = <?php echo e($product->id); ?>;
const baseUrl = "<?php echo e(url('/')); ?>";
const csrfToken = "<?php echo e(csrf_token()); ?>";

// Xem trước ảnh
function previewVariantImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('variant-image-preview');
    const previewImg = document.getElementById('variant-preview-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Xóa preview ảnh
function removeVariantPreview() {
    document.getElementById('image').value = '';
    document.getElementById('variant-image-preview').style.display = 'none';
    document.getElementById('variant-preview-img').src = '';
}

// Xóa tất cả lỗi
function clearErrors() {
    document.querySelectorAll('.text-danger').forEach(el => {
        if (el.id.startsWith('error-')) {
            el.textContent = '';
        }
    });
    document.querySelectorAll('.form-input').forEach(el => {
        el.classList.remove('error');
    });
}

// ✅ HIỂN THỊ THÔNG BÁO - KHÔNG SCROLL
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    alertContainer.innerHTML = `
        <div class="alert alert-${type}">
            <i class="fas ${icon}"></i> ${message}
        </div>
    `;
    
    // Tự động ẩn sau 5s
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

// ✅ SUBMIT FORM BẰNG AJAX
document.getElementById('variant-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    clearErrors();
    
    const formData = new FormData(this);
    const action = document.getElementById('form-action').value;
    const variantId = document.getElementById('variant-id').value;
    
    let url = `${baseUrl}/admin/products/${productId}/variants`;
    
    if (action === 'update') {
        url = `${baseUrl}/admin/products/${productId}/variants/${variantId}`;
        formData.append('_method', 'PUT');
    }
    
    // Disable nút submit
    const btnAdd = document.getElementById('btn-add');
    const btnUpdate = document.getElementById('btn-update');
    const currentBtn = action === 'store' ? btnAdd : btnUpdate;
    const originalText = currentBtn.innerHTML;
    currentBtn.disabled = true;
    currentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // ✅ Thành công
            showAlert(data.message, 'success');
            
            // ✅ Reset form
            cancelEdit();
            
            // ✅ AUTO RELOAD DANH SÁCH
            await loadVariantsList();
            
            console.log('✅ Thành công!');
            
        } else {
            // ❌ Lỗi validation
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorEl = document.getElementById(`error-${key}`);
                    const inputEl = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
                    
                    if (errorEl) {
                        errorEl.textContent = data.errors[key][0];
                    }
                    if (inputEl) {
                        inputEl.classList.add('error');
                    }
                });
                
                showAlert('Vui lòng kiểm tra lại thông tin!', 'danger');
            } else {
                showAlert(data.message || 'Có lỗi xảy ra!', 'danger');
            }
        }
        
    } catch (error) {
        console.error('❌ Error:', error);
        showAlert('Có lỗi xảy ra! Vui lòng thử lại.', 'danger');
    } finally {
        currentBtn.disabled = false;
        currentBtn.innerHTML = originalText;
    }
});

// ✅ LOAD LẠI DANH SÁCH BIẾN THỂ
async function loadVariantsList() {
    console.log('🔄 Đang load danh sách...');
    
    try {
        const url = `${baseUrl}/admin/products/${productId}/variants/list`;
        console.log('📡 URL:', url);
        
        const response = await fetch(url, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        console.log('📥 Response:', response.status);
        
        const data = await response.json();
        
        if (response.ok) {
            document.getElementById('variants-list').innerHTML = data.html;
            document.getElementById('variant-count').textContent = data.count;
            document.getElementById('variant-count-table').textContent = data.count;
            
            console.log('✅ Đã reload:', data.count, 'biến thể');
        } else {
            console.error('❌ Lỗi:', data);
        }
    } catch (error) {
        console.error('❌ Error:', error);
    }
}

// CHỨC NĂNG SỬA
function editVariant(id, color, storage, oldPrice, price, stock, isDefault, image) {
    console.log('🔧 Sửa biến thể:', id);
    
    clearErrors();
    
    document.getElementById('form-title').textContent = 'Sửa biến thể';
    document.getElementById('form-icon').className = 'fas fa-edit';
    
    document.getElementById('variant-id').value = id;
    document.getElementById('form-action').value = 'update';
    
    document.getElementById('color').value = color || '';
    document.getElementById('storage').value = storage || '';
    document.getElementById('old_price').value = oldPrice;
    document.getElementById('price').value = price || '';
    document.getElementById('stock').value = stock;
    document.getElementById('is_default').checked = isDefault;
    
    if (image) {
        document.getElementById('current-image-section').style.display = 'block';
        document.getElementById('current-variant-image').src = image;
        document.getElementById('image-label').textContent = 'Thay đổi ảnh:';
        document.getElementById('image-hint').textContent = 'Để trống nếu không muốn thay đổi';
    } else {
        document.getElementById('current-image-section').style.display = 'none';
    }
    
    document.getElementById('btn-add').style.display = 'none';
    document.getElementById('btn-update').style.display = 'inline-block';
    document.getElementById('btn-cancel').style.display = 'inline-block';
    
    document.getElementById('variant-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// HỦY SỬA
function cancelEdit() {
    clearErrors();
    
    document.getElementById('form-title').textContent = 'Thêm biến thể mới';
    document.getElementById('form-icon').className = 'fas fa-plus-circle';
    
    document.getElementById('variant-id').value = '';
    document.getElementById('form-action').value = 'store';
    
    document.getElementById('variant-form').reset();
    
    document.getElementById('current-image-section').style.display = 'none';
    document.getElementById('image-label').textContent = 'Ảnh riêng';
    document.getElementById('image-hint').textContent = 'JPEG, PNG, GIF (max 2MB). Nếu không chọn, sẽ dùng ảnh sản phẩm gốc.';
    
    removeVariantPreview();
    
    document.getElementById('btn-add').style.display = 'inline-block';
    document.getElementById('btn-update').style.display = 'none';
    document.getElementById('btn-cancel').style.display = 'none';
}

// ✅ XÓA BIẾN THỂ
async function deleteVariant(variantId) {
    if (!confirm('Bạn có chắc muốn xóa?')) return;
    
    try {
        const response = await fetch(`${baseUrl}/admin/products/${productId}/variants/${variantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            showAlert(data.message, 'success');
            await loadVariantsList();
        } else {
            showAlert(data.message || 'Có lỗi!', 'danger');
        }
    } catch (error) {
        console.error('❌ Error:', error);
        showAlert('Có lỗi xảy ra!', 'danger');
    }
}

// ✅ ĐẶT MẶC ĐỊNH
async function setDefaultVariant(variantId) {
    if (!confirm('Đặt làm mặc định?')) return;
    
    try {
        const response = await fetch(`${baseUrl}/admin/products/${productId}/variants/${variantId}/set-default`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            showAlert(data.message, 'success');
            await loadVariantsList();
        } else {
            showAlert(data.message || 'Có lỗi!', 'danger');
        }
    } catch (error) {
        console.error('❌ Error:', error);
        showAlert('Có lỗi xảy ra!', 'danger');
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\techstore\resources\views/admin/products/variants.blade.php ENDPATH**/ ?>