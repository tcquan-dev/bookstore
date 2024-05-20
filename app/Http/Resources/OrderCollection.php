<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'payment_method' => config('constants.payment_method.' . $this->payment_method),
            'payment_status' => config('constants.payment_status.' . $this->payment_status),
            'address' => new AddressCollection($this->address),
            'status' => $this->status->name,
            'total_price' => $this->total_price
        ];
    }
}
