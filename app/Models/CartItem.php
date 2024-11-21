<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_detail_id', 'quantity', 'original_price', 'price_after_discount'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'cart_item_discounts', 'cart_item_id', 'discount_id');
    }
    public function getCalculatePriceAfterDiscountsAttribute()
    {
        if ($this->discounts->isNotEmpty()) {
            $price_after_discounts = $this->productDetail->product->price;
            $values_discounts = 0;

            foreach ($this->discounts as $discount) {
                if ($discount->discount_application == 'general' && $discount->start_date <= now() && $discount->end_date >= now()) {
                    $values_discounts += $discount->value;
                }
            }

            $price_after_discounts -= $price_after_discounts * ($values_discounts / 100);
        }
        return $price_after_discounts;
    }

}
