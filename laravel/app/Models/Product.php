<?php

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasSlug;

    public function sluggable() : array
    {
        return [
            'source' => 'name',
            'dest' => 'slug',
        ];
    }
}
