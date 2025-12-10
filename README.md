# Hướng dẫn cài đặt & chạy dự án

## A) Chạy chuẩn (khuyến nghị)

### 1) Yêu cầu
- PHP 8.x, Composer
- Node.js 18+ và npm (hoặc yarn/pnpm)
- MySQL/MariaDB
- Git

### 2) Lấy mã nguồn
```bash
git clone https://github.com/LeSyBach/DACS2.git
cd DACS2
```

### 3) Cài dependencies
Backend:
```bash
composer install
```
Frontend:
```bash
npm install              # hoặc yarn install / pnpm install
```

### 4) Thiết lập môi trường
```bash
cp .env.example .env
php artisan key:generate
```
Chỉnh `.env` cho MySQL (XAMPP hoặc local):
```
APP_NAME="DACS2"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<ten_db>
DB_USERNAME=<user_db>
DB_PASSWORD=<mat_khau_db>
```

### 5) Khởi tạo cơ sở dữ liệu
```bash
php artisan migrate --seed   # --seed nạp dữ liệu mẫu (nếu có seeder)
```

### 6) Build frontend (production, không dev/watch)
```bash
npm run build                # hoặc yarn build / pnpm build
```

### 7) Chạy ứng dụng
- Dùng PHP built-in:
```bash
php artisan serve
```
Truy cập: http://127.0.0.1:8000

- Hoặc nếu dùng XAMPP (Apache):
  - Đặt project trong `htdocs/DACS2`.
  - Truy cập `http://localhost/DACS2/public` (hoặc cấu hình VirtualHost để khỏi cần `/public`).

### 8) Tài khoản quản trị 
- User/Email: `admin@gmail.com`
- Mật khẩu: `123456`
Nếu chưa có: tạo qua seeder (`php artisan db:seed`) hoặc đăng ký rồi gán role admin trong DB.

### 9) Lệnh hữu ích
```bash
php artisan migrate:fresh --seed   # reset DB + seed
php artisan route:list             # xem route
php artisan tinker                 # shell tương tác
npm run lint                       # nếu có lint
npm test / phpunit                 # nếu có test
```

### 10) Triển khai production (tóm tắt)
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci && npm run build            # hoặc npm install
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
- Web server: nginx/Apache + PHP-FPM.
- Queue (nếu có): `php artisan queue:work` (supervisor).
- Scheduler (nếu có): cron `* * * * * php /path/to/artisan schedule:run`.

---

## B) Chạy tối giản với XAMPP (chỉ khi đã có sẵn vendor + public/build + file SQL)
Chỉ áp dụng nếu bạn **đã** có:
- Thư mục `vendor/` (đã cài Composer).
- Thư mục `public/build` (đã build frontend).
- File SQL dump (để import DB).

Các bước:
1) Bật Apache + MySQL trong XAMPP.
2) Đặt mã nguồn vào `htdocs/DACS2`.
3) Import file SQL vào MySQL (tạo DB trước, rồi import).
4) Sao chép `.env.example` thành `.env`, chỉnh:
   ```
   APP_URL=http://localhost/DACS2
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=<ten_db>
   DB_USERNAME=<user_db>
   DB_PASSWORD=<mat_khau_db>
   ```
5) Truy cập `http://localhost/DACS2/public`.

> Lưu ý: Nếu thiếu **vendor** ⇒ vẫn phải chạy `composer install`. Nếu thiếu **public/build** ⇒ vẫn phải `npm install` + `npm run build`. Khi có đủ ba thứ (vendor, build, SQL) thì mới “cắm XAMPP là chạy” mà không cần thêm lệnh build/migrate.
