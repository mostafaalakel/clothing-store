<?php /** @noinspection ALL */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['category_id', 'name', 'gender', 'image', 'description', 'price'];
    public $translatable = ['name', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discounts');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getAvgRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function getCalculatePriceAfterDiscountsAttribute()
    {
        if ($this->discounts->isNotEmpty()) {
            $price_after_discounts = $this->price;
            foreach ($this->discounts as $discount) {
                if ($discount->discount_application == 'general' && $discount->start_date <= now() && $discount->end_date >= now()) {
                    $price_after_discounts -= $price_after_discounts * ($discount->value / 100);
                }
            }
        }
        return $price_after_discounts;
    }
}
