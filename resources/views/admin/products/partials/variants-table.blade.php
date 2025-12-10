{{-- filepath: c:\xampp\htdocs\techstore\resources\views\admin\products\partials\variants-table.blade.php --}}
@if($variants->count() > 0)
<div class="order-list-table">
    <table class="table order-table">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Màu sắc</th>
                <th>Bộ nhớ</th>
                <th>SKU</th>
                <th>Giá cũ</th>
                <th>Giá bán</th>
                <th>Tồn kho</th>
                <th>Mặc định</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($variants as $variant)
            <tr class="{{ $variant->is_default ? 'is-default' : '' }}">
                <td data-label="Ảnh">
                    @if($variant->image)
                    <img src="{{ asset('storage/' . $variant->image) }}" 
                         alt="Variant" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                    @else
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="Product" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; opacity: 0.5;">
                    @endif
                </td>
                <td data-label="Màu sắc">
                    @if($variant->color)
                    <span class="badge status-secondary">{{ $variant->color }}</span>
                    @else
                    <span style="color: #999;">—</span>
                    @endif
                </td>
                <td data-label="Bộ nhớ">
                    @if($variant->storage)
                    <span class="badge status-info">{{ $variant->storage }}</span>
                    @else
                    <span style="color: #999;">—</span>
                    @endif
                </td>
                <td data-label="SKU">
                    <code style="background: #f4f4f4; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        {{ $variant->sku }}
                    </code>
                </td>
                <td data-label="Giá cũ" class="price-col">
                    <span style="color: #999; text-decoration: {{ $variant->hasDiscount() ? 'line-through' : 'none' }};">
                        {{ number_format($variant->old_price, 0, ',', '.') }}₫
                    </span>
                </td>
                <td data-label="Giá bán" class="price-col">
                    @if($variant->hasDiscount())
                    <span style="color: #e74c3c; font-weight: 600;">
                        {{ number_format($variant->price, 0, ',', '.') }}₫
                    </span>
                    <span class="badge status-danger" style="font-size: 11px;">
                        -{{ $variant->discount_percent }}%
                    </span>
                    @else
                    <span style="color: #999;">—</span>
                    @endif
                </td>
                <td data-label="Tồn kho">
                    <span class="badge {{ $variant->stock > 0 ? 'status-success' : 'status-danger' }}">
                        {{ $variant->stock }}
                    </span>
                </td>
                <td data-label="Mặc định">
                    @if($variant->is_default)
                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 20px;" title="Biến thể mặc định"></i>
                    @else
                    <button type="button"
                            onclick="setDefaultVariant({{ $variant->id }})"
                            style="background: none; border: none; cursor: pointer; color: #999; font-size: 18px;"
                            title="Đặt làm mặc định">
                        <i class="far fa-circle"></i>
                    </button>
                    @endif
                </td>
                <td data-label="Hành động">
                    {{-- NÚT SỬA --}}
                    <button type="button" 
                            class="btn btn-sm btn-info"
                            style="margin-right: 5px;"
                            onclick="editVariant({{ $variant->id }}, '{{ $variant->color }}', '{{ $variant->storage }}', {{ $variant->old_price }}, {{ $variant->price ?? 'null' }}, {{ $variant->stock }}, {{ $variant->is_default ? 'true' : 'false' }}, '{{ $variant->image ? asset('storage/' . $variant->image) : '' }}')">
                        <i class="fas fa-edit"></i> Sửa
                    </button>
                    
                    {{-- NÚT XÓA --}}
                    <button type="button" 
                            class="btn btn-sm btn-danger"
                            onclick="deleteVariant({{ $variant->id }})">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div style="text-align: center; padding: 60px 20px;">
    <i class="fas fa-box-open" style="font-size: 64px; color: #ddd;"></i>
    <p style="color: #999; margin-top: 20px; font-size: 16px;">
        Chưa có biến thể nào cho sản phẩm này.
    </p>
    <p style="color: #666;">
        Hãy thêm biến thể đầu tiên bằng form ở trên!
    </p>
</div>
@endif