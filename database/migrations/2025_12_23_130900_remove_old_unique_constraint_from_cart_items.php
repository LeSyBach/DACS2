<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Bước 1: Xóa foreign key constraint trước
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Bước 2: Xóa unique constraint cũ
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique('cart_items_user_id_product_id_unique');
        });
        
        // Bước 3: Tạo lại foreign key
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Xóa foreign key
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Khôi phục lại constraint cũ
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id'], 'cart_items_user_id_product_id_unique');
        });
        
        // Tạo lại foreign key
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
