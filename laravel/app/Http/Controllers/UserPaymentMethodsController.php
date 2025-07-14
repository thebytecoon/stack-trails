<?php

namespace App\Http\Controllers;

use App\Enums\CardTypesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rule;

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
        return view('user_profile.payment_methods.create', [
            'types' => CardTypesEnum::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            $this->request->session()->flashInput($this->request->input());

            return view('user_profile.payment_methods._form_fields', [
                'errors' => $validator->errors(),
                'types' => CardTypesEnum::cases(),
            ]);
        }

        $data = $validator->validated();

        $user = $this->request->user();

        DB::transaction(function () use($user, $data) {
            $payment_method = $user->payment_methods()->create([
                'card_number' => $data['card_number'],
                'cardholder_name' => $data['cardholder_name'],
                'type' => $data['type'],
                'expiry_date' => $data['expiry_date'],
                'code' => $data['code'],
                'default' => $data['default'] ?? false,
            ]);

            if ($data['default']) {
                $user->payment_methods()
                    ->where('id', '!=', $payment_method->id)
                    ->update(['default' => false]);
            }
        });

        return new HtmlString("<div>
            Thanks for adding a new payment method! Your card has been successfully added.
        </div>");
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
        return [
            'card_number' => 'required|numeric|digits:16',
            'cardholder_name' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_map(fn ($item) => $item->value, CardTypesEnum::cases())),
            'expiry_date' => [
                'required',
                'date_format:Y-m',
                Rule::date()->afterOrEqual(today()),
            ],
            'code' => 'required|numeric|digits_between:3,4',
            'default' => 'boolean',
        ];
    }
}
