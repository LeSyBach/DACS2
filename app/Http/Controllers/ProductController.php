<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){
        $query = Product::allProducts();
        
        // Filter theo category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Filter theo khoảng giá
        if ($request->has('price_range') && $request->price_range != '') {
            switch ($request->price_range) {
                case '1': // Dưới 5 triệu
                    $query->where('price', '<', 5000000);
                    break;
                case '2': // 5-10 triệu
                    $query->whereBetween('price', [5000000, 10000000]);
                    break;
                case '3': // 10-20 triệu
                    $query->whereBetween('price', [10000000, 20000000]);
                    break;
                case '4': // 20-30 triệu
                    $query->whereBetween('price', [20000000, 30000000]);
                    break;
                case '5': // Trên 30 triệu
                    $query->where('price', '>', 30000000);
                    break;
            }
        }
        
        // Sắp xếp
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }
        
        $products = $query->paginate(12);
        $categories = \App\Models\Category::all();
        
        return view('product', compact('products', 'categories'));
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
        $product = Product::with(['variants' => function($query) {
            $query->orderBy('is_default', 'desc')
                  ->orderBy('color')
                  ->orderBy('storage');
        }])->findOrFail($id);
        
        // Lấy variant mặc định hoặc variant đầu tiên
        $defaultVariant = $product->variants->where('is_default', true)->first() 
                       ?? $product->variants->first();
        
        return view('product.product-detail', compact('product', 'defaultVariant'));
    }
}