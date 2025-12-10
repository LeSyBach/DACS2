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

    // Quan hệ với variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Lấy biến thể mặc định
    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    // Kiểm tra có variants không
    public function hasVariants()
    {
        return $this->variants()->exists();
    }

    // Lấy giá hiển thị
    public function getDisplayPriceAttribute()
    {
        if ($this->hasVariants()) {
            $default = $this->defaultVariant;
            return $default ? $default->price : $this->variants()->min('price');
        }
        return $this->price;
    }

    // Lấy giá thấp nhất
    public function getMinPriceAttribute()
    {
        if ($this->hasVariants()) {
            return $this->variants()->min('price');
        }
        return $this->price;
    }

    // Lấy giá cao nhất
    public function getMaxPriceAttribute()
    {
        if ($this->hasVariants()) {
            return $this->variants()->max('price');
        }
        return $this->price;
    }

    // Lấy tồn kho tổng
    public function getTotalStockAttribute()
    {
        if ($this->hasVariants()) {
            return $this->variants()->sum('stock');
        }
        return $this->stock;
    }

    // Hiển thị giá dạng range
    public function getPriceRangeAttribute()
    {
        if (!$this->hasVariants()) {
            return number_format($this->price, 0, ',', '.') . '₫';
        }

        $min = $this->min_price;
        $max = $this->max_price;

        if ($min == $max) {
            return number_format($min, 0, ',', '.') . '₫';
        }

        return number_format($min, 0, ',', '.') . '₫ - ' . number_format($max, 0, ',', '.') . '₫';
    }
    
}