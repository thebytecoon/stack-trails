<?php

namespace App\Http\Controllers;

use App\Actions\PurchaseAction;
use App\Contracts\CanShop;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __invoke(
        string $uuid,
        Request $request,
        PurchaseAction $action,
        CanShop $cart
    ) {
        $validator = Validator::make(
            $request->all(),
            $this->rules()
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validator->messages()->all());
        }

        $user = $request->user();

        $order = $user->orders()
            ->where('uuid', $uuid)
            ->firstOrFail();

        try {
            $action->handle($order);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()
                ->with(
                    'error',
                    'An error occurred while processing your payment. Please try again later.'
                );
        }

        $cart->clearCart();

        return view('checkout.thanks', [
            'order' => $order,
        ]);
    }

    protected function rules() : array
    {
        return [
            'shipping_option' => 'required|exists:shipping_options,id',
            'address' => 'required',
            'payment_method' => 'required',
        ];
    }
}
