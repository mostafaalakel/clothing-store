<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSummaryResource extends JsonResource
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
            'gender' => $this->gender,
            'main_image' => $this->productImages->first()->image_url ?? null,
            'product_price' => $this->price . "$",
        ];

        if ($this->discounts->isNotEmpty()) {
            $data['price_after_discounts'] = $this->price_after_discounts . "$";
            $data['discounts'] = $this->discounts->map(function ($discount) {
                return [
                    'discount_id' => $discount->id,
                    'discount_name' => $discount->getTranslation('name', app()->getLocale()),
                    'discount_value' => $discount->value,
                ];
            });
        }

        return $data;
    }
}
