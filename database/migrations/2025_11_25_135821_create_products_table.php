<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->decimal('price', 15, 0);
        $table->decimal('old_price', 15, 0)->nullable();
        $table->string('image');
        $table->text('description')->nullable();
        $table->longText('content')->nullable();
        $table->integer('quantity')->default(0);
        $table->boolean('is_featured')->default(false);
        
        // Liên kết với bảng Categories
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
