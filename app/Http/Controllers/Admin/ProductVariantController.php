<?php
// filepath: app\Http\Controllers\Admin\ProductVariantController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Hiển thị trang quản lý variants
     */
    public function index(Product $product)
    {
        $product->load('variants');
        return view('admin.products.variants', compact('product'));
    }

    /**
     * ✅ LOAD DANH SÁCH (AJAX) - QUAN TRỌNG
     */
    public function list(Product $product)
    {
        $product->load('variants');
        $variants = $product->variants;
        
        $html = view('admin.products.partials.variants-table', compact('variants', 'product'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $variants->count()
        ]);
    }

    /**
     * Thêm variant mới
     */
    public function store(Request $request, Product $product)
    {
        // ✅ SỬA VALIDATION - Giá bán BẮT BUỘC
        $request->validate([
            'old_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0|lt:old_price', // ✅ THÊM required
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string|max:50',
            'storage' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048'
        ], [
            'old_price.required' => 'Vui lòng nhập giá cũ',
            'price.required' => 'Vui lòng nhập giá bán', // ✅ THÊM message
            'price.lt' => 'Giá bán phải nhỏ hơn giá cũ',
            'stock.required' => 'Vui lòng nhập tồn kho',
            'image.image' => 'File phải là ảnh',
            'image.max' => 'Ảnh không được vượt quá 2MB'
        ]);

        $variant = new ProductVariant($request->only(['color', 'storage', 'old_price', 'price', 'stock']));
        $variant->product_id = $product->id;
        $variant->is_default = $request->has('is_default');

        if ($request->hasFile('image')) {
            $variant->image = $request->file('image')->store('products/variants', 'public');
        }

        $variant->save();
        
        // Tự động tạo SKU
        $variant->sku = $this->generateSku($product, $variant);
        $variant->save();

        // Nếu đặt làm mặc định, bỏ default của các variant khác
        if ($variant->is_default) {
            ProductVariant::where('product_id', $product->id)
                ->where('id', '!=', $variant->id)
                ->update(['is_default' => false]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm biến thể thành công!'
        ]);
    }

    /**
     * Cập nhật variant
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        // ✅ SỬA VALIDATION - Giá bán BẮT BUỘC
        $request->validate([
            'old_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0|lt:old_price', // ✅ THÊM required
            'stock' => 'required|integer|min:0',
            'color' => 'nullable|string|max:50',
            'storage' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048'
        ], [
            'old_price.required' => 'Vui lòng nhập giá cũ',
            'price.required' => 'Vui lòng nhập giá bán', // ✅ THÊM message
            'price.lt' => 'Giá bán phải nhỏ hơn giá cũ',
            'stock.required' => 'Vui lòng nhập tồn kho',
            'image.image' => 'File phải là ảnh',
            'image.max' => 'Ảnh không được vượt quá 2MB'
        ]);

        $variant->fill($request->only(['color', 'storage', 'old_price', 'price', 'stock']));
        $variant->is_default = $request->has('is_default');

        // Xử lý ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->image = $request->file('image')->store('products/variants', 'public');
        }

        $variant->save();

        // Nếu đặt làm mặc định
        if ($variant->is_default) {
            ProductVariant::where('product_id', $product->id)
                ->where('id', '!=', $variant->id)
                ->update(['is_default' => false]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật biến thể thành công!'
        ]);
    }

    /**
     * Xóa variant
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        // Xóa ảnh
        if ($variant->image) {
            Storage::disk('public')->delete($variant->image);
        }
        
        $variant->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa biến thể thành công!'
        ]);
    }

    /**
     * Đặt làm mặc định
     */
    public function setDefault(Product $product, ProductVariant $variant)
    {
        // Bỏ default tất cả
        ProductVariant::where('product_id', $product->id)
            ->update(['is_default' => false]);
        
        // Set variant này làm default
        $variant->is_default = true;
        $variant->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã chuyển sang biến thể mặc định mới!'
        ]);
    }

    /**
     * ✅ HÀM TẠO SKU TỰ ĐỘNG
     */
    private function generateSku(Product $product, ProductVariant $variant)
    {
        $productCode = strtoupper(substr($product->slug ?? $product->name, 0, 6));
        $colorCode = $variant->color ? strtoupper(substr($variant->color, 0, 3)) : 'DEF';
        $storageCode = $variant->storage ? str_replace(['GB', 'TB', ' '], '', strtoupper($variant->storage)) : '';
        
        return $productCode . '-' . $colorCode . ($storageCode ? '-' . $storageCode : '');
    }
}