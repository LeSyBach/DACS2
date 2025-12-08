<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Cần thiết để tạo slug
use App\Models\Category; // Đảm bảo Model Category tồn tại

class CategoryController extends Controller
{
    // Hàm phụ trợ để kiểm tra quyền Admin thủ công
    private function checkAdminPermission()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login');
        }
        return null;
    }

    /**
     * Hiển thị danh sách tất cả danh mục (READ).
     */
    public function index()
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }

        $categories = Category::orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục mới (CREATE).
     */
    public function create()
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        return view('admin.categories.create');
    }

    /**
     * Xử lý lưu danh mục mới vào DB (STORE).
     */
    public function store(Request $request)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string|max:255', // Giả định là class Font Awesome
        ]);
        
        // Tạo Slug từ tên danh mục
        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục mới thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục (EDIT).
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }

        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Xử lý cập nhật danh mục trong DB (UPDATE).
     */
    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }

        $category = Category::findOrFail($id);
        
        $validatedData = $request->validate([
            // Loại trừ chính danh mục đang sửa để cho phép trùng tên với bản thân nó
            'name' => 'required|string|max:255|unique:categories,name,'.$id, 
            'icon' => 'nullable|string|max:255',
        ]);

        // Tạo Slug mới nếu tên thay đổi
        if ($validatedData['name'] !== $category->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }
        
        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật danh mục thành công.');
    }

    /**
     * Xử lý xóa danh mục khỏi DB (DELETE).
     */
    public function destroy($id)
    {
        if ($redirect = $this->checkAdminPermission()) {
            return $redirect;
        }
        
        $category = Category::findOrFail($id);
        
        // KIỂM TRA: Nếu có sản phẩm liên quan, bạn cần xử lý (ví dụ: gán sản phẩm về null hoặc báo lỗi)
        // Hiện tại: Xóa danh mục (Nếu DB có onDelete cascade, nó sẽ tự xử lý)
        
        $category->delete(); 
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục thành công.');
    }
}