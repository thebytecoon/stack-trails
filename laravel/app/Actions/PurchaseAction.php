<?php

namespace App\Actions;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ValueError;

final class PurchaseAction
{
    public function handle(Order $order, array $order_data): void
    {
        $this->validateData($order_data);

        $user = $order->user;
        $address = $user->addresses()->findOrFail($order_data['address']);

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

            $order->names = $address->names;
            $order->address_1 = $address->address_line_1;
            $order->address_2 = $address->address_line_2;
            $order->country = $address->country;
            $order->city = $address->city;
            $order->zip_code = $address->postal_code;
            $order->phone = $address->phone_number;

            $items = $order->items;

            foreach ($items->groupBy('product_id') as $group_items) {
                $used_stock = $group_items->sum('quantity');

                $product = $group_items->first()->product;

                if ($product->stock < $used_stock) {
                    throw new ValueError('Not enough stock for product: ' . $product->name);
                }
            }

            foreach ($items as $item) {
                $product = $item->product;

                $product->decrement('stock', $item->quantity);
            }

            $order->pay();
        } catch (\Throwable $th) {
            DB::rollBack();

            report($th);

            throw $th;
        }

        DB::commit();
    }

    protected function validateData(array $data): void
    {
        Validator::make(
            $data,
            $this->rules()
        )->validate();
    }

    public function rules(): array
    {
        return [
            'shipping_option' => 'required|exists:shipping_options,id',
            'address' => 'required',
            'payment_method' => 'required',
        ];
    }
}
