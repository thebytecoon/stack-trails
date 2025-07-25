<?php

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeWhereIsPurchasable(Builder $query): Builder
    {
        return $query->whereIsSearchable()
            ->where('stock', '>', 0);
    }

    public function scopeWhereIsSearchable(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function scopeWhereIsFeatured(Builder $query, bool $featured = true) : Builder
    {
        return $query->where('featured', $featured);
    }

    public function image_url($width = 600, $height = 600)
    {
        return "{$this->image}?w={$width}&h={$height}&fit=crop&crop=center";
    }

    public function image_url_xs()
    {
        return $this->image_url(60, 60);
    }

    public function image_url_sm()
    {
        return $this->image_url(100, 100);
    }

    public function image_url_md()
    {
        return $this->image_url(300, 300);
    }

    public function sluggable(): array
    {
        return [
            'source' => 'name',
            'dest' => 'slug',
        ];
    }
}
