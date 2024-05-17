<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $books = $this->books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'author' => isset($book->author) ? $book->author->name : '',
                'category' => isset($book->category) ? $book->category->name : '',
                'sale' => isset($book->sale) ? $book->sale->name : '',
                'rate' => $book->rate,
                'price' => $book->price,
                'quantity' => $book->pivot->quantity
            ];
        });
        
        return [
            'id' => $this->id,
            'address' => new AddressCollection($this->address),
            'books' => $books
        ];
    }
}
