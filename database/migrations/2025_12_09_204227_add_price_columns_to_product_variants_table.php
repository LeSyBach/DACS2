<?php
// filepath: c:\xampp\htdocs\techstore\database\migrations\2025_12_09_210000_add_price_columns_to_product_variants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Đổi tên price → old_price (giá gốc/cũ - giống Product)
            $table->renameColumn('price', 'old_price');
            
            // Thêm cột price (giá bán - giống Product)
            $table->decimal('price', 15, 0)->nullable()->after('old_price');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->renameColumn('old_price', 'price');
        });
    }
};