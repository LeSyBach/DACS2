<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // Tự bịa ra một cái tên sản phẩm ngẫu nhiên
        $name = 'Sản phẩm ' . $this->faker->words(3, true); 
        
        return [
            'name' => $name,
            // Tự tạo slug từ tên (Ví dụ: san-pham-a-b-c-1234)
            'slug' => Str::slug($name) . '-' . rand(1000, 9999), 
            
            // Giá ngẫu nhiên từ 2 triệu đến 30 triệu
            'price' => $this->faker->numberBetween(2, 30) * 1000000, 
            
            // Giá cũ (lớn hơn giá mới 10%)
            'old_price' => $this->faker->numberBetween(31, 40) * 1000000,
            
            // Dùng tạm link ảnh iPhone thật để web hiện lên cho đẹp
            // (Vì ảnh random của Faker hay bị lỗi hiển thị)
            'image' => 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
            
            // Mô tả ngẫu nhiên vài dòng
            'description' => $this->faker->paragraph(2), 
            'content' => $this->faker->text(500),
            
            'quantity' => 100, // Kho luôn có 100 cái
            
            'is_featured' => $this->faker->boolean(30), // 30% cơ hội là sản phẩm HOT
            
            // Random Danh mục (ID từ 1 đến 3)
            // Vì ở Seeder tí nữa mình sẽ tạo sẵn 3 danh mục đầu tiên
            'category_id' => $this->faker->numberBetween(1, 3), 
        ];
    }
}