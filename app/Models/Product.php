<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- 1. THÊM DÒNG NÀY
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // <--- 2. THÊM DÒNG NÀY (QUAN TRỌNG NHẤT)

    protected $fillable = [
        'name', 'slug', 'price', 'old_price', 'image', 
        'description', 'content', 'quantity', 'is_featured', 'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    public function scopeAllProducts($query)
    {
        return $query->orderBy('id', 'desc');
    }
    
}