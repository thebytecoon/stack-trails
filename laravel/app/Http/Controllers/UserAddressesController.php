<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function index()
    {
        $user = $this->request->user();

        $addresses = $user->addresses()->paginate(6);

        return view('user_profile.addresses.index', [
            'addresses' => $addresses,
        ]);
    }
}
