<?php

namespace App\Http\Controllers\Home;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = backpack_auth()->user();
            $book_id = $request->post('book_id');
            $quantity = $request->post('quantity');

            $cart = $user->cart;
            if (empty($cart)) {
                $cart = $user->cart()->create();
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
                'success' => true,
                'data' => view('carts.list', [
                    'cart' => $cart
                ])->render()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = backpack_auth()->user();
            $cart = $user->cart;
            $cart->books()->detach($id);
            if (count($user->cart->books) == 0) {
                $cart->delete();
            }
            return response()->json([
                'success' => true,
                'data' => view('carts.list', [
                    'user' => $user
                ])->render(),
                'message' => 'Xoá giỏ hàng thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
