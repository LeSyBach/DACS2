# HƯỚNG DẪN DEPLOY - KHÔNG CẦN SYMLINK

## ✅ ĐÃ GIẢI QUYẾT VẤN ĐỀ ẢNH

Code đã được cấu hình để **KHÔNG CẦN SYMLINK** khi deploy lên hosting.

### Cách hoạt động:

1. **Ảnh được lưu trực tiếp vào `public/assets/images/products/`**

    - Không cần `storage:link`
    - Không cần symlink trên hosting
    - Ảnh truy cập trực tiếp: `http://yoursite.com/assets/images/products/image.jpg`

2. **Model Product tự động xử lý URL**
    - Accessor `image_url` tự động thêm `asset()` cho đường dẫn
    - Hỗ trợ cả ảnh external URL (http/https)
    - Hỗ trợ cả đường dẫn cũ trong storage

### Khi deploy:

**Bước 1:** Tạo thư mục trên hosting

```
public_html/
└── assets/
    └── images/
        └── products/    ← Tạo thư mục này
```

**Bước 2:** Copy ảnh hiện có (nếu có)

-   Từ: `techstore/public/assets/images/products/*`
-   Đến: `public_html/assets/images/products/`

**Bước 3:** Set quyền

-   Quyền thư mục: `755`
-   Quyền file ảnh: `644`

### Khi upload ảnh mới:

Ảnh sẽ **TỰ ĐỘNG** được lưu vào `public_html/assets/images/products/`

✅ Không cần copy thủ công
✅ Không cần chạy lệnh gì thêm
✅ Hoạt động ngay lập tức

---

## Checklist Deploy:

### 1. Upload code vào hosting

-   Upload tất cả file/folder vào thư mục `techstore/` (hoặc tên khác)
-   **Lưu ý:** Không upload vào `public_html/` trực tiếp

### 2. Copy file public sang public_html

-   Copy tất cả file trong `techstore/public/*` sang `public_html/`
-   Bao gồm: index.php, .htaccess, robots.txt, assets/

### 3. Tạo thư mục cho ảnh sản phẩm

```
public_html/assets/images/products/
public_html/assets/images/products/variants/
```

Tạo qua File Manager của hosting hoặc FTP

### 4. Sửa file public_html/index.php (QUAN TRỌNG)

Mở `public_html/index.php`, sửa 2 dòng:

**Dòng 17-18 (hoặc gần đó):**

```php
// TỪ:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// ĐỔI THÀNH (thay 'techstore' bằng tên thư mục thực tế):
require __DIR__.'/../techstore/vendor/autoload.php';
$app = require_once __DIR__.'/../techstore/bootstrap/app.php';
```

### 5. Set quyền thư mục (Permission)

Vào File Manager → chọn thư mục → Change Permissions:

-   `techstore/storage/` → **755** (Laravel cần ghi log, cache, session)
-   `techstore/bootstrap/cache/` → **755** (Laravel ghi cache)
-   `public_html/assets/images/products/` → **755** (Admin upload ảnh sản phẩm)
-   `public_html/assets/images/products/variants/` → **755** (Ảnh biến thể)

**Giải thích quyền 755:**

-   7 (owner): Đọc + Ghi + Thực thi
-   5 (group): Đọc + Thực thi
-   5 (other): Đọc + Thực thi

→ Cho phép Laravel và PHP ghi file vào các thư mục này

### 6. Tạo database và import

-   Tạo database mới trong cPanel/Hosting panel
-   Import file `.sql` từ local
-   Lưu tên database, username, password

### 7. Cập nhật file .env

Sửa trong `techstore/.env`:

```env
APP_URL=http://yoursite.com

DB_DATABASE=tên_database_hosting
DB_USERNAME=user_database_hosting
DB_PASSWORD=password_database_hosting
```

### 8. Xóa cache Laravel

Tạo file `public_html/clear.php`:

```php
<?php
require __DIR__.'/../techstore/vendor/autoload.php';
$app = require_once __DIR__.'/../techstore/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('cache:clear');
$kernel->call('config:clear');
$kernel->call('route:clear');
$kernel->call('view:clear');

echo "Cache cleared!";
```

Truy cập: `http://yoursite.com/clear.php`
Sau đó **XÓA FILE** `clear.php` (bảo mật)

### 9. Test upload ảnh

---

## Test ảnh hoạt động:

1. Đăng nhập admin
2. Thêm sản phẩm mới với ảnh
3. Kiểm tra ảnh hiển thị trên:
    - Trang chủ
    - Chi tiết sản phẩm
    - Giỏ hàng
    - Đơn hàng

✅ Nếu tất cả đều hiển thị → Deploy thành công!

---

**LƯU Ý:** Không cần route `/setup-storage` nữa vì ảnh không dùng storage symlink.
