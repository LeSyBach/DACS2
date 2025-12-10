<?php
// filepath: c:\xampp\htdocs\techstore\database\migrations\2025_12_09_000001_create_product_variants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tạo bảng product_variants
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color', 50)->nullable();
            $table->string('storage', 50)->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('sku', 100)->unique()->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['product_id', 'color', 'storage']);
        });

        // Cập nhật bảng order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('variant_id')->nullable()->after('product_id')
                ->constrained('product_variants')->onDelete('set null');
            $table->string('variant_info', 100)->nullable();
        });

        // Cập nhật bảng cart_items (nếu có)
        if (Schema::hasTable('cart_items')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->foreignId('variant_id')->nullable()->after('product_id')
                    ->constrained('product_variants')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cart_items')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropForeign(['variant_id']);
                $table->dropColumn('variant_id');
            });
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn(['variant_id', 'variant_info']);
        });
        
        Schema::dropIfExists('product_variants');
    }
};