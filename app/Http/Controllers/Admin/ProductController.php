<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class ProductController extends Controller
{
    /**
     * Thêm lớp bảo vệ thủ công.
     */
    private function checkAdminPermission()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login');
        }
        return null;
    }

    /**
     * Hiển thị danh sách tất cả sản phẩm (READ - Index).
     */
    public function index()
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }

        // Tải trước quan hệ category để hiển thị tên danh mục
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(15); 

        return view('admin.products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới (CREATE).
     */
    public function create()
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Xử lý lưu sản phẩm mới vào DB (STORE).
     */
    public function store(Request $request)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);
        
        // 1. Xử lý ảnh và lưu vào Storage
        $imagePath = $request->file('image')->store('products', 'public');
        
        // 2. Tạo Slug
        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        // 3. Tạo sản phẩm
        Product::create(array_merge($validatedData, [
            'image' => Storage::url($imagePath),
            'is_featured' => $request->has('is_featured'),
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm mới thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm (EDIT).
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Xử lý cập nhật sản phẩm trong DB (UPDATE).
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        $product = Product::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'.$id, 
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // 1. Xử lý Slug nếu tên thay đổi
        if ($validatedData['name'] !== $product->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        // 2. Xử lý Ảnh mới (Nếu có)
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image)); // Xóa ảnh cũ
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = Storage::url($imagePath); // Lưu URL công khai mới
        } else {
            unset($validatedData['image']); // Không cập nhật nếu không có file mới
        }
        
        // 3. Cập nhật DB
        $product->update(array_merge($validatedData, [
            'is_featured' => $request->has('is_featured'),
            'description' => $request->description,
            'content' => $request->content,
            'old_price' => $request->old_price,
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm thành công.');
    }

    /**
     * Xử lý xóa sản phẩm khỏi DB (DELETE).
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        $product = Product::findOrFail($id);
        // Xóa ảnh khỏi storage
        // Storage::disk('public')->delete(str_replace('/storage/', 'public/', $product->image));
        Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm thành công.');
    }

    //search
    // public function ajaxSearch(Request $request){
    //     $query =Product::all()->orderBy('created_at','desc');
    //     if($request->filled())
    // }




}

 

