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
        return [
            'product_id' => $this->id,
            'name'  => $this->getTranslation('name' , app()->getLocale()),
            'description' => $this->getTranslation('description' , app()->getLocale()),
            'price' =>  $this->price,
            'gender' => $this ->gender ,
            'product_details'=> ProductDetailResource::collection($this->productDetails) ,
            'product_images' => ProductImageResource::collection($this-> productImages) , 
            'rating' => $this->avg_rating
        ];
    }
}
