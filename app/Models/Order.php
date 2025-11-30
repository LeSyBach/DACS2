<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Khai báo các cột có thể được gán giá trị hàng loạt (mass assignable)
     */
    protected $fillable = [
        'user_id',
        'receiver_name',
        'receiver_phone',
        'shipping_address',
        'total_amount',
        'status', // Trạng thái đơn hàng (1: Pending, 4: Completed, ...)
        'payment_method', // COD, ZaloPay, ...
        'payment_status', // pending, paid, failed
    ];

    // --- CÁC MỐI QUAN HỆ (Relationships) ---

    /**
     * 1. Một đơn hàng thuộc về một người dùng (User)
     * user_id trong bảng orders liên kết với id trong bảng users.
     */
    public function user()
    {
        // Liên kết với Model App\Models\User
        return $this->belongsTo(User::class);
    }

    /**
     * 2. Một đơn hàng có nhiều chi tiết đơn hàng (OrderItem)
     * Đây là quan hệ 'hasMany'.
     */
    public function items()
    {
        // Liên kết với Model App\Models\OrderItem
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 3. (Tùy chọn) Tính toán tổng số lượng sản phẩm trong đơn hàng
     */
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }
}