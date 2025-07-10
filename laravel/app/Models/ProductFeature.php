<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
