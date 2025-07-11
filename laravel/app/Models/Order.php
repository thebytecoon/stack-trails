<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    public static function booted(): void
    {
        static::creating(function (Order $model) {
            $model->uuid = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addItem(Cart $item): OrderItem
    {
        $order_item = OrderItem::create([
            'order_id' => $this->id,
            'product_id' => $item->product_id,
            'color_id' => $item->color_id,
            'storage_id' => $item->storage_id,
            'quantity' => $item->quantity,
            'unit_price' => $item->product->price,
            'total_price' => $item->product->price * $item->quantity,
        ]);

        $this->subtotal += $order_item->total_price;
        $this->save();

        return $order_item;
    }
}
