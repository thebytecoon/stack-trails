<?php

namespace App\ShoppingCart;

use App\Models\Color;
use App\Models\ProductStorage;

trait HasDefaultCart
{
    protected function getDefaultCart(?int $quantity, ?int $color_id, ?int $storage_id): array
    {
        if (is_null($quantity) || $quantity < 1) {
            $quantity = 1;
        }

        if (is_null($color_id) || !Color::where('id', $color_id)->exists()) {
            $color_id = Color::first()->id;
        }

        if (is_null($storage_id) || !ProductStorage::where('id', $storage_id)->exists()) {
            $storage_id = ProductStorage::first()->id;
        }

        return [
            'color_id' => $color_id,
            'storage_id' => $storage_id,
            'quantity' => $quantity,
        ];
    }
}
