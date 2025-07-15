<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;

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
        $model = $this->request->user()->addresses()->make();

        return view('user_profile.addresses.create', [
            'model' => $model,
        ]);
    }

    public function store()
    {
        $user = $this->request->user();

        $validator = Validator::make($this->request->all(), $this->rules());

        if ($validator->fails()) {
            $this->request->session()->flashInput($this->request->input());

            $model = $this->request->user()->addresses()->make();

            return view('user_profile.addresses._form', [
                'errors' => $validator->errors(),
                'model' => $model,
            ]);
        }

        $validated = $validator->validated();

        $user->addresses()->create($validated);

        return new HtmlString("<div>
            Thank you! Your address has been created successfully.
        </div>");
    }

    public function edit($id)
    {
        $user = $this->request->user();

        $address = $user->addresses()->findOrFail($id);

        return view('user_profile.addresses.edit', [
            'model' => $address,
        ]);
    }

    public function update($id)
    {
        $user = $this->request->user();

        $address = $user->addresses()->findOrFail($id);

        $validator = Validator::make($this->request->all(), $this->rules());

        if ($validator->fails()) {
            $this->request->session()->flashInput($this->request->input());

            return view('user_profile.addresses._form', [
                'errors' => $validator->errors(),
                'model' => $address,
            ]);
        }

        $validated = $validator->validated();

        $address->update($validated);

        return new HtmlString("<div>
            Thank you! Your address has been updated successfully.
        </div>");
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

    protected function rules() : array
    {
        return [
            'name' => 'required|string|max:255',
            'names' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'default' => 'boolean',
        ];
    }
}
