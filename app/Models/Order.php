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
        'customer_name',    
        'customer_phone',   
        'customer_email',   
        'shipping_address',
        'total_price',
        'status',
        'payment_method',
        'payment_status', // pending, paid, failed
    ];

    
    public function user()
    {
        // Liên kết với Model App\Models\User
        return $this->belongsTo(User::class);
    }

   
    public function items()
    {
        // Liên kết với Model App\Models\OrderItem
        return $this->hasMany(OrderItem::class);
    }

    
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }
}