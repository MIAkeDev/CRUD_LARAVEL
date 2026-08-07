<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $table = 'products'; //
    protected $fillable = ['name', 'price', 'category_id', 'currency_id'];

    protected $appends = ['formatted_price'];

  

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->currency?->symbol ?? 'S/') . ' ' . $this->price,
        );
    }
}
