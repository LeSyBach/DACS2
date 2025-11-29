<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;  // 1. Gọi Model Sản phẩm
use App\Models\Category; // 2. Gọi Model Danh mục

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm nổi bật nhất (is_featured = 1)
        // $featuredProducts = Product::featured()->paginate(8);
        // $products = Product::allProducts()->paginate(12);
        $featuredProducts = Product::featured()->paginate(8, ['*'], 'featured_page');
        $products = Product::allProducts()->paginate(12, ['*'], 'all_page');

        // Lấy tất cả danh mục
        $categories = Category::all();

        // Gửi 2 biến này sang View 'home.index'
        return view('index', compact('featuredProducts','products', 'categories'));
    }
}