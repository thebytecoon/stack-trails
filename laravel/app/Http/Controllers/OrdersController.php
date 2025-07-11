<?php

namespace App\Http\Controllers;

use App\Models\ShippingOption;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show(string $uuid, Request $request)
    {
        $user = $request->user();

        $order = $user->orders()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $shipping_addresses = $user->addresses()
            ->orderByDesc('default')
            ->orderByDesc('id')
            ->get();

        $payment_methods = $user->payment_methods()
            ->orderByDesc('default')
            ->orderByDesc('id')
            ->get();

        $shipping_options = ShippingOption::orderBy('price')
            ->get();

        return view('checkout.order', [
            'order' => $order,
            'user' => $user,
            'shipping_addresses' => $shipping_addresses,
            'payment_methods' => $payment_methods,
            'shipping_options' => $shipping_options,
        ]);
    }

    public function update(string $uuid, Request $request)
    {
        if (!$request->input('shipping')) {
            return response()->json([
                'error' => 'Shipping option is required.',
            ], 422);
        }

        $user = $request->user();

        $order = $user->orders()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $shipping_option = ShippingOption::findOrFail($request->input('shipping'));

        $order->addShipping($shipping_option);

        return view('checkout._order_summary', [
            'order' => $order,
            'shipping_option' => $shipping_option,
        ]);
    }
}
