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
        $data = [
            'cart_item_id' => $this->id,
            'product_detail_id' => $this->productDetail->id,
            'product_name' => $this->productDetail->product->getTranslation('name', app()->getLocale()),
            'product_description' => $this->productDetail->product->getTranslation('description', app()->getLocale()),
            'size' => SizeResource::make($this->productDetail->size),
            'color' => ColorResource::make($this->productDetail->color),
            'price' => $this->productDetail->product->price * $this->quantity  . "$",
            'quantity' => $this->quantity,
        ];

        if ($this->discounts->isNotEmpty()) {
            $data['price_after_discounts'] = $this->price_after_discounts  * $this->quantity . "$";
            $data['discounts'] = $this->discounts->map(function ($discount) {
                return [
                    'discount_id' => $discount->id,
                    'discount_name' => $discount->getTranslation('name', app()->getLocale()),
                    'discount_description' => $discount->getTranslation('description', app()->getLocale()),
                    'discount_value' => $discount->value . "%",
                    'start_date' => $discount->start_date,
                    'end_date' => $discount->end_date
                ];
            });
        }
        return $data;
    }
}
