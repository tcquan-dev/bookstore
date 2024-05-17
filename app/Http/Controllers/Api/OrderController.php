<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use Tymon\JWTAuth\Exceptions\JWTException;


class OrderController extends Controller
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
        $orders = $this->user->orders;
        return OrderCollection::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            $cart = $this->user->cart;
            if ($cart) {
                $books = $cart->books;
                $total_price = 0;

                foreach ($books as $item) {
                    $total_price += $item->price;
                }

                $orderData = [
                    'user_id' => $this->user->id,
                    'address_id' => $cart->address_id,
                    'payment_method' => 1,
                    'status_id' => 1,
                    'total_price' => $total_price
                ];

                $order = Order::create($orderData);
                $cart->books()->detach();
                $cart->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Đặt hàng thành công!',
                    'data' => new OrderCollection($order)
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy giỏ hàng!'
                ], 404);
            }
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
        $order = $this->user->orders->find($id);
        if ( $order) {
            return new OrderCollection($order);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy đơn hàng!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
