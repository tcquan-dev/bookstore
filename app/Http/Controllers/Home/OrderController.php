<?php

namespace App\Http\Controllers\Home;

use Exception;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = backpack_auth()->user();
        $orders = $user->orders()->latest('updated_at')->get();
        return view('orders.index', compact('user', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = backpack_auth()->user();
        $cart = $user->cart;
        $addresses = $user->addresses;
        $address = $cart->address;
        if (!$address) {
            $address = $addresses->firstWhere('default', 1);
        }
        $total = 0;
        $cart->books->each(function ($book) use (&$total) {
            $price = $book->price;
            $quantity = $book->pivot->quantity;
            $discount = $book->sale ? ($price * $book->sale->value / 100) : 0;
            $book->discount = $discount;
            $book->quantity = $quantity;
            $book->total_price = ($price - $discount) * $quantity;
            $total += $book->total_price;
        });

        return view('orders.create', compact('user', 'cart', 'addresses', 'address', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $id = $request->post('id');
            $user = backpack_auth()->user();
            $cart = $user->cart->find($id);

            $orderData = [
                'user_id' => $user->id,
                'address_id' => $request->post('address_id'),
                'payment_method' => $request->post('payment_method'),
                'total_price' => $request->post('total_price')
            ];

            $order = Order::create($orderData);

            $cart->books->each(function ($book) use (&$order) {
                $order->books()->attach($book->id, [
                    'quantity' => $book->pivot->quantity,
                    'price' => $book->price,
                    'discount' => $book->sale ? ($book->price * $book->sale->value / 100) : 0
                ]);
            });

            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Thank you for ordering!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = backpack_auth()->user();
        $order = $user->orders->find($id);
        $addresses = $user->addresses;
        $address = $order->address;
        return view('orders.detail', compact('user', 'order', 'addresses', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = backpack_auth()->user();
            $order = $user->orders->find($id);

            if ($request->has('address_id')) {
                $order->update([
                    'address_id' => $request->post('address_id')
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!'
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
            $order = $user->orders->find($id);
            $status = Status::where('name', 'canceled')->first();
            $order->update([
                'status_id' => $status->id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Order canceled successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
