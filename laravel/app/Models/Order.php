<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function scopeWhereIsPaid(Builder $query): Builder
    {
        return $query->whereStatus(OrderStatusEnum::PAID);
    }

    public function scopeWhereStatus(Builder $query, OrderStatusEnum $status): Builder
    {
        return $query->where('status', $status->value);
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
        $this->total = $this->subtotal + $this->delivery_price;
        $this->save();

        return $order_item;
    }

    public function addShipping(ShippingOption $shipping): void
    {
        $this->shipping_option_id = $shipping->id;
        $this->delivery_price = $shipping->price;
        $this->total = $this->subtotal + $this->delivery_price;
        $this->save();
    }

    public function shortCode(): string
    {
        return substr($this->uuid, 0, 8);
    }

    public function pay(): bool
    {
        if ($this->status != OrderStatusEnum::INITIAL->value) {
            return false;
        }

        $this->status = OrderStatusEnum::PAID->value;
        $result = $this->save();

        return $result;
    }
}
