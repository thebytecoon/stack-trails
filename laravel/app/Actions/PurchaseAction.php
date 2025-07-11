<?php

namespace App\Actions;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

final class PurchaseAction
{
    public function handle(Order $order): void
    {
        DB::beginTransaction();

        try {
            $order = Order::where('id', $order->id)
                ->with([
                    'items.product' => function ($query) {
                        $query->lockForUpdate();
                    },
                ])
                ->lockForUpdate()
                ->firstOrFail();

            $items = $order->items;

            foreach ($items->groupBy('product_id') as $group_items) {
                $used_stock = $group_items->sum('quantity');

                $product = $group_items->first()->product;

                if ($product->stock < $used_stock) {
                    throw new \Exception('Not enough stock for product: ' . $product->name);
                }
            }

            foreach ($items as $item) {
                $product = $item->product;

                $product->decrement('stock', $item->quantity);
            }

            $order->status = OrderStatusEnum::PAID;
            $order->save();
        } catch (\Throwable $th) {
            DB::rollBack();

            report($th);

            throw $th;
        }

        DB::commit();
    }
}
