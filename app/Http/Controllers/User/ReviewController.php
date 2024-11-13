<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    use ApiResponseTrait;

    public function addReview(Request $request)
    {
        $existingReview = Review::where('product_id', $request->product_id)
            ->where('user_id',  Auth::guard('user')->user()->id)
            ->first();

        if ($existingReview) {
            $existingReview->delete();
        }

        $rules = [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|min:1|max:5',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->validationErrorResponse($validate->errors());
        }

        $user_id = Auth::guard('user')->user()->id;
        Review::create([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
        ]);

        return $this->createdResponse(null, "Review added successfully");
    }
}
