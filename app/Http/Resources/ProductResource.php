<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'product_id' => $this->id,
            'product_name' => $this->getTranslation('name', app()->getLocale()),
            'product_description' => $this->getTranslation('description', app()->getLocale()),
            'product_price' => $this->price . "$",
            'gender' => $this->gender,
            'product_details' => ProductDetailResource::collection($this->productDetails),
            'product_images' => ProductImageResource::collection($this->productImages),
            'product_rating' => $this->avg_rating
        ];
        if ($this->discounts->isNotEmpty()) {
            $data['price_after_discounts'] = $this->price_after_discounts . "$";
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
