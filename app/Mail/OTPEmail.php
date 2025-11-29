<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Biến public để giữ mã OTP và truyền vào view
    public $otp; // Mã OTP được truyền từ Controller

    /**
     * Khởi tạo một instance thông điệp mới.
     * @param string $otp Mã OTP
     */
    public function __construct($otp)
    {
        $this->otp = $otp; // Gán mã OTP vào biến public để sử dụng trong content()
    }

    /**
     * Lấy envelope (tiêu đề và người gửi) của thông điệp.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã xác nhận đặt lại mật khẩu của bạn', // Tiêu đề email
        );
    }

    /**
     * Lấy định nghĩa nội dung thông điệp.
     * Đây là nơi chỉ định template Blade và các biến đi kèm.
     */
    public function content(): Content
    {
        return new Content(
            // Chỉ định file Blade template: resources/views/emails/otp_reset.blade.php
            view: 'emails.otp_reset', 
            
            // Dữ liệu truyền vào template: Mã OTP (được truy cập trong view bằng biến $otpCode)
            with: [
                'otpCode' => $this->otp,
            ],
        );
    }

    /**
     * Lấy mảng attachments (đính kèm) cho thông điệp (nếu có).
     */
    public function attachments(): array
    {
        return [];
    }
}