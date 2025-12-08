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

    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // Nếu không có keyword, trả về tất cả sản phẩm
        if (empty($keyword)) {
            $products = Product::allProducts()->paginate(12);
        } else {
            // Tìm kiếm theo tên, mô tả
            $products = Product::where(function($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%");
                })
                ->paginate(12);
        }

        // Nếu là AJAX request, chỉ trả về phần product list
        if ($request->ajax() || $request->wantsJson()) {
            return view('home.product-all', compact('products'))->render();
        }

        // Nếu không phải AJAX, render full page
        return view('product', compact('products', 'keyword'));
    }

    // Hàm hiển thị trang chi tiết
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('product.product-detail', compact('product'));
    }
}