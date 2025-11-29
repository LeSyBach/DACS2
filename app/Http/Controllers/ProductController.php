<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::allProducts()->paginate(12);
        return view('product', compact('products'));
    }
    // 1. Hàm hiển thị trang chi tiết
    public function detail($id)
    {
        // Tìm sản phẩm theo ID (nếu không thấy thì báo lỗi 404)
        $product = Product::findOrFail($id);
        return view('product.product-detail', compact('product'));
    }
}