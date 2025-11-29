<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Thuộc tính có thể được gán giá trị hàng loạt (Mass Assignable).
     * Bắt buộc phải thêm các cột mới vào đây.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',        // <--- Cột mới
        'address',      // <--- Cột mới
        'role',         // <--- Cột mới (customer/admin)
        'otp_code',     // Cần fillable nếu bạn muốn lưu OTP qua Model
        'otp_expires_at', // Cần fillable
    ];

    /**
     * Các thuộc tính nên được ẩn khi chuyển thành JSON (Bảo mật).
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',     // Ẩn mã OTP
        'otp_expires_at',// Ẩn thời gian hết hạn
    ];

    /**
     * Ép kiểu dữ liệu (Casting).
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime', // Ép kiểu cho cột OTP hết hạn
        'password' => 'hashed',
    ];

    // --- CÁC HÀM LOGIC & QUAN HỆ (Relationships) ---
    
    // 1. Một User có nhiều đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // 2. Một User có nhiều đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 3. Helper Function: Kiểm tra quyền Admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}