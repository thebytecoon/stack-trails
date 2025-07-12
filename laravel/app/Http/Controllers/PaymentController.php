<?php

namespace App\Http\Controllers;

use App\Actions\PurchaseAction;
use App\Contracts\CanShop;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;
use ValueError;

class PaymentController extends Controller
{
    public function __invoke(
        string $uuid,
        Request $request,
        PurchaseAction $action,
        CanShop $cart
    ) {
        $user = $request->user();

        $order = $user->orders()
            ->where('uuid', $uuid)
            ->firstOrFail();

        try {
            $action->handle($order, $request->all());
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()
                ->with('error', $e->validator->messages()->all());
        } catch (ValueError $e) {
            return redirect()->back()->withInput()
                ->with('error', $e->getMessage());
        } catch (Throwable $th) {
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
}
