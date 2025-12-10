<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Khai báo các cột có thể được gán giá trị hàng loạt (mass assignable)
     */
    // protected $fillable = [
    //     'order_id',
    //     'product_id',
    //     'product_name',
    //     'quantity',
    //     'price',
    // ];

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'variant_id',
        'variant_info',
        'quantity',
        'price'
    ];

    // --- CÁC MỐI QUAN HỆ (Relationships) ---

    /**
     * 1. Một chi tiết đơn hàng (OrderItem) thuộc về một đơn hàng chính (Order)
     */
    public function order()
    {
        // Liên kết với Model App\Models\Order
        return $this->belongsTo(Order::class);
    }

    /**
     * 2. Một chi tiết đơn hàng (OrderItem) thuộc về một sản phẩm (Product)
     */
    public function product()
    {
        // Liên kết với Model App\Models\Product
        return $this->belongsTo(Product::class);
    }

    /**
     * 3. (Tùy chọn) Hàm tính tổng tiền cho từng dòng sản phẩm
     */
    // public function getTotalAttribute()
    // {
    //     return $this->quantity * $this->price;
    // }


    // Quan hệ với variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Tổng tiền
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }


}