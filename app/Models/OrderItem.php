<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

 

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

   
    public function order()
    {
        // Liên kết với Model App\Models\Order
        return $this->belongsTo(Order::class);
    }

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