<?php
// filepath: c:\xampp\htdocs\techstore\app\Models\ProductVariant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color',
        'storage',
        'old_price',  // Giá gốc (giá cũ) - tương tự Product
        'price',      // Giá bán (giá hiện tại) - tương tự Product
        'stock',
        'sku',
        'image',
        'is_default'
    ];

    protected $casts = [
        'old_price' => 'decimal:0',
        'price' => 'decimal:0',
        'stock' => 'integer',
        'is_default' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function generateSku()
    {
        $productId = $this->product_id;
        $colorCode = $this->color ? strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $this->color), 0, 3)) : 'DEF';
        $storageCode = $this->storage ? preg_replace('/[^0-9]/', '', $this->storage) : '000';
        return "SP{$productId}-{$colorCode}-{$storageCode}";
    }

    public function getDisplayNameAttribute()
    {
        $parts = [];
        if ($this->color) $parts[] = $this->color;
        if ($this->storage) $parts[] = $this->storage;
        return count($parts) > 0 ? implode(' - ', $parts) : 'Mặc định';
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Lấy giá hiển thị (ưu tiên giá bán nếu có)
     */
    public function getDisplayPriceAttribute()
    {
        return $this->price ?? $this->old_price;
    }

    /**
     * Kiểm tra có giảm giá không
     */
    public function hasDiscount()
    {
        return $this->price && $this->old_price && $this->price < $this->old_price;
    }

    /**
     * Tính % giảm giá
     */
    public function getDiscountPercentAttribute()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
}