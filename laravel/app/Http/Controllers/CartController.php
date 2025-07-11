<?php

namespace App\Http\Controllers;

use App\Contracts\CanShop;
use App\Enums\CartDisplayEnum;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected Request $request,
        protected CanShop $cart
    ) {
    }

    public function index()
    {
        $carts = $this->cart->getItems();
        $recomended_products = Product::query()
            ->whereIsFeatured()
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('carts.index', [
            'carts' => $carts,
            'recomended_products' => $recomended_products,
        ]);
    }

    public function add(int $product_id)
    {
        if (!$this->request->has('display')) {
            return response()->json([
                'message' => 'Display type not specified.',
            ], 422);
        }

        try {
            $view = CartDisplayEnum::from($this->request->input('display'))->getView();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Invalid display type.',
            ], 422);
        }

        $quantity = $this->request->integer('quantity', 1);
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->addItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view($view, [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }

    public function sub(int $product_id)
    {
        if (!$this->request->has('display')) {
            return response()->json([
                'message' => 'Display type not specified.',
            ], 422);
        }

        try {
            $view = CartDisplayEnum::from($this->request->input('display'))->getView();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Invalid display type.',
            ], 422);
        }

        $quantity = $this->request->integer('quantity', 1);
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->removeItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view($view, [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }

    public function destroy(int $product_id)
    {
        if (!$this->request->has('display')) {
            return response()->json([
                'message' => 'Display type not specified.',
            ], 422);
        }

        try {
            $view = CartDisplayEnum::from($this->request->input('display'))->getView();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Invalid display type.',
            ], 422);
        }

        $quantity = 99999999;
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->removeItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view($view, [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }
}
