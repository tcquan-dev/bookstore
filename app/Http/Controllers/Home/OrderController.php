<?php

namespace App\Http\Controllers\Home;

use Exception;
use App\Models\Order;
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
        $orders = $user->orders()->latest('updated_at')->get()->each(function ($order) {
            $order->books->each(function ($book) {
                $book->quantity = $book->pivot->quantity;
                $book->discount = $book->pivot->discount;
                $book->price = $book->pivot->price;
            });
        });
        return view('orders.index', compact('user', 'orders'));
    }
}
