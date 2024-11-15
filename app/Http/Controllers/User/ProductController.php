<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSummaryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function productDetails($product_id)
    {
        $productWithDetails = Product::with([
            'discounts' => function ($query) {
                $query->where('discount_application', 'general')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            },
            'productImages',
            'productDetails.size',
            'productDetails.color'
        ])->findOrFail($product_id);

        $productWithDetails = $this->checkIfProductHasDiscountAndGetPriceAfterDiscounts($productWithDetails);
        $productWithDetails = ProductResource::make($productWithDetails);
        return $this->retrievedResponse($productWithDetails);
    }

    // show products which belongs to specific category
    public function showProductOfCategory($category_id)
    {
        $products = Product::with(['discounts' => function ($discountQuery) {
            $discountQuery->where('discount_application', 'general')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }])->where('category_id', $category_id)
            ->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $product = $this->checkIfProductHasDiscountAndGetPriceAfterDiscounts($product);
            return $product;
        });

        $products_resource = ProductSummaryResource::collection($products);
        return $products_resource->additional([
            'status' => 'success',
            'massage' => 'Products retrieved successfully'
        ]);
    }

    public function filterProduct(Request $request)
    {
        $query = Product::query()->with(['discounts' => function ($discountQuery) {
            $discountQuery->where('discount_application', 'general')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }]);

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

        $products = $query->paginate(10);
        $products->getCollection()->transform(function ($product) {
            $product = $this->checkIfProductHasDiscountAndGetPriceAfterDiscounts($product);
            return $product;
        });

        $products_resource = ProductSummaryResource::collection($products);
        return $products_resource->additional([
            'status' => 'success',
            'massage' => 'Products retrieved successfully'
        ]);
    }

    //get just products which have discount
    public function productDiscounts()
    {
        $productsDiscounts = Product::whereHas('discounts', function ($discountQuery) {
            $discountQuery->where('discount_application', 'general')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        })->with('discounts')->paginate(10);

        $productsDiscounts->getCollection()->transform(function ($product) {
            $product = $this->checkIfProductHasDiscountAndGetPriceAfterDiscounts($product);
            return $product;
        });

        $product_resource = ProductSummaryResource::collection($productsDiscounts);
        return $product_resource->additional([
            'status' => 'success',
            'massage' => 'Products retrieved successfully'
        ]);
    }

    public function checkIfProductHasDiscountAndGetPriceAfterDiscounts($product)
    {
        if ($product->discounts->isNotEmpty()) {
            $price_after_discounts = $product->calculate_price_after_discounts; // this is accessor to calculate_price_after_discounts in product model
            $product->setAttribute('price_after_discounts', $price_after_discounts);
        }
        return $product;
    }

}
