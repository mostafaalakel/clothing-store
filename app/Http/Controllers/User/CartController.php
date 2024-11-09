<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\CartItem;
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
            ->select('id', 'product_detail_id', 'quantity')
            ->with(['productDetail' => function ($query) {
                $query->select('id', 'product_id', 'size_id', 'color_id')
                    ->with(['product:id,name,price', 'size:id,name', 'color:id,name']);
            }])
            ->get();

        if ($cartItems->isEmpty()) {
            return $this->apiResponse('success', 'Your cart is empty');
        }


        $cartItems_resource = CartItemResource::collection($cartItems);

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->productDetail->product->price;
        });

        $totalItems = $cartItems->count();
        return $this->retrievedResponse([
            'total_Items' => $totalItems,
            'cart_Items' => $cartItems_resource,
            'total_Price' => $totalPrice . "$",
        ]);
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

        $checkIfProductFoundInCart = $cart->cartItems()
            ->where('product_detail_id', $request->product_detail_id)->first();

        if ($checkIfProductFoundInCart) {
            $checkIfProductFoundInCart->increment('quantity', $request->quantity);
        } else {

            CartItem::create([
                'cart_id' => $cart->id,
                'product_detail_id' => $request->product_detail_id,
                'quantity' => $request->quantity
            ]);
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

        $item = CartItem::findOrFail($cartItemId);
        $item->update([
            'quantity' => $request->quantity
        ]);

        return $this->updatedResponse(null, "Item updated successfully");
    }
}
