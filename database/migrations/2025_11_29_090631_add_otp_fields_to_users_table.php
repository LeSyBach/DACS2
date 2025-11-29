<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm cột 'otp_code' (chuỗi, 6 ký tự, cho phép NULL)
            $table->string('otp_code', 6)->nullable()->after('password'); 
            
            // Thêm cột 'otp_expires_at' (kiểu timestamp, cho phép NULL)
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Lệnh xóa cột khi cần rollback
            $table->dropColumn(['otp_code', 'otp_expires_at']);
        });
    }
};