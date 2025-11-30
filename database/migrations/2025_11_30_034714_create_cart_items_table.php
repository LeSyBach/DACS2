<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy các migrations (Tạo bảng).
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            
            // Liên kết với bảng users (Khóa ngoại)
            // on_delete('cascade') đảm bảo xóa các mục giỏ hàng khi user bị xóa
            $table->foreignId('user_id')
                  ->constrained('users') // Tên bảng users
                  ->onDelete('cascade'); 
            
            // Liên kết với bảng products (Khóa ngoại)
            // Giả định bạn có bảng 'products'
            $table->foreignId('product_id')
                  ->constrained('products') // Tên bảng products
                  ->onDelete('cascade');
                  
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->timestamps();
            
            // YÊU CẦU DUY NHẤT: Đảm bảo một người dùng chỉ có một mục cho một sản phẩm cụ thể
            $table->unique(['user_id', 'product_id']); 
        });
    }

    /**
     * Đảo ngược các migrations (Xóa bảng).
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};