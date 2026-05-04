<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã liên hệ</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: #f4f4f4; 
            margin: 0; 
            padding: 20px; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: #fff; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        }
        .header { 
            background: linear-gradient(135deg, #009688, #00796b); 
            color: #fff; 
            padding: 30px; 
            text-align: center; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 24px; 
        }
        .content { 
            padding: 30px; 
        }
        .highlight-box { 
            background: #e0f2f1; 
            padding: 20px; 
            border-radius: 8px; 
            border-left: 4px solid #009688; 
            margin: 20px 0; 
        }
        .info-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 15px; 
            margin: 20px 0; 
        }
        .info-item { 
            text-align: center; 
            padding: 15px; 
            background: #f8f9fa; 
            border-radius: 8px; 
        }
        .info-item strong { 
            display: block; 
            color: #009688; 
            margin-bottom: 5px; 
        }
        .info-item span { 
            color: #555; 
            font-size: 14px; 
        }
        .footer { 
            background: #f8f9fa; 
            padding: 20px; 
            text-align: center; 
            font-size: 12px; 
            color: #777; 
        }
        .btn { 
            display: inline-block; 
            padding: 12px 30px; 
            background: #009688; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 5px; 
            margin-top: 15px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Cảm ơn bạn đã liên hệ!</h1>
        </div>
        
        <div class="content">
            <p>Xin chào <strong><?php echo e($contact->name); ?></strong>,</p>
            
            <p>Chúng tôi đã nhận được tin nhắn của bạn và sẽ phản hồi trong thời gian sớm nhất (thường trong vòng 24 giờ làm việc).</p>
            
            <div class="highlight-box">
                <strong>📋 Thông tin bạn đã gửi:</strong>
                <p style="margin: 10px 0 5px 0;"><strong>Chủ đề:</strong> <?php echo e($contact->subject); ?></p>
                <p style="margin: 5px 0;"><strong>Nội dung:</strong></p>
                <p style="margin: 5px 0; color: #555; white-space: pre-wrap;"><?php echo e(Str::limit($contact->message, 200)); ?></p>
            </div>
            
            <p><strong>Trong thời gian chờ đợi, bạn có thể liên hệ qua:</strong></p>
            
            <div class="info-grid">
                <div class="info-item">
                    <div style="font-size: 32px;">📞</div>
                    <strong>Hotline</strong>
                    <span>1900-1234</span>
                </div>
                <div class="info-item">
                    <div style="font-size: 32px;">💬</div>
                    <strong>Live Chat</strong>
                    <span>Chat trực tuyến</span>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p>Khám phá thêm sản phẩm của chúng tôi</p>
                <a href="<?php echo e(route('product')); ?>" class="btn">Xem Sản Phẩm</a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>TechStore</strong></p>
            <p>📍 123 Đường Nguyễn Huệ, Quận 1, TP. HCM</p>
            <p>📧 support@techstore.vn | ☎️ 1900-1234</p>
            <p style="margin-top: 15px;">© <?php echo e(date('Y')); ?> TechStore. All rights reserved.</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\techstore\resources\views/emails/contact-customer.blade.php ENDPATH**/ ?>