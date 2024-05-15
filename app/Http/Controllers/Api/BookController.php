<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $conditions = [];

            if ($request->has('title')) {
                $conditions[] = ['title', $request->get('title')];
            }

            if ($request->has('author_id')) {
                $conditions[] = ['author_id', $request->get('author_id')];
            }

            if ($request->has('category_id')) {
                $conditions[] = ['category_id', $request->get('category_id')];
            }

            if ($request->has('sale_id')) {
                $conditions[] = ['sale_id', $request->get('sale_id')];
            }

            $books = Book::where($conditions)->get();

            return BookCollection::collection($books);
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
        try {
            $book = Book::findOrFail($id);
            return new BookCollection($book);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
