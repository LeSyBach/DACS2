<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Hiển thị form đánh giá (trong modal hoặc page riêng)
     */
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đánh giá sản phẩm');
        }

        // Kiểm tra đã mua sản phẩm chưa
        if (!Review::userPurchasedProduct(Auth::id(), $productId)) {
            return redirect()->back()->with('error', 'Bạn cần mua sản phẩm này để có thể đánh giá');
        }

        // Kiểm tra đã đánh giá chưa
        if (Review::userReviewed(Auth::id(), $productId)) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi');
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Lưu đánh giá
     */
    public function store(Request $request, $productId)
    {
        // Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đánh giá sản phẩm');
        }

        // Validate
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá',
            'rating.min' => 'Đánh giá phải từ 1 đến 5 sao',
            'rating.max' => 'Đánh giá phải từ 1 đến 5 sao',
            'comment.max' => 'Nội dung đánh giá không được quá 1000 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kiểm tra đã mua sản phẩm chưa
        if (!Review::userPurchasedProduct(Auth::id(), $productId)) {
            return redirect()->back()->with('error', 'Bạn cần mua sản phẩm này để có thể đánh giá');
        }

        // Kiểm tra đã đánh giá chưa
        if (Review::userReviewed(Auth::id(), $productId)) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi');
        }

        // Tạo review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Tự động approve, hoặc 'pending' nếu muốn admin duyệt
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    /**
     * Kiểm tra user có thể đánh giá sản phẩm không (AJAX)
     */
    public function canReview($productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'can_review' => false,
                'reason' => 'not_logged_in',
                'message' => 'Vui lòng đăng nhập'
            ]);
        }

        if (!Review::userPurchasedProduct(Auth::id(), $productId)) {
            return response()->json([
                'can_review' => false,
                'reason' => 'not_purchased',
                'message' => 'Bạn cần mua sản phẩm này để đánh giá'
            ]);
        }

        if (Review::userReviewed(Auth::id(), $productId)) {
            return response()->json([
                'can_review' => false,
                'reason' => 'already_reviewed',
                'message' => 'Bạn đã đánh giá sản phẩm này'
            ]);
        }

        return response()->json([
            'can_review' => true,
            'message' => 'Bạn có thể đánh giá sản phẩm này'
        ]);
    }

    /**
     * Xóa đánh giá (chỉ chính chủ hoặc admin)
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Kiểm tra quyền
        if (Auth::id() !== $review->user_id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa đánh giá này');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Đã xóa đánh giá');
    }
}
