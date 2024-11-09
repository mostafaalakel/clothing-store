<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_detail_id' => $this->productDetail->id,
            'name' => $this->productDetail->product->getTranslation('name' , app()->getLocale()),
            'size' => SizeResource::make($this->productDetail->size),
            'color' => ColorResource::make($this->productDetail->color),
            'price' => $this->productDetail->product->price,
            'quantity' => $this->quantity
        ];
    }
}
