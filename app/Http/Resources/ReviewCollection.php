<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => intval($this->user_id),
            'book_id' => intval($this->book_id),
            'content' => $this->content ?? '',
            'rate' => $this->rate,
            'image_path' => $this->image_path ?? '',
        ];
    }
}
