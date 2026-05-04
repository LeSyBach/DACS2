-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2025 lúc 03:48 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `techstore`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại', 'dien-thoai', 'fa-mobile-screen-button', '2025-11-25 08:06:29', '2025-12-07 07:32:32'),
(2, 'Laptop', 'laptop', 'fa-laptop', '2025-11-25 08:06:29', '2025-11-25 08:06:29'),
(3, 'Đồng hồ', 'dong-ho', 'fa-clock', '2025-11-25 08:06:29', '2025-11-25 08:06:29'),
(4, 'Tai nghe', 'tai-nghe', 'fa-solid fa-headphones', '2025-12-05 13:00:31', '2025-12-07 08:03:51'),
(6, 'Máy tính bảng', 'may-tinh-bang', 'fa-solid fa-tablet', '2025-12-07 08:05:11', '2025-12-08 18:21:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','processing','resolved') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 'Lê Sỹ Bách', 'bachls.24it@vku.udn.vn', '0333421432', 'fef', 'dfgtjtutudesferyrettrybynyv grgb rgretwewr4t', 'pending', NULL, '2025-12-07 04:37:03', '2025-12-07 04:37:03'),
(2, 'Lê Sỹ Bách', 'bachls.24it@vku.udn.vn', 'fdhfghdgfg', 'adsfdgdfhgfdh', 'ádgdfdjfhkgjlgfhkgd dfbdfghjghgfewqewd', 'pending', NULL, '2025-12-07 04:39:17', '2025-12-07 04:39:17'),
(3, 'Lê Sỹ Bách', 'bachfanscp10@gmail.com', '0333421432', 'aefreyt', 'ytiu6y435rwt4y53y42', 'pending', NULL, '2025-12-07 04:40:51', '2025-12-07 04:40:51'),
(4, 'Lê Sỹ Bách', 'bachfanscp10@gmail.com', '0333421432', 'dsfdsfhfh', 'dhfgjhjytuyrwe', 'pending', NULL, '2025-12-07 04:42:40', '2025-12-07 04:42:40'),
(5, 'Lê Sỹ Bách', 'bachls.24it@vku.udn.vn', '0333421432', 'dsfdsfhfh', 'drwetjtytukrte fdhnbyjt eytvvfb  ưt', 'pending', NULL, '2025-12-08 07:07:24', '2025-12-08 07:07:24'),
(6, 'Lê Sỹ Bách', 'bachls.24it@vku.udn.vn', '0333421432', 'dsfdsfhfh', 'dsfghytjrtkuilk bfgenhrtj re', 'pending', NULL, '2025-12-08 07:12:44', '2025-12-08 07:12:44'),
(7, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0987654321', 'gtjyrujet', 'dfbhtly;uiulryekt', 'pending', NULL, '2025-12-08 07:16:14', '2025-12-08 07:16:14'),
(8, 'BACH', 'lesybach13012004@gmail.com', '0333421432', 'aefreyt', 'reyrtjouyie', 'pending', NULL, '2025-12-08 07:19:49', '2025-12-08 07:19:49'),
(9, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0333421432', 'bach', 'đầHFGKHJGFSH', 'pending', NULL, '2025-12-08 08:07:36', '2025-12-08 08:07:36'),
(10, 'Hưng Cao', 'bach@gmail.com', '0987654321', 'CDSFDSHRTH', 'GDTESJUJTR', 'pending', NULL, '2025-12-08 08:12:10', '2025-12-08 08:12:10'),
(11, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0987654321', 'DBDSFGDHGJ', 'SBDFB  XCVBADHCS TÚ CHOUIR5R PJAIR LÀM CÚG NGIANG NHƯ HỞI PHAIEDER', 'pending', NULL, '2025-12-08 08:13:35', '2025-12-08 08:13:35'),
(12, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0987654321', 'dsfdndfdmm', 'xzbddfghfjlhyl,hkjgfjnd juk ts', 'pending', NULL, '2025-12-08 08:22:48', '2025-12-08 08:22:48'),
(13, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0333421432', 'dfaresrtjetkrytu', 'RĂTEYREUTIYOUIULYKTJSAWREtaeysruj', 'pending', NULL, '2025-12-08 08:32:04', '2025-12-08 08:32:04'),
(14, 'Lê Sỹ Bách', 'lesybach13012004@gmail.com', '0987654321', 'adsfdgdfhgfdh', 'aersdthyfukgfgxxhdfhcvbjvcvhbbgyvu6yc5rtrtcf jbkvc ,hhtjyful', 'pending', NULL, '2025-12-08 08:36:04', '2025-12-08 08:36:04'),
(15, 'BACH', 'bachls.24it@vku.udn.vn', '034753446576', 'gtjyrujet', 'chgmvj,lkcgjdfghkgulkfgjkhlghi;lukhjgnb', 'pending', NULL, '2025-12-08 08:37:20', '2025-12-08 08:37:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000000_create_sessions_table', 1),
(5, '2025_11_25_135821_create_categories_table', 1),
(6, '2025_11_25_135821_create_orders_table', 1),
(7, '2025_11_25_135821_create_products_table', 1),
(8, '2025_11_25_135822_create_order_items_table', 1),
(9, '2025_11_25_135822_create_reviews_table', 1),
(10, '2025_11_29_090631_add_otp_fields_to_users_table', 2),
(11, '2025_11_30_034714_create_cart_items_table', 3),
(12, '2025_11_30_100155_add_payment_status_to_orders_table', 4),
(13, '2025_12_07_113137_create_contacts_table', 5),
(14, '2025_12_08_231433_add_search_text_to_products_table', 6),
(15, '2025_12_09_190403_create_product_variants_table', 7),
(16, '2025_12_09_204227_add_price_columns_to_product_variants_table', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `total_price` decimal(15,0) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(20) NOT NULL DEFAULT 'unpaid',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_phone`, `customer_email`, `shipping_address`, `total_price`, `payment_method`, `payment_status`, `status`, `note`, `created_at`, `updated_at`) VALUES
(8, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 40020000, 'cod', 'unpaid', 'cancelled', NULL, '2025-11-30 04:16:18', '2025-12-05 12:09:01'),
(9, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 30020000, 'cod', 'unpaid', 'completed', NULL, '2025-11-30 05:19:04', '2025-12-06 10:41:53'),
(10, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 104010000, 'cod', 'paid', 'completed', NULL, '2025-11-30 06:12:48', '2025-12-07 05:17:50'),
(11, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 2030000, 'cod', 'unpaid', 'pending', NULL, '2025-11-30 14:00:03', '2025-11-30 14:00:03'),
(12, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 23030000, 'cod', 'unpaid', 'shipped', NULL, '2025-11-30 14:42:30', '2025-12-07 05:18:25'),
(13, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 24030000, 'zalopay', 'pending', 'pending_payment', NULL, '2025-11-30 14:43:33', '2025-11-30 14:43:33'),
(14, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 53020000, 'zalopay', 'pending', 'pending_payment', NULL, '2025-11-30 14:57:17', '2025-11-30 14:57:17'),
(15, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 30000, 'cod', 'unpaid', 'processing', NULL, '2025-11-30 15:04:48', '2025-12-07 05:19:59'),
(16, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 23030000, 'zalopay', 'pending', 'processing', NULL, '2025-11-30 15:05:06', '2025-12-07 05:18:09'),
(17, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 30000, 'cod', 'unpaid', 'pending', NULL, '2025-11-30 15:08:32', '2025-12-06 14:02:25'),
(19, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 5030000, 'cod', 'paid', 'completed', NULL, '2025-11-30 15:18:23', '2025-12-07 04:52:11'),
(21, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 24030000, 'cod', 'unpaid', 'pending', NULL, '2025-11-30 15:20:46', '2025-11-30 15:20:46'),
(22, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'Ngu hanh sown dan nanwg', 30000, 'cod', 'unpaid', 'cancelled', NULL, '2025-11-30 15:21:16', '2025-12-05 12:09:41'),
(24, NULL, 'zxfgchvjb', '0987654321', 'cghg@drtt', 'zrxghcvjbkn', 24030000, 'cod', 'unpaid', 'cancelled', NULL, '2025-12-03 16:13:30', '2025-12-05 12:09:27'),
(26, 6, 'BACHCP10', '0987621', 'bachfanscp10@gmail.com', 'greujrtu', 48030000, 'cod', 'paid', 'completed', NULL, '2025-12-06 22:25:18', '2025-12-07 04:49:29'),
(27, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'NGhệ an', 10030000, 'cod', 'paid', 'completed', NULL, '2025-12-07 05:06:40', '2025-12-07 05:16:56'),
(28, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'NGhệ an', 30020000, 'cod', 'paid', 'completed', NULL, '2025-12-07 05:11:17', '2025-12-07 05:16:34'),
(29, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'NGhệ an', 14030000, 'cod', 'unpaid', 'pending', NULL, '2025-12-07 12:22:39', '2025-12-07 12:22:39'),
(30, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'NGhệ an', 61020000, 'cod', 'unpaid', 'pending', NULL, '2025-12-08 07:26:22', '2025-12-08 07:26:22'),
(31, 2, 'Lê Sỹ Bách', '0333421432', 'bachls.24it@vku.udn.vn', 'NGhệ an', 35020000, 'cod', 'unpaid', 'pending', NULL, '2025-12-08 16:31:20', '2025-12-08 16:31:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `variant_info` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`, `variant_info`) VALUES
(2, 8, 1, NULL, 'iPhone 15 Pro Max 256GB', 1, 29990000, '2025-11-30 04:16:18', '2025-11-30 04:16:18', NULL),
(3, 8, 6, NULL, 'Sản phẩm perspiciatis vero omnis', 2, 5000000, '2025-11-30 04:16:18', '2025-11-30 04:16:18', NULL),
(4, 9, 1, NULL, 'iPhone 15 Pro Max 256GB', 1, 29990000, '2025-11-30 05:19:04', '2025-11-30 05:19:04', NULL),
(5, 10, 23, NULL, 'Sản phẩm mollitia optio vel', 1, 21000000, '2025-11-30 06:12:48', '2025-11-30 06:12:48', NULL),
(6, 10, 1, NULL, 'iPhone 15 Pro Max 256GB', 1, 29990000, '2025-11-30 06:12:48', '2025-11-30 06:12:48', NULL),
(8, 11, 5, NULL, 'Sản phẩm repudiandae non et', 1, 2000000, '2025-11-30 14:00:03', '2025-11-30 14:00:03', NULL),
(9, 12, 7, NULL, 'Sản phẩm necessitatibus illum culpa', 1, 23000000, '2025-11-30 14:42:30', '2025-11-30 14:42:30', NULL),
(10, 13, 22, NULL, 'Sản phẩm quos quia consectetur', 1, 24000000, '2025-11-30 14:43:34', '2025-11-30 14:43:34', NULL),
(12, 16, 7, NULL, 'Sản phẩm necessitatibus illum culpa', 1, 23000000, '2025-11-30 15:05:06', '2025-11-30 15:05:06', NULL),
(14, 19, 6, NULL, 'Sản phẩm perspiciatis vero omnis', 1, 5000000, '2025-11-30 15:18:23', '2025-11-30 15:18:23', NULL),
(16, 21, 22, NULL, 'Sản phẩm quos quia consectetur', 1, 24000000, '2025-11-30 15:20:46', '2025-11-30 15:20:46', NULL),
(18, 24, 22, NULL, 'Sản phẩm quos quia consectetur', 1, 24000000, '2025-12-03 16:13:30', '2025-12-03 16:13:30', NULL),
(21, 26, 22, NULL, 'Sản phẩm quos quia consectetur', 2, 24000000, '2025-12-06 22:25:18', '2025-12-06 22:25:18', NULL),
(22, 27, 4, NULL, 'Sản phẩm neque esse expedita', 1, 10000000, '2025-12-07 05:06:40', '2025-12-07 05:06:40', NULL),
(23, 28, 1, NULL, 'iPhone 15 Pro Max 256GB', 1, 29990000, '2025-12-07 05:11:17', '2025-12-07 05:11:17', NULL),
(24, 29, 18, NULL, 'Sản phẩm libero cumque laboriosam', 1, 14000000, '2025-12-07 12:22:39', '2025-12-07 12:22:39', NULL),
(25, 30, 4, NULL, 'Laptop MacBook Pro 14 inch M4 Pro', 1, 49990000, '2025-12-08 07:26:22', '2025-12-08 07:26:22', NULL),
(26, 30, 21, NULL, 'Sản phẩm non neque nesciunt', 1, 11000000, '2025-12-08 07:26:22', '2025-12-08 07:26:22', NULL),
(27, 31, 6, NULL, 'Điện thoại iPhone 17 Pro', 1, 34990000, '2025-12-08 16:31:20', '2025-12-08 16:31:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(15,0) NOT NULL,
  `old_price` decimal(15,0) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `search_text` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `price`, `old_price`, `image`, `description`, `search_text`, `content`, `quantity`, `is_featured`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 15 Pro Max 256GB', 'iphone-15-pro-max', 29990000, 33990000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Titan tự nhiên, chip A17 Pro cực mạnh, camera zoom quang học 5x.', 'iPhone 15 Pro Max 256GB Titan tu nhien, chip A17 Pro cuc manh, camera zoom quang hoc 5x.', NULL, 50, 1, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:40'),
(4, 'Laptop MacBook Pro 14 inch M4 Pro', 'laptop-macbook-pro-14-inch-m4-pro', 49990000, 51990000, '/storage/products/qcuQHimIdZaTzyqa0eNppv7Fa5rjt1WQejdvoOpd.jpg', 'Khi nói đến máy tính xách tay cho các tác vụ đồ họa và kỹ thuật, Apple luôn giữ vững vị thế hàng đầu và Macbook Pro 14 inch M4 Pro 24GB/512GB - mẫu sản phẩm máy tính xách tay \"mới toanh\" từ nhà Táo trong năm nay là minh chứng rõ nhất.', 'Laptop MacBook Pro 14 inch M4 Pro Khi noi den may tinh xach tay cho cac tac vu do hoa va ky thuat, Apple luon giu vung vi the hang dau va Macbook Pro 14 inch M4 Pro 24GB/512GB - mau san pham may tinh xach tay \"moi toanh\" tu nha Tao trong nam nay la minh chung ro nhat.', NULL, 100, 1, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:40'),
(5, 'Apple Watch Series 11 GPS', 'apple-watch-series-11-gps', 14190000, 14490000, '/storage/products/Hrpbm85dCcgfKMr3OCZreWLuhY3BqrVockonevi6.jpg', 'Apple Watch Series 11 sở hữu thiết kế tinh tế với độ mỏng chỉ 9.7 mm, vỏ nhôm cứng cáp và dây thể thao nhẹ nhàng, phù hợp cả khi vận động lẫn trong môi trường công sở. Lớp hoàn thiện cao cấp giúp sản phẩm giữ được sự sang trọng nhưng vẫn trẻ trung, năng động', 'Apple Watch Series 11 GPS Apple Watch Series 11 so huu thiet ke tinh te voi do mong chi 9.7 mm, vo nhom cung cap va day the thao nhe nhang, phu hop ca khi van dong lan trong moi truong cong so. Lop hoan thien cao cap giup san pham giu duoc su sang trong nhung van tre trung, nang dong', NULL, 100, 1, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:40'),
(6, 'Điện thoại iPhone 17 Pro', 'dien-thoai-iphone-17-pro', 34990000, NULL, '/storage/products/UCmupwAdN4zeGfK6i3cXxIAj0il0HWzJ92TiZLEr.jpg', 'Chinh phục mọi giới hạn với chip A19 Pro được tối ưu bởi tản nhiệt buồng hơi.', 'Dien thoai iPhone 17 Pro Chinh phuc moi gioi han voi chip A19 Pro duoc toi uu boi tan nhiet buong hoi.', NULL, 100, 1, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(7, 'Sản phẩm necessitatibus illum culpa', 'san-pham-necessitatibus-illum-culpa-7570', 23000000, 35000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Facilis eius eos debitis est doloremque. Eligendi voluptatem ut iure voluptatem ullam omnis repellat est.', 'San pham necessitatibus illum culpa Facilis eius eos debitis est doloremque. Eligendi voluptatem ut iure voluptatem ullam omnis repellat est.', 'Et quis dolores debitis et et quia. Omnis in unde quibusdam quo ullam quis. Aut recusandae in et dolorum. Maxime quas sed veritatis maiores eius. Placeat dolores omnis est iste ut. Non nihil necessitatibus reiciendis veritatis quas. Quod non id magni totam voluptatibus occaecati. Nemo ut qui voluptate qui assumenda. Pariatur in corrupti rem sint. Sed eum officiis cum qui iure voluptate a. Provident sit dolorem non aspernatur esse enim.', 100, 1, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(8, 'Sản phẩm minus aut et', 'san-pham-minus-aut-et-3306', 6000000, 32000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Hic dolorum quasi deserunt. Voluptas rerum sit atque asperiores et et sint aspernatur. Unde repellat nobis expedita ab vel.', 'San pham minus aut et Hic dolorum quasi deserunt. Voluptas rerum sit atque asperiores et et sint aspernatur. Unde repellat nobis expedita ab vel.', 'Voluptatem sed qui natus hic. Ut maxime et molestiae impedit dolore minus laborum. Distinctio deleniti unde voluptas rerum exercitationem nostrum. Officia ut libero nostrum autem. Voluptas vero aspernatur molestiae natus provident. Fugiat ad et facilis quo. Non blanditiis sed dicta corporis eveniet.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(9, 'Sản phẩm cumque quam aliquid', 'san-pham-cumque-quam-aliquid-4488', 11000000, 34000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Sunt nisi aperiam dolorum eos dolorem. Placeat et repudiandae voluptatum molestias totam. Ipsa totam id odit voluptatem iste maxime.', 'San pham cumque quam aliquid Sunt nisi aperiam dolorum eos dolorem. Placeat et repudiandae voluptatum molestias totam. Ipsa totam id odit voluptatem iste maxime.', 'Culpa minima beatae voluptatum ratione explicabo et at. Qui eum deserunt et quia enim. Pariatur hic velit illum. Officiis eveniet eum laudantium ut. Enim doloribus dolores possimus in. Quibusdam voluptatum ut accusamus. Optio aspernatur sit et facilis quasi assumenda. Ut explicabo in earum id reprehenderit in porro fuga. Sed consectetur repellat consequatur dolores.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(10, 'Sản phẩm cupiditate quia et', 'san-pham-cupiditate-quia-et-3941', 12000000, 39000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Porro earum molestiae non aut. Hic sit odio dicta eius nihil modi quia. Iste voluptatum dolorum similique ea impedit.', 'San pham cupiditate quia et Porro earum molestiae non aut. Hic sit odio dicta eius nihil modi quia. Iste voluptatum dolorum similique ea impedit.', 'Recusandae perspiciatis nihil corporis distinctio eum aut. Et a rerum mollitia harum quia. Corrupti ipsa omnis et maxime nulla sint. Culpa sit sed perferendis fuga totam. Sed laborum voluptatem sunt dolore hic impedit officia. Maiores maiores nihil assumenda molestiae quia. Sint incidunt saepe recusandae fugiat dolores. Aut dignissimos est nobis non mollitia aut recusandae. Qui nisi corporis aut perferendis ipsa odit.', 100, 0, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(11, 'Sản phẩm nobis eos quisquam', 'san-pham-nobis-eos-quisquam-4018', 24000000, 35000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Placeat quaerat officiis iste totam hic vero ut. Ut vero quis autem praesentium consequuntur. Fugit optio esse eveniet ea sequi fugiat.', 'San pham nobis eos quisquam Placeat quaerat officiis iste totam hic vero ut. Ut vero quis autem praesentium consequuntur. Fugit optio esse eveniet ea sequi fugiat.', 'Earum fugit est voluptatem assumenda repellat saepe et. Ut sapiente voluptates quam adipisci dolorem. Non ea expedita ut. Sapiente saepe recusandae tenetur et. Omnis temporibus autem qui. Consequuntur velit eum ex illum. Voluptatem minus consectetur dolore repudiandae sit ab in voluptas. Quas velit dicta et labore consectetur esse omnis. Rerum non eveniet nihil eligendi assumenda quos. Sed consequatur aperiam quas ut voluptas beatae.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(12, 'Sản phẩm voluptatem necessitatibus facere', 'san-pham-voluptatem-necessitatibus-facere-1258', 30000000, 33000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Voluptatem maiores saepe sit facere quia voluptatibus placeat. Voluptatem enim porro quis qui quas sed maiores et.', 'San pham voluptatem necessitatibus facere Voluptatem maiores saepe sit facere quia voluptatibus placeat. Voluptatem enim porro quis qui quas sed maiores et.', 'Sunt a enim placeat sint. Facilis illo tempore esse et quis. Est quaerat voluptatem provident labore. Dolorem omnis maxime quo debitis neque. Quo aliquid natus quisquam expedita rerum aut. Dignissimos deleniti sed vel praesentium repellendus laboriosam minima. Voluptatem velit mollitia dignissimos dolore aut. Commodi consequuntur repellendus quaerat. Aspernatur possimus tempore sapiente vel.', 100, 0, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(13, 'Sản phẩm dolorem perspiciatis id', 'san-pham-dolorem-perspiciatis-id-3910', 7000000, 38000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Magni cupiditate aliquid consequatur perferendis modi expedita qui. Sit eos amet eum voluptas sint veritatis. Rerum beatae repellendus sint numquam ut reiciendis ad.', 'San pham dolorem perspiciatis id Magni cupiditate aliquid consequatur perferendis modi expedita qui. Sit eos amet eum voluptas sint veritatis. Rerum beatae repellendus sint numquam ut reiciendis ad.', 'Dolorem reiciendis labore in sed libero. Molestiae sed iste qui. Adipisci praesentium ut ut corporis provident accusantium nemo. Minima earum fugiat eum autem soluta debitis et ut. Mollitia officia animi sed molestiae a cupiditate necessitatibus. Excepturi distinctio vel delectus est. At nisi rerum voluptatem unde qui quibusdam. Adipisci quia velit dolores facere dolorem atque voluptatem. Inventore laboriosam natus aperiam iste nesciunt harum deleniti.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(14, 'Sản phẩm sunt necessitatibus est', 'san-pham-sunt-necessitatibus-est-3139', 4000000, 35000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Qui facere id cumque nulla ad quo amet. Nesciunt nostrum labore minus quo facilis fuga.', 'San pham sunt necessitatibus est Qui facere id cumque nulla ad quo amet. Nesciunt nostrum labore minus quo facilis fuga.', 'Error dolores recusandae omnis soluta sint. Fuga quam et rerum maxime labore. Optio earum veniam dolores non perspiciatis fugiat aliquid. Deleniti omnis accusantium et. Ut nemo veniam corrupti minus consequuntur quaerat repudiandae porro. Ut temporibus quia qui. Eum ea reiciendis harum et odio maiores. Minus dolor necessitatibus sit tenetur porro dolor. In facilis quasi sit laborum.', 100, 0, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(15, 'Sản phẩm qui deserunt sit', 'san-pham-qui-deserunt-sit-3871', 3000000, 40000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Numquam est consequuntur eaque itaque ratione magni inventore cum. Debitis tempore et illo suscipit in velit voluptatem esse.', 'San pham qui deserunt sit Numquam est consequuntur eaque itaque ratione magni inventore cum. Debitis tempore et illo suscipit in velit voluptatem esse.', 'Neque et et officiis quisquam eius. Eveniet et distinctio culpa voluptatibus rerum labore. Et cum in qui qui. Ea cum labore quam sed. Aliquam nostrum consequuntur accusantium soluta neque nostrum quia. Harum in id et quos eum ut eum fugit. Omnis cumque veritatis dolorem quisquam omnis. Repellendus minus eaque mollitia. Iure culpa nihil optio necessitatibus. Et quia repellendus totam similique quidem rem. Autem officiis aperiam consequatur modi id ut.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(16, 'Sản phẩm voluptatem voluptas nesciunt', 'san-pham-voluptatem-voluptas-nesciunt-6786', 29000000, 40000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Quos ut error eum cum fugit ipsum inventore. Aut cupiditate exercitationem beatae dolor ut.', 'San pham voluptatem voluptas nesciunt Quos ut error eum cum fugit ipsum inventore. Aut cupiditate exercitationem beatae dolor ut.', 'Fugiat dolores ut eum sequi. Qui laboriosam saepe veniam expedita repudiandae officia. Debitis animi exercitationem reiciendis aperiam non unde. Tenetur vitae cum et facilis asperiores. Occaecati sit aliquid dolorem. Quasi voluptates tenetur temporibus sequi perferendis voluptates id. Rerum tempore quis amet sapiente quas quo aut. Eos laboriosam est sequi omnis sit aut. Dolore cum sunt dolorum illum aperiam qui.', 100, 0, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(17, 'Sản phẩm tempore et earum', 'san-pham-tempore-et-earum-2594', 6000000, 40000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Aut sequi ad quas ut dicta voluptas. Beatae quia suscipit ad expedita cum. Quo nulla quia ratione aspernatur non sint.', 'San pham tempore et earum Aut sequi ad quas ut dicta voluptas. Beatae quia suscipit ad expedita cum. Quo nulla quia ratione aspernatur non sint.', 'Provident rem quia voluptate omnis quia. Repudiandae non asperiores ex amet dolores. Saepe aut at et est voluptate ratione suscipit. Sit ut eaque consequatur tempora. Veritatis sit et iure eaque dolores exercitationem illum. Non beatae ad beatae minima voluptas quo fugiat.', 100, 0, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(18, 'Sản phẩm libero cumque laboriosam', 'san-pham-libero-cumque-laboriosam-4671', 14000000, 36000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Dolorem adipisci commodi sint accusamus a quis id dolor. Unde sit delectus mollitia autem ipsum labore.', 'San pham libero cumque laboriosam Dolorem adipisci commodi sint accusamus a quis id dolor. Unde sit delectus mollitia autem ipsum labore.', 'Necessitatibus ut ipsum facere autem similique aut et. Qui fugit dolorem tempora nulla et. Nemo reprehenderit neque est nihil at natus earum. Voluptate cupiditate similique vel hic consectetur laborum. Labore est consequuntur doloremque et aut hic recusandae. Qui et facere omnis quo. Culpa quis quidem quasi corrupti quia. Error nulla et quaerat sequi. Placeat ut consectetur quia. Voluptates aut sit consectetur qui consequuntur nesciunt.', 100, 1, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(19, 'Sản phẩm architecto accusamus non', 'san-pham-architecto-accusamus-non-1202', 26000000, 38000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Sed quos ipsa eligendi laudantium sed. Sed tempore dolorum neque maxime ullam aut rerum. Doloribus quia quos id minima magni aut omnis.', 'San pham architecto accusamus non Sed quos ipsa eligendi laudantium sed. Sed tempore dolorum neque maxime ullam aut rerum. Doloribus quia quos id minima magni aut omnis.', 'Vel dolor at sunt excepturi rem. Laboriosam repellendus est ut et reiciendis error. Culpa aperiam cumque dolores rerum similique ut. Doloribus enim nostrum velit beatae distinctio mollitia aliquam. Unde amet eaque odit cupiditate libero quibusdam architecto. Quis consequuntur maxime laboriosam consequatur rem provident velit. Est cum veritatis excepturi.', 100, 1, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(20, 'Sản phẩm labore cum fuga', 'san-pham-labore-cum-fuga-1358', 8000000, 33000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Sequi rerum dolore omnis et. Maxime aut nihil dicta nihil nihil enim.', 'San pham labore cum fuga Sequi rerum dolore omnis et. Maxime aut nihil dicta nihil nihil enim.', 'Architecto ut corporis sed quasi. Tenetur architecto libero tempore architecto autem officiis. Voluptate eius consectetur sed voluptatem molestiae ea maxime. Nulla voluptatem laboriosam veniam omnis atque repudiandae. Suscipit labore quia accusamus officiis. Dolor aut asperiores rerum accusantium quae. Dicta ab cumque sed. Ducimus temporibus non qui esse aut sed et totam. In cum voluptatem minus odit est unde exercitationem.', 100, 0, 2, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(21, 'Sản phẩm non neque nesciunt', 'san-pham-non-neque-nesciunt-7271', 11000000, 38000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Veniam et adipisci sit qui velit magni possimus quos. Quibusdam mollitia quia animi et. Quia eaque harum animi eaque.', 'San pham non neque nesciunt Veniam et adipisci sit qui velit magni possimus quos. Quibusdam mollitia quia animi et. Quia eaque harum animi eaque.', 'Incidunt accusantium unde ut beatae dolores qui tempore sequi. Et quae vero suscipit eveniet totam et tempore. Dolorum possimus asperiores quasi temporibus doloremque ut rerum. Aut laudantium assumenda qui et. Saepe ipsum deserunt est animi similique nesciunt unde. Dolor molestias quasi corporis sequi blanditiis odio eos. Consequatur molestiae id tenetur ducimus dignissimos porro occaecati nam. Quia vel mollitia qui tenetur amet. Omnis omnis beatae est qui quod.', 100, 0, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(22, 'Sản phẩm quos quia consectetur', 'san-pham-quos-quia-consectetur-2048', 24000000, 33000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Voluptatibus officiis ducimus ad et est consequatur. Vitae corporis sequi quaerat sit tenetur magnam omnis. Laudantium qui quia excepturi consectetur aperiam ducimus dolores.', 'San pham quos quia consectetur Voluptatibus officiis ducimus ad et est consequatur. Vitae corporis sequi quaerat sit tenetur magnam omnis. Laudantium qui quia excepturi consectetur aperiam ducimus dolores.', 'Totam voluptas reprehenderit et ex. Ut eum libero ea recusandae. Esse architecto est sed eius odio rem magni. Velit vitae possimus aperiam quasi. Nobis dignissimos autem nobis. Asperiores laboriosam blanditiis iure fuga debitis eum voluptatem. Dolores odit consequuntur fugiat dolore occaecati. Quis sed qui in quod. Nam iusto quos accusamus porro. Neque quaerat ipsam hic impedit corporis esse.', 100, 0, 3, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(23, 'Sản phẩm mollitia optio vel', 'san-pham-mollitia-optio-vel-8537', 21000000, 38000000, 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg', 'Id aperiam sunt est rerum sapiente et nemo sit. Quidem aut mollitia distinctio rem et similique ut odit.', 'San pham mollitia optio vel Id aperiam sunt est rerum sapiente et nemo sit. Quidem aut mollitia distinctio rem et similique ut odit.', 'Voluptatem consequatur omnis et quisquam qui nemo mollitia. Velit eligendi et sunt laudantium officiis. Deleniti omnis ad et at ea id. Veniam dolorum at ut odio. Ab reprehenderit et quos consequuntur natus natus. Vero corporis ipsum vel non quia. Enim magni quis et repellat non aperiam voluptates. Sit id et illum eaque quia. Voluptas rerum voluptatem labore omnis non ut.', 100, 1, 1, '2025-11-25 08:06:29', '2025-12-08 16:26:41'),
(40, 'CỰC MẠNH', 'cuc-manh', 34567, 7654, '/storage/products/uJ0SPQeG82ymjPUNwJRNN4cZpoTPXuzyFh4WagVA.jpg', NULL, 'CUC MANH ', NULL, 12, 1, 6, '2025-12-09 13:15:13', '2025-12-09 13:15:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `storage` varchar(50) DEFAULT NULL,
  `old_price` decimal(12,2) NOT NULL,
  `price` decimal(15,0) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color`, `storage`, `old_price`, `price`, `stock`, `sku`, `image`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 6, 'Cam vũ trụ', '2TB', 63990000.00, NULL, 10, '6-CAM-2TB', 'products/variants/60q2kL3jKHYpK9L0YvN3Tq0hTnfqHuRbkqBWHoaw.jpg', 0, '2025-12-09 12:28:00', '2025-12-09 13:52:43'),
(2, 6, 'Trắng', '128GB', 30000000.00, 31000, 10, 'SP6-TRN-128', 'products/variants/DipGHpUrDw72tyY1GB0SHVPHsC2zchoTcDYXJpbL.jpg', 0, '2025-12-09 12:43:45', '2025-12-09 14:44:19'),
(5, 6, 'đen', '128gb', 300000.00, NULL, 3, '6-đE-128gb', NULL, 0, '2025-12-09 12:55:00', '2025-12-09 13:52:43'),
(6, 6, 'vàng', '123', 123124000.00, NULL, 1, '6-Và-123', 'products/variants/8tyhP5Guttb6HhaaLihnrHRcp5R8LlSnnfT1pzQt.jpg', 0, '2025-12-09 13:28:41', '2025-12-09 13:52:43'),
(7, 6, 'Hồng', '1TB', 3000.00, 2000, 13, 'SP6-HNG-1', 'products/variants/vIOAQVZi75jCh86ooicgJ0nIQDOm4kOBLYMNiHf5.jpg', 1, '2025-12-09 13:52:43', '2025-12-09 13:52:43'),
(8, 6, 'sdfdsg', 'hgf', 50000.00, 30000, 12, 'SP6-SDF-', NULL, 0, '2025-12-09 14:14:35', '2025-12-09 14:33:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fpHXUpmUdUvu1sWrVyMmWSdG2QNbmyaMW7sPiCNZ', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT1pJeDBjRGtMRmNSZTB5aUppbnlUSzFUTFFBYmdPMngxSEZwcm14QiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly9sb2NhbGhvc3QvdGVjaHN0b3JlJTIwLSUyMENvcHkvcHVibGljL2FkbWluL3Byb2R1Y3RzIjtzOjU6InJvdXRlIjtzOjIwOiJhZG1pbi5wcm9kdWN0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1765288496),
('GMfete0Zb5l2VbhTSxtumwjcIIV0DNMIgfYEpIdZ', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTzZBZ3pPZWJDSlRlQjd1aXZvNVZUT3dBOW5veWEzVUg4NEF0emJZTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU5OiJodHRwOi8vbG9jYWxob3N0L3RlY2hzdG9yZS9wdWJsaWMvYWRtaW4vcHJvZHVjdHMvNi92YXJpYW50cyI7czo1OiJyb3V0ZSI7czoyOToiYWRtaW4ucHJvZHVjdHMudmFyaWFudHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiY2FydCI7YToyOntzOjk6InZhcmlhbnRfMSI7YTozOntzOjEwOiJwcm9kdWN0X2lkIjtzOjE6IjYiO3M6MTA6InZhcmlhbnRfaWQiO3M6MToiMSI7czo4OiJxdWFudGl0eSI7czoxOiIxIjt9czo5OiJ2YXJpYW50XzIiO2E6Mzp7czoxMDoicHJvZHVjdF9pZCI7czoxOiI2IjtzOjEwOiJ2YXJpYW50X2lkIjtzOjE6IjIiO3M6ODoicXVhbnRpdHkiO3M6MToiMSI7fX19', 1765291465);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `otp_code`, `otp_expires_at`, `phone`, `address`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin TechStore', 'admin@gmail.com', '$2y$12$CLs4GhRNMcCKnF1tV9mzQuUnrRVRdwNX7/i0KZc0/YV4OJ.hVWkNm', NULL, NULL, '0912345678', 'Hà Nội, Việt Nam', 'admin', NULL, NULL, '2025-11-25 08:06:29', '2025-11-25 08:06:29'),
(2, 'Lê Sỹ Bách', 'bachls.24it@vku.udn.vn', '$2y$12$NPlrlbRoE.LJY71uYCms9eBOM4i3KmMj7MNQSXEkNqQkMMEXOX9sa', '280467', '2025-12-05 10:02:41', '0333421432', 'NGhệ an', 'admin', NULL, 'Bckpm3hwEJdtnFBlEzKBOgcwbp6dF2vZpLrnlmXNZZrDcYp8PqdVctpqAuyZ', '2025-11-28 07:29:36', '2025-12-05 09:52:41'),
(5, 'BACHCP0', 'hackkinhden10@gmail.com', '$2y$12$tKFo96bAbYJaLFC5BfBQm.NCCsksQK45zEYx2NJfboewbRXn3XDc2', '861534', '2025-11-29 03:57:57', NULL, NULL, 'customer', NULL, NULL, '2025-11-29 01:34:26', '2025-11-29 03:47:57'),
(6, 'BACHCP10', 'bachfanscp10@gmail.com', '$2y$12$Z4.GpOvFzkTkonOS7SxwAOrJEYqF4gvh2RjIosmQAoB/QMc5TRCIu', '264381', '2025-12-08 08:42:30', NULL, NULL, 'customer', NULL, 'Qws2hdnvUXcozUL629uq7MEfXIfCCdHrPn1snv5qPajXD6PjTUrFARPSq2Ma', '2025-11-29 02:42:36', '2025-12-08 08:32:30'),
(7, 'dsfdf', 'bach1213@gmail.com', '$2y$12$I8U9kV1Nkq3ETLe0E8mSfewPSedhB6IrljTAxx34OXmmVkl459gMe', '158279', '2025-11-29 03:58:56', NULL, NULL, 'customer', NULL, NULL, '2025-11-29 03:19:52', '2025-11-29 03:48:56');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`),
  ADD KEY `cart_items_variant_id_foreign` (`variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_search_text_index` (`search_text`(768));

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_color_storage_index` (`product_id`,`color`,`storage`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
