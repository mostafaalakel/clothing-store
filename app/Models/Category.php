<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , HasTranslations;
    protected $fillable = ['name','image'];
    public $translatable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
