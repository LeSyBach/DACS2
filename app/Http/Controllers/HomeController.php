<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::featured()->paginate(8, ['*'], 'featured_page');
        $products = Product::allProducts()->paginate(12, ['*'], 'all_page');
        $categories = Category::withCount('products')->get();

        return view('index', compact('featuredProducts', 'products', 'categories'));
    }

    // Search cho trang chủ
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        if (empty($keyword)) {
            // Kiểm tra referer để redirect đúng trang
            $referer = $request->headers->get('referer');
            if (str_contains($referer, '/products')) {
                return redirect()->route('product');
            }
            return redirect()->route('index');
        }

        // SỬ DỤNG SMART SEARCH
        $featuredProducts = Product::featured()
            ->smartSearch($keyword)
            ->paginate(8, ['*'], 'featured_page');

        $products = Product::smartSearch($keyword)
            ->paginate(12, ['*'], 'all_page');

        $categories = Category::withCount('products')->get();

        // XỬ LÝ AJAX REQUEST
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'featured' => view('home.featured-products', compact('featuredProducts'))->render(),
                'all' => view('home.product-all', compact('products'))->render(),
                'keyword' => $keyword
            ]);
        }

        // NORMAL REQUEST - Tự động chọn view đúng
        $referer = $request->headers->get('referer');
        $view = (str_contains($referer, '/products')) ? 'product' : 'index';
        
        return view($view, compact('featuredProducts', 'products', 'categories', 'keyword'));
    }
}