<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSummaryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function productDetails($product_id)
    {
        $productsDetail = Product::with([
            'productImages',
            'productDetails.size',
            'productDetails.color'
        ])->findOrFail($product_id);
        $productsDetail = ProductResource::make($productsDetail);
        return $this->retrievedResponse($productsDetail);
    }

    public function showProductOfCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)
            ->paginate(10);

        $products_resource = ProductSummaryResource::collection($products);

        return $products_resource->additional([
            'status' => 'success',
            'massage' => 'Products retrieved successfully'
        ]);
    }

    public function filterProduct(Request $request)
    {
        $query = Product::query();
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->where('price', '>=', $request->min_price)
                ->where('price', '<=', $request->max_price);
        }

        if ($request->has('color_id')) {
            $query->whereHas('productDetails', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });
        }

        if ($request->has('size_id')) {
            $query->whereHas('productDetails', function ($query) use ($request) {
                $query->where('size_id', $request->size_id);
            });
        }
        $products_resource = ProductSummaryResource::collection($query->paginate(10));

        return $products_resource->additional([
            'status' => 'success',
            'massage' => 'Products retrieved successfully'
        ]);
    }
}
