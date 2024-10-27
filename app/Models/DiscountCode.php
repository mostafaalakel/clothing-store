<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
    protected $fillable = ['discount_id', 'code', 'used_count', 'expiration_date', 'is_active'];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
