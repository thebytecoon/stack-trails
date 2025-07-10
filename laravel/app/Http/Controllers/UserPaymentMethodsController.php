<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPaymentMethodsController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function index()
    {
        $user = $this->request->user();

        $payment_methods = $user->payment_methods;

        return view('user_profile.payment_methods.index', [
            'payment_methods' => $payment_methods,
        ]);
    }
}
