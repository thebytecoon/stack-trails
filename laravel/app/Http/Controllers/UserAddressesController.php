<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAddressesController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function index()
    {
        $user = $this->request->user();

        $addresses = $user->addresses;

        return view('user_profile.addresses.index', [
            'addresses' => $addresses,
        ]);
    }

    public function create()
    {
        $user = $this->request->user();
        $form_action = route('user.addresses.store');

        return view('user_profile.addresses.create', [
            'user' => $user,
            'form_action' => $form_action,
        ]);
    }

    public function store()
    {
        $user = $this->request->user();

        $data = $this->request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
        ]);

        $user->addresses()->create($data);

        return redirect()->route('user.addresses.index')
            ->with('success', 'Address added successfully.');
    }

    public function edit($id)
    {
        $user = $this->request->user();

        $address = $user->addresses()->findOrFail($id);

        $form_action = route('user.addresses.update', [$address->id]);

        return view('user_profile.addresses.edit', [
            'user' => $user,
            'form_action' => $form_action,
        ]);
    }

    public function update($id)
    {
        $user = $this->request->user();

        $data = $this->request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
        ]);

        $address = $user->addresses()->findOrFail($id);
        $address->update($data);

        return redirect()->route('user.addresses.index')
            ->with('success', 'Address updated successfully.');
    }

    public function setDefault($id)
    {
        $user = $this->request->user();

        $address = $user->addresses()->findOrFail($id);

        DB::transaction(function () use ($user, $address) {
            $user->addresses()->update(['default' => false]);
            $address->default = true;
            $address->save();
        });

        $addresses = $user->addresses()->get();

        return view('user_profile.addresses._list', [
            'addresses' => $addresses,
        ]);
    }

    public function destroy($id)
    {
        $user = $this->request->user();

        $address = $user->addresses()->findOrFail($id);
        $address->delete();

        $addresses = $user->addresses()->get();

        return view('user_profile.addresses._list', [
            'addresses' => $addresses,
        ]);
    }
}
