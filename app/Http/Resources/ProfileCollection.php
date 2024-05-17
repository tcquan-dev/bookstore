<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'avatar' => $this->avatar ?? '',
            'gender' => intval($this->gender),
            'phone_number' => $this->phone_number ?? '',
            'address' => $this->address ?? '',
            'bio' => $this->bio ?? ''
        ];
    }
}
