<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;

class ReviewsController extends Controller
{
    public function __construct(protected Request $request)
    {
    }

    public function create(int $order_id, int $item_id)
    {
        $user = $this->request->user();

        $order = $user->orders()->findOrFail($order_id);

        $item = $order->items()->findOrFail($item_id);

        $product = $item->product;

        $model = $product->reviews()->make();

        return view('user_profile.orders.reviews.create', [
            'product' => $product,
            'order' => $order,
            'item' => $item,
            'model' => $model,
        ]);
    }

    public function store(int $order_id, int $item_id)
    {
        $user = $this->request->user();

        $order = $user->orders()->findOrFail($order_id);

        $item = $order->items()->findOrFail($item_id);

        $product = $item->product;

        $validator = Validator::make($this->request->all(), $this->rules());

        if ($validator->fails()) {
            $this->request->session()->flashInput($this->request->input());

            $model = $product->reviews()->make();

            return view('user_profile.orders.reviews._form_fields', [
                'errors' => $validator->errors(),
                'product' => $product,
                'model' => $model,
            ]);
        }

        $validated = $validator->validated();

        $product->reviews()->create([
            'user_id' => $user->id,
            'order_item_id' => $item->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
        ]);

        return new HtmlString("<div>
            Thank you for your review! It has been submitted successfully.
        </div>");
    }

    public function edit(int $order_id, int $item_id, int $review_id)
    {
        $user = $this->request->user();

        $review = $user->reviews()->findOrFail($review_id);

        $order = $user->orders()->findOrFail($order_id);

        $item = $order->items()->findOrFail($item_id);

        $product = $item->product;

        return view('user_profile.orders.reviews.edit', [
            'product' => $product,
            'order' => $order,
            'item' => $item,
            'model' => $review,
        ]);
    }

    public function update(int $order_id, int $item_id, int $review_id)
    {
        $user = $this->request->user();

        $review = $user->reviews()->findOrFail($review_id);

        $order = $user->orders()->findOrFail($order_id);

        $item = $order->items()->findOrFail($item_id);

        $product = $item->product;

        $validator = Validator::make($this->request->all(), $this->rules());

        if ($validator->fails()) {
            $this->request->session()->flashInput($this->request->input());

            return view('user_profile.orders.reviews._form_fields', [
                'errors' => $validator->errors(),
                'product' => $product,
                'model' => $review,
            ]);
        }

        $validated = $validator->validated();

        $review->update([
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
        ]);

        return new HtmlString("<div>
            Thank you for your review! It has been submitted successfully.
        </div>");
    }

    protected function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:2000',
        ];
    }
}
