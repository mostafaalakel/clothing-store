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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'gender' => $this->gender, 
            'main_image' => $this->productImages->first()->image_url ?? null ,
            'price' => $this->price,
            'reviews' => ReviewResource::collection($this->reviews)
        ];
    }
}
