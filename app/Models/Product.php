<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- 1. THÊM DÒNG NÀY
use Illuminate\Database\Eloquent\Model;
use App\Helpers\StringHelper;

class Product extends Model
{
    use HasFactory; // <--- 2. THÊM DÒNG NÀY (QUAN TRỌNG NHẤT)

    protected $fillable = [
        'name', 'slug', 'price', 'old_price', 'image', 
        'description', 'content', 'quantity', 'is_featured', 'category_id','search_text',
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $searchText = $product->name . ' ' . $product->description;
            $product->search_text = StringHelper::removeVietnameseTones($searchText);
        });
    }

    /**
     * Scope tìm kiếm thông minh
     */
    public function scopeSmartSearch($query, $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }

        // Loại bỏ dấu từ keyword
        $keywordNoTone = StringHelper::removeVietnameseTones($keyword);
        $keywords = StringHelper::extractKeywords($keyword);

        return $query->where(function($q) use ($keyword, $keywordNoTone, $keywords) {
            // 1. Tìm chính xác (có dấu)
            $q->where('name', 'LIKE', "%{$keyword}%")
              ->orWhere('description', 'LIKE', "%{$keyword}%")
              
              // 2. Tìm không dấu
              ->orWhere('search_text', 'LIKE', "%{$keywordNoTone}%")
              
              // 3. Tìm từng từ khóa riêng lẻ
              ->orWhere(function($subQ) use ($keywords) {
                  foreach ($keywords as $word) {
                      $subQ->orWhere('search_text', 'LIKE', "%{$word}%");
                  }
              });
        });
    }
    
}