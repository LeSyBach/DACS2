<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể được gán giá trị hàng loạt (Mass Assignable).
     * Bắt buộc phải thêm các cột của bảng cart_items vào đây.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
    ];

    // --- QUAN HỆ (Relationships) ---

    /**
     * Một mục trong giỏ hàng (CartItem) thuộc về một người dùng (User).
     */
    public function user()
    {
        // Liên kết với Model App\Models\User
        return $this->belongsTo(User::class);
    }
    
    /**
     * Một mục trong giỏ hàng (CartItem) thuộc về một sản phẩm (Product).
     * Bạn phải đảm bảo đã tạo Model Product.php
     */
    public function product()
    {
        // Liên kết với Model App\Models\Product
        return $this->belongsTo(Product::class);
    }




    // Quan hệ với variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Lấy giá (ưu tiên variant)
    public function getPriceAttribute()
    {
        return $this->variant ? $this->variant->price : $this->product->price;
    }

    // Lấy tồn kho
    public function getStockAttribute()
    {
        return $this->variant ? $this->variant->stock : $this->product->stock;
    }

    // Tổng tiền
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}