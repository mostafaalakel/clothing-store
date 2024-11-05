<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Node\Stmt\Return_;

class HomeController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $products = Product::get()->sortByDesc('avg_rating')->take(15);
        $products = ProductResource::collection($products);
        return $this->retrievedResponse($products , 'home page retrieved successfully');
    }
}
