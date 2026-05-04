<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Kiểm tra user đã mua sản phẩm này chưa
     */
    public static function userPurchasedProduct($userId, $productId)
    {
        return \App\Models\Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereHas('items', function($q) use ($productId) {
                $q->where('product_id', $productId);
            })
            ->exists();
    }

    /**
     * Kiểm tra user đã review sản phẩm này chưa
     */
    public static function userReviewed($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }
}
