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

### 🛠️ Công nghệ stack

```
┌─────────────────────────────────────────┐
│            Frontend (Client)            │
├─────────────────────────────────────────┤
│  HTML5 • CSS3 • JavaScript • Alpine.js  │
│         Blade Templating                │
└────────────────┬────────────────────────┘
                 │ HTTP(S)
┌────────────────▼────────────────────────┐
│             Backend (API)               │
├─────────────────────────────────────────┤
│     Laravel 11 • PHP 8.1+ • Eloquent   │
│   Middleware • Controllers • Services   │
└────────────────┬────────────────────────┘
                 │ SQL
┌────────────────▼────────────────────────┐
│          Database (Persistent)          │
├─────────────────────────────────────────┤
│       MySQL 8.0+ • Migrations           │
└─────────────────────────────────────────┘
```

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
│   │   ├── products_table
│   │   ├── product_variants_table
│   │   ├── cart_items_table
│   │   └── orders_table
│   ├── seeders/                  # Sample Data
│   └── factories/                # Test Data Generators
│
├── resources/                    # Frontend Assets
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── admin.blade.php
│   │   ├── products/
│   │   │   ├── index.blade.php
│   │   │   └── detail.blade.php
│   │   ├── cart/
│   │   │   ├── index.blade.php
│   │   │   └── cart-mini.blade.php
│   │   ├── checkout/
│   │   ├── orders/
│   │   ├── admin/
│   │   └── partials/
│   ├── css/
│   │   ├── app.css
│   │   └── tailwind.css
│   └── js/
│       ├── app.js
│       ├── cart.js
│       └── modules/
│
├── routes/
│   ├── web.php                   # Web Routes
│   ├── api.php                   # API Routes (optional)
│   └── admin.php                 # Admin Routes
│
├── public/                       # Web Root
│   ├── index.php
│   ├── storage/
│   └── assets/
│
├── config/                       # Configuration
│   ├── app.php
│   ├── database.php
│   ├── mail.php
│   └── session.php
│
├── storage/
│   ├── app/
│   ├── logs/
│   └── framework/
│
├── tests/
│   ├── Feature/
│   ├── Unit/
│   └── TestCase.php
│
├── .env.example                  # Environment Template
├── composer.json                 # PHP Dependencies
├── package.json                  # Node Dependencies
├── vite.config.js                # Build Configuration
└── README.md                     # This File
```

---

## ✅ Yêu cầu hệ thống

Đảm bảo bạn có các công cụ sau đã cài đặt:

| Công cụ      | Phiên bản | Ghi chú                             |
| ------------ | --------- | ----------------------------------- |
| **PHP**      | 8.1+      | Với extensions: PDO, cURL, JSON, GD |
| **Composer** | 2.0+      | PHP Package Manager                 |
| **MySQL**    | 8.0+      | DBMS (hoặc MariaDB 10.3+)           |
| **Node.js**  | 18+       | JavaScript Runtime                  |
| **npm**      | 9.0+      | Package Manager (hoặc yarn/pnpm)    |

### Kiểm tra cài đặt

```bash
# Kiểm tra phiên bản tất cả công cụ
php --version
composer --version
mysql --version
node --version
npm --version
```

**Output mong muốn:**

```
PHP 8.1.x  ✓
Composer 2.x.x ✓
MySQL 8.0.x ✓
Node.js v18.x.x ✓
npm 9.x.x ✓
```

---

## 🚀 Hướng dẫn cài đặt

### Phương án 1: Cài đặt hoàn toàn (Khuyến nghị)

#### Bước 1: Clone repository

```bash
git clone https://github.com/yourusername/techstore.git
cd techstore
```

#### Bước 2: Cài đặt PHP dependencies

```bash
composer install
```

#### Bước 3: Cài đặt Node dependencies

```bash
npm install
```

#### Bước 4: Tạo file `.env` và sinh khóa

```bash
cp .env.example .env
php artisan key:generate
```

#### Bước 5: Cấu hình database

**Chỉnh sửa file `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_db
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

#### Bước 6: Chạy migrations & seeders

```bash
php artisan migrate --seed
```

#### Bước 7: Build frontend assets

```bash
# Phát triển (có watch mode)
npm run dev

# Hoặc Production
npm run build
```

#### Bước 8: Khởi chạy dev server

**Terminal 1 - Laravel server:**

```bash
php artisan serve
```

**Terminal 2 - Vite dev server (nếu cần):**

```bash
npm run dev
```

Truy cập: **http://127.0.0.1:8000**

---

### Phương án 2: Cài đặt tối giản (XAMPP)

**Điều kiện:** Đã có `vendor/`, `node_modules/`, `public/build/` và file SQL

1. **Bật XAMPP (Apache + MySQL)**

2. **Đặt project vào `htdocs`:**

```bash
cp -r techstore /path/to/xampp/htdocs/
```

3. **Import database:**

```bash
mysql -u root -p < techstore.sql
```

4. **Cấu hình `.env`:**

```env
APP_URL=http://localhost/techstore
DB_HOST=127.0.0.1
DB_DATABASE=techstore_db
```

5. **Truy cập:**

```
http://localhost/techstore/public
```

---

## ⚙️ Cấu hình môi trường

### File `.env` chi tiết

```env
# ========== APP CONFIG ==========
APP_NAME="Techstore"
APP_ENV=local                          # local|production
APP_DEBUG=true                         # false trên production
APP_URL=http://localhost:8000
APP_TIMEZONE=UTC

# ========== DATABASE ==========
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techstore_db
DB_USERNAME=root
DB_PASSWORD=

# ========== CACHE ==========
CACHE_DRIVER=file                      # file|redis|memcached
SESSION_DRIVER=cookie                  # cookie|database
QUEUE_CONNECTION=sync

# ========== MAIL ==========
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@techstore.local
MAIL_FROM_NAME="Techstore"

# ========== PAYMENT GATEWAY (Optional) ==========
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=...
PAYPAL_CLIENT_SECRET=...

# ========== LOG ==========
LOG_CHANNEL=single
LOG_LEVEL=debug                        # debug|info|warning|error

# ========== AWS S3 (Optional) ==========
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# ========== SOCIAL AUTH (Optional) ==========
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```

### Tài khoản mặc định (sau seeding)

```
┌─────────────────────────────────────┐
│        TRANG QUẢN TRỊ ADMIN         │
├─────────────────────────────────────┤
│ URL:      http://localhost:8000/admin
│ Email:    admin@techstore.local
│ Password: password
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│          TRANG KHÁCH HÀNG TEST      │
├─────────────────────────────────────┤
│ Email:    user@techstore.local
│ Password: password
└─────────────────────────────────────┘
```

> ⚠️ **BẬN AN TOÀN:** Thay đổi tất cả mật khẩu trước khi triển khai production!

---

## 💡 Sử dụng

### 👤 Trang Khách Hàng

**Quy trình mua sắm:**

1. **Duyệt sản phẩm**
    - Truy cập trang chủ → Xem danh sách sản phẩm
    - Dùng tìm kiếm hoặc filter theo danh mục

2. **Xem chi tiết sản phẩm**
    - Click vào sản phẩm → Xem ảnh, mô tả, giá
    - Chọn biến thể (size, color) nếu có

3. **Thêm vào giỏ hàng**
    - Nhập số lượng → Click "Thêm vào giỏ"
    - Giỏ cập nhật real-time (AJAX)

4. **Xem giỏ hàng**
    - Click icon giỏ hàng (góc phải)
    - Xem tổng tiền, có thể cập nhật số lượng

5. **Thanh toán**
    - Click "Thanh toán" → Điền thông tin giao hàng
    - Chọn phương thức thanh toán
    - Hoàn tất đơn hàng

6. **Xem lịch sử đơn**
    - Đăng nhập → "Đơn hàng của tôi"
    - Xem trạng thái, chi tiết đơn hàng

### 🔐 Trang Admin

**Quyền truy cập:**

```bash
# Đăng nhập vào http://localhost:8000/admin
Email:    admin@techstore.local
Password: password
```

**Chức năng:**

| Menu           | Chức năng                                       |
| -------------- | ----------------------------------------------- |
| **Sản phẩm**   | Thêm/Sửa/Xóa sản phẩm, quản lý biến thể         |
| **Đơn hàng**   | Xem tất cả đơn, cập nhật trạng thái, in hóa đơn |
| **Người dùng** | Quản lý tài khoản khách hàng                    |
| **Danh mục**   | Tạo/Sửa danh mục sản phẩm                       |
| **Báo cáo**    | Xem thống kê doanh thu, tồn kho                 |

---

## 🗺️ API & Routes

### Xem danh sách tất cả routes

```bash
php artisan route:list
```

### Route chính

#### 🛍️ Sản phẩm

```
GET    /products              # Danh sách sản phẩm
GET    /products/{id}         # Chi tiết sản phẩm
GET    /products?category=1   # Filter theo danh mục
GET    /products?search=...   # Tìm kiếm
```

#### 🛒 Giỏ hàng

```
POST   /cart/add              # Thêm vào giỏ
GET    /cart                  # Xem giỏ hàng
POST   /cart/update/{id}      # Cập nhật số lượng
DELETE /cart/remove/{id}      # Xóa khỏi giỏ
POST   /cart/clear            # Xóa tất cả
```

#### 💳 Thanh toán & Đơn hàng

```
POST   /checkout              # Tạo đơn hàng
GET    /orders                # Lịch sử đơn (user đăng nhập)
GET    /orders/{id}           # Chi tiết đơn hàng
```

#### 👤 Tài khoản

```
GET    /login                 # Form đăng nhập
POST   /login                 # Xử lý đăng nhập
POST   /logout                # Đăng xuất
GET    /register              # Form đăng ký
POST   /register              # Xử lý đăng ký
```

---

## 🐛 Troubleshooting

### ❌ Lỗi: "SQLSTATE[HY000]: General error"

**Nguyên nhân:** Không kết nối được database

**Giải pháp:**

```bash
# 1. Kiểm tra MySQL đang chạy
mysql -u root -p

# 2. Kiểm tra thông tin DB trong .env
cat .env | grep DB_

# 3. Tạo database nếu chưa có
mysql -u root -p -e "CREATE DATABASE techstore_db;"

# 4. Chạy migration
php artisan migrate
```

---

### ❌ Lỗi: "Class not found"

**Giải pháp:**

```bash
composer dump-autoload
php artisan cache:clear
```

---

### ❌ Lỗi: Không thể thêm biến thể vào giỏ

**Nguyên nhân:** Unique constraint chỉ tính `product_id`, bỏ qua `variant_id`

**Giải pháp:**

1. Kiểm tra cột `variant_id` trong bảng `cart_items`:

```bash
mysql -u root -p techstore_db
DESCRIBE cart_items;
```

2. Nếu thiếu, chạy migration:

```bash
php artisan migrate:fresh --seed
```

3. Kiểm tra `CartController.php` dùng key `product_id:variant_id`:

```php
$cartKey = "{$productId}:{$variantId}";
```

4. Xác nhận `cart-mini.blade.php` hiển thị từng variant riêng

---

### ❌ Assets không load (CSS/JS trắng)

**Giải pháp:**

```bash
# 1. Build lại assets
npm run build

# 2. Hoặc dùng dev mode
npm run dev

# 3. Clear cache
php artisan cache:clear
php artisan view:clear

# 4. Check symbolic link (nếu dùng storage)
php artisan storage:link
```

---

### ❌ Lỗi CORS (Cross-Origin)

**Giải pháp:** Cấu hình trong `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'],
```

---

### ❌ Session không lưu (giỏ hàng bị reset)

**Giải pháp:**

```bash
# 1. Kiểm tra config/session.php
# SESSION_DRIVER=cookie hoặc database

# 2. Nếu dùng database:
php artisan session:table
php artisan migrate

# 3. Clear session
php artisan session:flush
```

---

### ❌ Mail không gửi được

**Giải pháp:**

```bash
# 1. Kiểm tra .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password  # NOT your Gmail password

# 2. Bật "Less secure app access" trên Google
# hoặc dùng App Password

# 3. Test gửi mail:
php artisan tinker
>>> Mail::raw('Hello', function($m) { $m->to('test@example.com'); });
```

---

## 🌐 Triển khai Production

### 1️⃣ Chuẩn bị server

```bash
# Cài dependencies (không dev)
composer install --no-dev --optimize-autoloader

# Build assets production
npm ci && npm run build
```

### 2️⃣ Cấu hình Laravel

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate app key (nếu chưa có)
php artisan key:generate --force
```

### 3️⃣ Setup Web Server - Nginx

**File `/etc/nginx/sites-available/techstore.conf`:**

```nginx
upstream techstore {
    server 127.0.0.1:9000;
}

server {
    listen 80;
    server_name techstore.local;
    root /var/www/techstore/public;

    index index.php index.html;
    charset utf-8;

    # Logging
    access_log /var/log/nginx/techstore-access.log;
    error_log /var/log/nginx/techstore-error.log;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

    # Gzip compression
    gzip on;
    gzip_types text/plain text/css text/xml application/json;
}
```

**Enable site:**

```bash
sudo ln -s /etc/nginx/sites-available/techstore.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 4️⃣ Setup SSL Certificate (Let's Encrypt)

```bash
sudo apt-get install certbot python3-certbot-nginx
sudo certbot --nginx -d techstore.local
sudo systemctl reload nginx
```

### 5️⃣ Setup Queue Worker (Background Jobs)

**Dùng Supervisor:**

```ini
# /etc/supervisor/conf.d/techstore-queue.conf
[program:techstore-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/techstore/artisan queue:work --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/techstore-queue.log
user=www-data
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start techstore-queue:*
```

### 6️⃣ Setup Scheduler (Cron Jobs)

```bash
# Thêm vào crontab
crontab -e
```

```cron
* * * * * php /var/www/techstore/artisan schedule:run >> /dev/null 2>&1
```

### 7️⃣ Database Backup

```bash
# Daily backup script
#!/bin/bash
BACKUP_DIR="/backups/techstore"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p$MYSQL_PASSWORD techstore_db | gzip > $BACKUP_DIR/techstore_$DATE.sql.gz

# Cron job
0 2 * * * /path/to/backup.sh
```

---

## 📝 Logs & Debugging

### Xem logs ứng dụng

```bash
# Real-time log
tail -f storage/logs/laravel.log

# Last 100 lines
tail -100 storage/logs/laravel.log

# Grep errors
grep -i error storage/logs/laravel.log
```

### Clear cache & logs

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Or one command
php artisan optimize:clear

# Clear logs
rm storage/logs/laravel.log
```

### Debug mode

**Kích hoạt tạm thời:**

```php
// Trong routes/web.php
Route::get('/debug', function() {
    dd(\Cache::get('cart'));
    dd(\DB::table('cart_items')->get());
});
```

**Hoặc dùng Tinker:**

```bash
php artisan tinker
>>> \App\Models\CartItem::where('user_id', 1)->get();
>>> session('cart');
```

---

## 👥 Đóng góp

Chúng tôi rất hoan nghênh các đóng góp từ cộng đồng!

### Quy trình đóng góp

1. **Fork repository**

    ```bash
    git clone https://github.com/yourusername/techstore.git
    ```

2. **Tạo branch feature**

    ```bash
    git checkout -b feature/AmazingFeature
    git checkout -b bugfix/CriticalBug
    ```

3. **Commit changes**

    ```bash
    git add .
    git commit -m 'Add some AmazingFeature'
    # Hoặc
    git commit -m 'Fix critical bug in cart'
    ```

4. **Push to branch**

    ```bash
    git push origin feature/AmazingFeature
    ```

5. **Mở Pull Request**
    - So sánh branch của bạn với `main`
    - Mô tả chi tiết thay đổi
    - Chờ review từ maintainers

### Coding Standards

- PSR-12 cho PHP code
- ESLint config cho JavaScript
- Viết unit tests cho các feature mới
- Update documentation nếu cần

---

## 📄 License

Dự án này được cấp phép dưới **MIT License**.

Xem file [LICENSE](LICENSE) để chi tiết đầy đủ.

---

## 📞 Hỗ trợ & Liên hệ

### Cách liên hệ

| Kênh               | Địa chỉ                                                                     |
| ------------------ | --------------------------------------------------------------------------- |
| 📧 **Email**       | support@techstore.local                                                     |
| 🐛 **Issues**      | [GitHub Issues](https://github.com/yourusername/techstore/issues)           |
| 💬 **Discussions** | [GitHub Discussions](https://github.com/yourusername/techstore/discussions) |
| 📖 **Wiki**        | [GitHub Wiki](https://github.com/yourusername/techstore/wiki)               |

### FAQ

**Q: Tôi có thể sử dụng dự án này cho mục đích thương mại không?**
A: Có, theo MIT License. Chỉ cần giữ lại notice license.

**Q: Làm thế nào để báo cáo lỗi bảo mật?**
A: Gửi email trực tiếp đến security@techstore.local (không công khai issue)

**Q: Dự án này có hỗ trợ multi-language không?**
A: Không hiện tại. Bạn có thể đóng góp translate!

---

## 🎉 Credits

- **Laravel Team** - Web framework
- **TailwindCSS** - Styling
- **Alpine.js** - Interactivity
- **Các Contributors** - GitHub community

---

<div align="center">

### Made with ❤️ by Techstore Team

⭐ **Nếu dự án này hữu ích, vui lòng cho chúng tôi một star!** ⭐

![visitors](https://visitor-badge.glitch.me/badge?page_id=techstore.readme)

**Happy Coding! 🚀**

</div>
