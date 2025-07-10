<?php

namespace App\Http\Controllers;

use App\Contracts\CanShop;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected Request $request,
        protected CanShop $cart
    ) {
    }

    public function add(int $product_id)
    {
        $quantity = $this->request->integer('quantity', 1);
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->addItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view('carts.offcanvas_htmx', [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }

    public function sub(int $product_id)
    {
        $quantity = $this->request->integer('quantity', 1);
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->removeItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view('carts.offcanvas_htmx', [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }

    public function destroy(int $product_id)
    {
        $quantity = 99999999;
        $color_id = $this->request->integer('color', null);
        $storage_id = $this->request->integer('storage', null);
        $enabled = $this->request->boolean('enabled', false);

        try {
            $this->cart->removeItem($product_id, $quantity, $color_id, $storage_id);
        } catch (\Throwable $th) {

        }

        $carts = $this->cart->getItems();

        return view('carts.offcanvas_htmx', [
            'carts' => $carts,
            'enabled' => $enabled,
        ]);
    }
}
