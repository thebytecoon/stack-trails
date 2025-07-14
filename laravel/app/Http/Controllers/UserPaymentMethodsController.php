<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        return view('user_profile.payment_methods.create');
    }

    public function store(Request $request)
    {

    }

    public function default($id)
    {
        $user = $this->request->user();

        DB::transaction(function () use ($user, $id) {
            $method = $user->payment_methods()->findOrFail($id);
            $user->payment_methods()->update(['default' => false]);
            $method->update(['default' => true]);
        });

        return view('user_profile.payment_methods._list', [
            'payment_methods' => $user->payment_methods,
        ]);
    }

    public function destroy($id)
    {
        $user = $this->request->user();

        $method = $user->payment_methods()->findOrFail($id);
        $method->delete();

        return view('user_profile.payment_methods._list', [
            'payment_methods' => $user->payment_methods,
        ]);
    }

    protected function rules(): array
    {
        return [];
    }
}
