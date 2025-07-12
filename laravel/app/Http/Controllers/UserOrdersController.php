<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserOrdersController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function index()
    {
        $user = $this->request->user();

        $orders = $user->orders()->with([
            'items',
            'items.product'
        ])
        ->whereIsPaid()
        ->orderBy('created_at', 'desc')
        ->paginate(6);

        return view('user_profile.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show($uuid)
    {
        $user = $this->request->user();

        $order = $user->orders()->with([
            'items',
            'items.product'
        ])->where('uuid', $uuid)
        ->whereIsPaid()
        ->firstOrFail();

        return view('user_profile.orders.show', [
            'order' => $order,
        ]);
    }
}
