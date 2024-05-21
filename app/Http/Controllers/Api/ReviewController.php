<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Review;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewCollection;

class ReviewController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        try {
            $this->user = JWTAuth::parseToken($request->bearerToken())->authenticate();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/reviews');
            }

            $reviewData = [
                'user_id' => $this->user->id,
                'book_id' => $request->post('book_id'),
                'content' => $request->post('content'),
                'rate' => $request->post('rate'),
                'image_path' => $imagePath ?? ''
            ];

            $review = Review::create($reviewData);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo đánh giá thành công!',
                'data' => new ReviewCollection($review)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = $this->user->reviews->find($id);
        if ($review) {
            return new ReviewCollection($review);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy đánh giá!'
            ], 404);
        }
    }
}
