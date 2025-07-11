<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CreateOrder
{
    public function handle(User $user, Collection $carts): Order
    {
        DB::beginTransaction();

        try {
            $order = new Order();
            $order->user()->associate($user);
            $order->save();

            $carts->each(function ($cart) use ($order) {
                $order->addItem($cart);
            });
        } catch (\Throwable $th) {
            DB::rollBack();

            report($th);

            throw $th;
        }

        DB::commit();

        return $order->fresh();
    }
}
