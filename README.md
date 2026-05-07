# 🛒 Techstore — Hệ thống Quản lý Cửa hàng Trực tuyến

<div align="center">

**Ứng dụng thương mại điện tử hiện đại xây dựng bằng Laravel & Vue.js**

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![Node.js](https://img.shields.io/badge/Node.js-18+-339933?style=flat-square&logo=node.js)

[🌐 Xem Demo](#) • [📖 Tài liệu](#) • [🐛 Báo lỗi](#) • [💬 Thảo luận](#)

</div>

---

## 📋 Mục lục

- [Giới thiệu](#-giới-thiệu)
- [Tính năng](#-tính-năng)
- [Cấu trúc dự án](#-cấu-trúc-dự-án)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Hướng dẫn cài đặt](#-hướng-dẫn-cài-đặt)
- [Cấu hình môi trường](#-cấu-hình-môi-trường)
- [Sử dụng](#-sử-dụng)
- [API & Routes](#-api--routes)
- [Troubleshooting](#-troubleshooting)
- [Triển khai Production](#-triển-khai-production)
- [Đóng góp](#-đóng-góp)

---

## 🎯 Giới thiệu

**Techstore** là một nền tảng thương mại điện tử hoàn chỉnh được thiết kế cho phép cửa hàng trực tuyến quản lý sản phẩm, biến thể, giỏ hàng, đơn hàng và thanh toán. Dự án được xây dựng bằng:

- **Backend:** Laravel 11 (PHP 8.1+)
- **Frontend:** Blade Templates + Alpine.js / Vue.js
- **Database:** MySQL 8.0+
- **Build Tool:** Vite.js

### ✨ Điểm nổi bật

- 🎯 **Hệ thống giỏ hàng thông minh** hỗ trợ session (guest) và database (user đăng nhập)
- 🔄 **AJAX real-time update** - cập nhật giỏ không cần reload
- 🎨 **Quản lý biến thể** - hỗ trợ size, color, stock variants
- 💳 **Thanh toán nhanh chóng** - tích hợp gateway thanh toán
- 📱 **Responsive Design** - hoạt động tốt trên mobile

---

## ⭐ Tính năng chính

### 🛍️ Chức năng khách hàng

| Tính năng         | Mô tả                                   |
| ----------------- | --------------------------------------- |
| 📦 Duyệt sản phẩm | Danh sách, tìm kiếm, lọc theo danh mục  |
| 🎨 Chọn biến thể  | Size, color, stock management           |
| 🛒 Quản lý giỏ    | Thêm, xóa, cập nhật số lượng (AJAX)     |
| 💳 Thanh toán     | Checkout đơn giản, hỗ trợ nhiều gateway |
| 📋 Lịch sử đơn    | Xem trạng thái, chi tiết đơn hàng       |
| 👤 Tài khoản      | Đăng ký, đăng nhập, quản lý hồ sơ       |

### 🔧 Chức năng Admin

| Tính năng             | Mô tả                               |
| --------------------- | ----------------------------------- |
| 📦 Quản lý sản phẩm   | CRUD sản phẩm, biến thể, giá cả     |
| 📊 Quản lý đơn hàng   | Xem tất cả đơn, cập nhật trạng thái |
| 👥 Quản lý người dùng | Thêm/xóa user, gán roles            |
| 📈 Thống kê & báo cáo | Doanh thu, tồn kho, trending        |

---

## 📁 Cấu trúc dự án

```
techstore/
├── app/                          # Ứng dụng chính
│   ├── Http/
│   │   ├── Controllers/          # Logic xử lý request
│   │   │   ├── CartController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   └── CheckoutController.php
│   │   └── Middleware/           # Authentication, CORS, etc
│   ├── Models/                   # Eloquent Models
│   │   ├── Product.php
│   │   ├── CartItem.php
│   │   ├── Order.php
│   │   ├── OrderDetail.php
│   │   └── User.php
│   ├── Services/                 # Business Logic
│   │   ├── CartService.php
│   │   ├── OrderService.php
│   │   └── PaymentService.php
│   └── Helpers/                  # Utility Functions
│
├── database/
│   ├── migrations/               # Database Structure
│   ├── seeders/                  # Sample Data
│   └── factories/                # Test Data Generators
│
├── resources/                    # Frontend Assets
│   ├── views/
│   │   ├── layouts/
│   │   ├── products/
│   │   ├── cart/
│   │   ├── checkout/
│   │   ├── orders/
│   │   ├── admin/
│   │   └── partials/
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php                   # Web Routes
│   └── api.php                   # API Routes (optional)
│
├── config/                       # Configuration
├── storage/                      # Logs & Cache
├── tests/                        # Unit & Feature Tests
├── .env.example                  # Environment Template
├── composer.json                 # PHP Dependencies
├── package.json                  # Node Dependencies
└── vite.config.js                # Build Configuration
```

---

## ✅ Yêu cầu hệ thống

| Công cụ      | Phiên bản | Ghi chú                             |
| ------------ | --------- | ----------------------------------- |
| **PHP**      | 8.1+      | Với extensions: PDO, cURL, JSON, GD |
| **Composer** | 2.0+      | PHP Package Manager                 |
| **MySQL**    | 8.0+      | DBMS (hoặc MariaDB 10.3+)           |
| **Node.js**  | 18+       | JavaScript Runtime                  |
| **npm**      | 9.0+      | Package Manager (hoặc yarn/pnpm)    |

### Kiểm tra cài đặt

```bash
php --version
composer --version
mysql --version
node --version
npm --version
```

---

## 🚀 Hướng dẫn cài đặt

### Bước 1: Clone repository

```bash
git clone https://github.com/yourusername/techstore.git
cd techstore
```

### Bước 2: Cài đặt dependencies

```bash
composer install
npm install
```

### Bước 3: Tạo file `.env`

```bash
cp .env.example .env
php artisan key:generate
```

### Bước 4: Cấu hình database

**Chỉnh sửa `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_db
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Bước 5: Chạy migrations

```bash
php artisan migrate --seed
```

### Bước 6: Build frontend assets

```bash
npm run build
# hoặc
npm run dev
```

### Bước 7: Khởi chạy server

```bash
php artisan serve
```

Truy cập: **http://127.0.0.1:8000**

---

## ⚙️ Cấu hình môi trường

### File `.env` chi tiết

```env
# ========== APP CONFIG ==========
APP_NAME="Techstore"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# ========== DATABASE ==========
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_db
DB_USERNAME=root
DB_PASSWORD=

# ========== CACHE & SESSION ==========
CACHE_DRIVER=file
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync

# ========== MAIL ==========
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@techstore.local
```

### Tài khoản mặc định

```
Admin:
Email:    admin@techstore.local
Password: password

User Test:
Email:    user@techstore.local
Password: password
```

> ⚠️ Thay đổi mật khẩu trước khi triển khai production!

---

## 💡 Sử dụng

### 👤 Quy trình mua sắm

1. Duyệt sản phẩm → Chọn biến thể
2. Thêm vào giỏ hàng (AJAX)
3. Xem giỏ → Thanh toán
4. Nhập thông tin → Hoàn tất đơn

### 🔐 Truy cập Admin

```
URL:      http://localhost:8000/admin
Email:    admin@techstore.local
Password: password
```

---

## 🗺️ API Routes

```bash
# Xem danh sách routes
php artisan route:list
```

### Route chính

```
GET    /products              # Danh sách sản phẩm
POST   /cart/add              # Thêm vào giỏ
GET    /cart                  # Xem giỏ hàng
POST   /checkout              # Thanh toán
GET    /orders                # Lịch sử đơn
```

---

## 🐛 Troubleshooting

### ❌ Database connection error

```bash
# Kiểm tra MySQL
mysql -u root -p

# Tạo database
mysql -u root -p -e "CREATE DATABASE techstore_db;"

# Chạy migration
php artisan migrate
```

### ❌ Composer error

```bash
composer dump-autoload
php artisan cache:clear
```

### ❌ Không thể thêm biến thể vào giỏ

**Giải pháp:** Kiểm tra `cart_items` table có cột `variant_id` không

```bash
php artisan migrate:fresh --seed
```

Đảm bảo `CartController.php` dùng key: `product_id:variant_id`

### ❌ Assets không load

```bash
npm run build
php artisan cache:clear
php artisan view:clear
```

---

## 🌐 Triển khai Production

### 1. Chuẩn bị

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
```

### 2. Cấu hình Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Setup Nginx

```nginx
server {
    listen 80;
    server_name techstore.local;
    root /var/www/techstore/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }
}
```

### 4. SSL Certificate

```bash
sudo certbot --nginx -d yourdomain.com
```

---

## 📝 Logs & Debugging

```bash
# Xem logs
tail -f storage/logs/laravel.log

# Debug
php artisan tinker
>>> \App\Models\CartItem::where('user_id', 1)->get();
>>> session('cart');
```

---

## 👥 Đóng góp

1. Fork repository
2. Tạo branch: `git checkout -b feature/MyFeature`
3. Commit: `git commit -m 'Add MyFeature'`
4. Push: `git push origin feature/MyFeature`
5. Mở Pull Request

---

## 📄 License

MIT License - xem [LICENSE](LICENSE)

---

## 📞 Hỗ trợ

- 📧 Email: support@techstore.local
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/techstore/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/yourusername/techstore/discussions)

---

<div align="center">

### Made with ❤️ by Techstore Team

⭐ **Nếu dự án này hữu ích, vui lòng cho chúng tôi một star!** ⭐

**Happy Coding! 🚀**

</div>
