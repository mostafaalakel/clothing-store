<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory , HasTranslations;
    protected $fillable = ['value', 'discount_application', 'start_date', 'end_date'];
    public $translatable = ['name', 'description'];

    public function discountCodes()
    {
        return $this->hasMany(DiscountCode::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_discounts');
    }
}
