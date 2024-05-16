<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        try {
            $this->user = JWTAuth::parseToken($request->bearerToken())->authenticate();
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cart = $this->user->cart;
            if ($cart) {
                return new CartCollection($cart);
            } else {
                return response()->json([
                    'data' => array()
                ]);
            }
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
            $book_id = $request->post('book_id');
            $quantity = $request->post('quantity');
            $cart = $this->user->cart;
            if (empty($cart)) {
                $cart = $this->user->cart()->create();
                $cart->books()->attach($book_id, ['quantity' => $quantity]);
            } else {
                $book = $cart->books()->where('book_id', $book_id)->first();
                if (!$book) {
                    $cart->books()->attach($book_id, ['quantity' => $quantity]);
                } else {
                    $book->pivot->quantity += $quantity;
                    $book->pivot->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm sách vào giỏ hàng thành công!',
                'data' => new CartCollection($cart)
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
    public function show($id)
    {
        $cart = $this->user->cart->find($id);
        if ($cart) {
            return new CartCollection($cart);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy giỏ hàng!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $book_id = $request->post('book_id');
            $quantity = $request->post('quantity');

            $cart = $this->user->cart->find($id);
            $book = $cart->books()->where('book_id', $book_id)->first();

            if ($book) {
                $book->pivot->quantity += $quantity;

                if ($book->pivot->quantity <= 0) {
                    $cart->books()->detach($book_id);
                } else {
                    $book->pivot->save();
                }
            }

            if (count($cart->books) == 0) {
                $cart->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật giỏ hàng thành công!',
                'data' => new CartCollection($cart)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->books()->detach();
            $cart->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xoá giỏ hàng thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
