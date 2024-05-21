<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = backpack_auth()->user();
        $books = Book::whereNotNull('sale_id')->latest('updated_at')->get();
        return view('sales.index', compact('user', 'books'));
    }
}
