<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     * Mặc định Laravel sẽ tìm kiếm bảng 'categories'.
     */
    // protected $table = 'categories'; 

    /**
     * Các cột có thể được gán giá trị hàng loạt (Mass Assignable).
     * Cần thiết cho các hàm create() và update().
     */
    protected $fillable = [
        'name',
        'slug',
        'icon', // Class Font Awesome
    ];

    // --- CÁC MỐI QUAN HỆ (Relationships) ---
    
    /**
     * 1. Một Danh mục có nhiều Sản phẩm (Product).
     */
    public function products()
    {
        // Quan hệ 1-n: Một Category có nhiều Product
        return $this->hasMany(Product::class);
    }
}