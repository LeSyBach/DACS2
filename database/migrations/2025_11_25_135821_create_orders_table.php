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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('customer_email');
        $table->string('shipping_address');
        
        $table->decimal('total_price', 15, 0);
        $table->string('payment_method')->default('cod');
        $table->string('status')->default('pending'); 
        $table->text('note')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
