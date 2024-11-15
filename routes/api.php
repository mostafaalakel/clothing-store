<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home' , [HomeController::class , 'index'])->middleware('setLocale');

// Routes for Users auth
Route::group(["prefix" => 'user'], function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);
    Route::middleware('auth:user')->post('logout', [UserAuthController::class, 'logout']);
    Route::middleware('auth:user')->post('refresh', [UserAuthController::class, 'refresh']);
});
Route::get('/auth/redirect/{provider}', [UserAuthController::class, 'redirectToProvider']);
Route::get('/auth/callback/{provider}', [UserAuthController::class, 'handleProviderCallback']);



// Routes for Admins auth
Route::group(['prefix' => 'admin'], function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::middleware('auth:admin')->post('logout', [AdminAuthController::class, 'logout']);
    Route::middleware('auth:admin')->post('refresh', [AdminAuthController::class, 'refresh']);
});

Route::group(['prefix' => 'cart' , 'middleware' => ['auth:user' , 'setLocale'] ] , function(){
    Route::get('showCart', [CartController::class, 'ShowCartItems']);
    Route::post('addToCart', [CartController::class, 'addToCart']);
    Route::delete('deleteItem/{cartItem_id}', [CartController::class, 'deleteItem']);
    Route::patch('updateItem/{cartItem_id}', [CartController::class, 'updateItemQuantity']);
});


Route::group(['prefix' => 'product' , 'middleware' => 'setLocale' ] , function(){
    Route::get('/filter' , [ProductController::class ,'filterProduct']);
    Route::get('/discount' , [ProductController::class ,'productDiscounts']);
    Route::get('/{product_id}' , [ProductController::class ,'productDetails']);
    Route::get('/category/{category_id}' , [ProductController::class ,'showProductOfCategory']);
});

Route::post('/review/addReview' , [ReviewController::class ,'addReview'])->middleware('auth:user');

