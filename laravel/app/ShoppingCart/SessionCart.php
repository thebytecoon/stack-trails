<?php

namespace App\ShoppingCart;

use App\Contracts\CanShop;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

final class SessionCart implements CanShop
{
    use HasDefaultCart;

    public function __construct(protected SessionManager $session)
    {
        if (!$this->session->has('cart')) {
            $this->session->put('cart', collect());
        }
    }

    public function addItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->firstOrFail();

        $cart_defaults = $this->getDefaultCart($quantity, $color_id, $storage_id);

        $cart = $this->session->get('cart')->firstWhere(function ($item) use ($product_id, $cart_defaults) {
            return $item->product_id == $product_id &&
                   $item->color_id == $cart_defaults['color_id'] &&
                   $item->storage_id == $cart_defaults['storage_id'];
        });

        if ($cart) {
            $max_addedable_quantity = abs($product->stock - $cart->quantity);

            if ($cart_defaults['quantity'] > $max_addedable_quantity) {
                $cart_defaults['quantity'] = $max_addedable_quantity;
            }

            $cart->quantity += $cart_defaults['quantity'];
        } else {
            $cart = new Cart([
                'product_id' => $product->id,
                'color_id' => $cart_defaults['color_id'],
                'storage_id' => $cart_defaults['storage_id'],
                'quantity' => $quantity ?? 1,
            ]);
            $this->session->push('cart', $cart);
        }
    }

    public function removeItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->firstOrFail();

        $cart_defaults = $this->getDefaultCart($quantity, $color_id, $storage_id);

        $cart = $this->session->get('cart')->firstWhere(function ($item) use ($product_id, $cart_defaults) {
            return $item->product_id == $product_id &&
                   $item->color_id == $cart_defaults['color_id'] &&
                   $item->storage_id == $cart_defaults['storage_id'];
        });

        if (!$cart) {
            return;
        }

        if ($cart_defaults['quantity'] < $cart['quantity']) {
            $cart['quantity'] -= $quantity;
        } else {
            $carts = $this->session->get('cart');

            $carts = $carts->filter(function ($item) use ($product_id, $cart_defaults) {
                return !($item->product_id == $product_id &&
                         $item->color_id == $cart_defaults['color_id'] &&
                         $item->storage_id == $cart_defaults['storage_id']);
            });

            $this->session->put('cart', $carts);
        }
    }


    public function getItems(): Collection
    {
        return $this->session->get('cart', collect());
    }

    public function getItem(int $product_id, ?int $color_id, ?int $storage_id): ?Cart
    {
        $cart = $this->session->get('cart')->firstWhere(function ($item) use ($product_id, $color_id, $storage_id) {
            return $item->product_id == $product_id &&
                   $item->color_id == $color_id &&
                   $item->storage_id == $storage_id;
        });

        return $cart ?? null;
    }


    public function clearCart(): void
    {
        $this->session->forget('cart');
        $this->session->put('cart', collect());
    }
}
