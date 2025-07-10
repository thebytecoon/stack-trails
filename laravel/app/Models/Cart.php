<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'color_id',
        'storage_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function storage()
    {
        return $this->belongsTo(ProductStorage::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->product->price * $this->quantity;
    }
}
