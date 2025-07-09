<?php

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;

    public function sluggable(): array
    {
        return [
            'source' => 'display_name',
            'dest' => 'name',
        ];
    }
}
