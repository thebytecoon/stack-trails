<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrder;
use App\Contracts\CanShop;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __invoke(Request $request, CreateOrder $action, CanShop $carts)
    {
        $user = $request->user();

        try {
            $order = $action->handle($user, $carts->getItems());
        } catch (\InvalidArgumentException $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'An error occurred while processing your order. Please try again later.');
        }

        return redirect()->route('orders.show', [$order->uuid]);
    }
}
