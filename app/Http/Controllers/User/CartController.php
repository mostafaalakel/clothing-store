<?php

namespace App\Http\Controllers\User;

use App\Models\CartItem;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CartItemResource;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use ApiResponseTrait;

    public function ShowCartItems()
    {
        $cart = Auth::guard('user')->user()->cart;
        $cartItems = $cart->cartItems()
            ->with(['productDetail.product', 'productDetail.size', 'productDetail.color', 'discounts'])
            ->get();

        if ($cartItems->isEmpty()) {
            return $this->apiResponse('success', 'Your cart is empty');
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->discounts->isNotEmpty()) {
                $price_after_discounts = $cartItem->calculate_price_after_discounts; // this is accessor to calculate_price_after_discounts in cartItem model
                $cartItem->setAttribute('price_after_discounts', $price_after_discounts);
            }
        }
        $totalPrice = $cartItems->sum(function ($item) {
            if ($item->discounts->isNotEmpty()) {
                return $item->calculate_price_after_discounts * $item->quantity;
            } else return $item->prodctDetail->product->price * $item->quantity;
        });

        $totalItems = $cartItems->count();
        $cartItems_resource = CartItemResource::collection($cartItems)
            ->additional([
                'total_price' => $totalPrice . "$",
                'total_items' => $totalItems,
            ]);
        return $cartItems_resource->response()->setStatusCode(200, 'cart returned successfully');
    }

    public function addToCart(Request $request)
    {
        $rules = [
            'product_detail_id' => 'required|exists:product_details,id',
            'quantity' => 'required|integer|min:1'
        ];

        $validate = Validator::make($request->only('product_detail_id', 'quantity'), $rules);
        if ($validate->fails()) {
            return $this->validationErrorResponse($validate->errors());
        }
        $cart = Auth::guard('user')->user()->cart;


        $product = ProductDetail::find($request->product_detail_id)->product;

        $checkIfProductFoundInCart = $cart->cartItems()
            ->where('product_detail_id', $request->product_detail_id)->first();

        if ($checkIfProductFoundInCart) {
            $oldQuantity = $checkIfProductFoundInCart->quantity;
            $totalQuantity = $oldQuantity + $request->quantity;
            $checkIfProductFoundInCart->update([
                'quantity' => $totalQuantity
            ]);

        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_detail_id' => $request->product_detail_id,
                'quantity' => $request->quantity
            ]);

            $productDiscounts = $product->discounts()->where('discount_application', 'general')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->get();

            if ($productDiscounts->isNotEmpty()) {
                $cartItem->discounts()->attach($productDiscounts->pluck('id')->toArray());
            }
        }
        return $this->createdResponse(null, "Item added to cart successfully");
    }

    public function deleteItem($cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);
        $item->delete();

        return $this->deletedResponse("Item deleted from cart successfully");
    }

    public function updateItemQuantity(Request $request, $cartItemId)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $validate = Validator::make($request->only('quantity'), $rules);
        if ($validate->fails()) {
            return $this->validationErrorResponse($validate->errors());
        }

        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->update([
            'quantity' => $request->quantity
        ]);
        return $this->updatedResponse(null, "Item updated successfully");
    }

    public function codeDiscount(Request $request)
    {

    }
}
