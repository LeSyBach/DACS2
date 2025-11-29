<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. TẠO TÀI KHOẢN ADMIN
        // Email: admin@gmail.com / Pass: 123456
        User::create([
            'name' => 'Admin TechStore',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0912345678',
            'address' => 'Hà Nội, Việt Nam',
            'role' => 'admin', // Quan trọng: Đánh dấu là Admin
        ]);

        // 2. TẠO DANH MỤC SẢN PHẨM
        $catPhone = Category::create([
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
            'icon' => 'fa-mobile-screen-button'
        ]);

        $catLaptop = Category::create([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'icon' => 'fa-laptop'
        ]);

        $catWatch = Category::create([
            'name' => 'Đồng hồ',
            'slug' => 'dong-ho',
            'icon' => 'fa-clock'
        ]);

        // 3. TẠO SẢN PHẨM MẪU
        
        // Sản phẩm 1: iPhone (Thuộc danh mục Điện thoại)
        Product::create([
            'name' => 'iPhone 15 Pro Max 256GB',
            'slug' => 'iphone-15-pro-max',
            'price' => 29990000,
            'old_price' => 33990000,
            'image' => 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
            'description' => 'Titan tự nhiên, chip A17 Pro cực mạnh, camera zoom quang học 5x.',
            'quantity' => 50,
            'is_featured' => true, // Sản phẩm nổi bật (để hiện trang chủ)
            'category_id' => $catPhone->id
        ]);

        // Sản phẩm 2: Macbook (Thuộc danh mục Laptop)
        Product::create([
            'name' => 'MacBook Pro 14 M3',
            'slug' => 'macbook-pro-14-m3',
            'price' => 52990000,
            'old_price' => 54990000,
            'image' => 'https://cdn.tgdd.vn/Products/Images/44/309830/macbook-pro-14-inch-m3-pro-18gb-512gb-thumb-600x600.jpg',
            'description' => 'Chip M3 mạnh mẽ, màn hình Liquid Retina XDR 120Hz siêu mượt.',
            'quantity' => 20,
            'is_featured' => true,
            'category_id' => $catLaptop->id
        ]);

        // Sản phẩm 3: Apple Watch (Thuộc danh mục Đồng hồ)
        Product::create([
            'name' => 'Apple Watch Series 9',
            'slug' => 'apple-watch-s9',
            'price' => 9990000,
            'old_price' => null,
            'image' => 'https://cdn.tgdd.vn/Products/Images/54/314662/apple-watch-s9-gps-41mm-xanh-den-thumb-600x600.jpg',
            'description' => 'Màn hình sáng gấp đôi, chip S9 SiP mới, thao tác chạm hai lần.',
            'quantity' => 100,
            'is_featured' => false, // Không nổi bật
            'category_id' => $catWatch->id
        ]);

        \App\Models\Product::factory(20)->create();
    }

}