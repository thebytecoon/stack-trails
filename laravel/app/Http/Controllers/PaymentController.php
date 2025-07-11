<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __invoke(string $uuid, Request $request)
    {
        $user = $request->user();

        $order = $user->orders()->with([
                'items.product',
                'items.color',
                'items.storage',
            ])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('checkout.order', [
            'order' => $order,
            'user' => $user,
        ]);
    }
}
