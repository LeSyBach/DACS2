<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn liên hệ mới</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #009688, #00796b); color: #fff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .info-row { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .info-row:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #009688; display: inline-block; min-width: 120px; }
        .value { color: #555; }
        .message-box { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #009688; margin-top: 20px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #777; }
        .btn { display: inline-block; padding: 12px 30px; background: #009688; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Tin Nhắn Liên Hệ Mới</h1>
        </div>
        
        <div class="content">
            <p>Xin chào Admin,</p>
            <p>Bạn vừa nhận được một tin nhắn liên hệ mới từ khách hàng:</p>
            
            <div class="info-row">
                <span class="label">👤 Họ và tên:</span>
                <span class="value"><?php echo e($contact->name); ?></span>
            </div>
            
            <div class="info-row">
                <span class="label">📧 Email:</span>
                <span class="value"><?php echo e($contact->email); ?></span>
            </div>
            
            <?php if($contact->phone): ?>
            <div class="info-row">
                <span class="label">📱 Điện thoại:</span>
                <span class="value"><?php echo e($contact->phone); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="info-row">
                <span class="label">📝 Chủ đề:</span>
                <span class="value"><?php echo e($contact->subject); ?></span>
            </div>
            
            <div class="info-row">
                <span class="label">🕐 Thời gian:</span>
                <span class="value"><?php echo e($contact->created_at->format('d/m/Y H:i')); ?></span>
            </div>
            
            <div class="message-box">
                <strong>💬 Nội dung tin nhắn:</strong>
                <p style="margin-top: 10px; white-space: pre-wrap;"><?php echo e($contact->message); ?></p>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo e(config('app.url')); ?>/admin" class="btn">Xem Chi Tiết</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Email tự động từ hệ thống TechStore</p>
            <p>© <?php echo e(date('Y')); ?> TechStore. All rights reserved.</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\techstore\resources\views/emails/contact-admin.blade.php ENDPATH**/ ?>