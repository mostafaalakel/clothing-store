<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait ;
    public function productDetails($id)
    {
        $productsDetail = Product::with([
            'productImages',
            'productDetails.size',
            'productDetails.color'
        ])->findOrFail($id);
        $productsDetail = ProductResource::make($productsDetail);  
        return $this->retrievedResponse($productsDetail);
    }
}
