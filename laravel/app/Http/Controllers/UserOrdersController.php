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
            'item',
            'item.product'
        ])->paginate(6);

        return view('user_profile.orders.index', [
            'orders' => $orders,
        ]);
    }
}
