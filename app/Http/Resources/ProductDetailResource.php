<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_detail_id' => $this->id,
            'quantity' => $this->quantity,
            'size' => SizeResource::make($this->size),
            'color' => ColorResource::make($this->color),
        ];
    }
}
