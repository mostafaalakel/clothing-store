<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Node\Stmt\Return_;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::get()->sortByDesc('avg_rating');
        $products = ProductResource::collection($products);
        return $products;
    }
}
