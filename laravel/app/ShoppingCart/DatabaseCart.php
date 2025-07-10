<?php

namespace App\ShoppingCart;

use App\Contracts\CanShop;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;

final class DatabaseCart implements CanShop
{
    use HasDefaultCart;

    public function __construct(protected User $user, protected SessionManager $session)
    {
        if ($this->session->has('cart')) {
            $carts = $this->session->get('cart', collect());

            $carts->each(function ($cart) {
                $this->addItem(
                    $cart->product_id,
                    $cart->quantity,
                    $cart->color_id,
                    $cart->storage_id
                );
            });

            $this->session->forget('cart');
        }
    }

    public function addItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->first();

        if (!$product) {
            return;
        }

        $cart_defauls = $this->getDefaultCart($quantity, $color_id, $storage_id);

        $cart = Cart::firstOrCreate(
            [
                'user_id' => $this->user->id,
                'product_id' => $product->id,
                'color_id' => $cart_defauls['color_id'],
                'storage_id' => $cart_defauls['storage_id'],
            ],
            [
                'quantity' => $quantity ?? 1,
            ]
        );

        if (!$cart->wasRecentlyCreated) {
            $max_addable_quantity = abs($product->stock - $cart_defauls['quantity']);

            if ($cart_defauls['quantity'] > $max_addable_quantity) {
                $cart_defauls['quantity'] = $max_addable_quantity;
            }

            $cart->increment('quantity', $cart_defauls['quantity']);
        }
    }


    public function removeItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->first();

        if (!$product) {
            return;
        }

        $cart_defauls = $this->getDefaultCart($quantity, $color_id, $storage_id);

        $cart = Cart::where([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'color_id' => $cart_defauls['color_id'],
            'storage_id' => $cart_defauls['storage_id'],
        ])->first();

        if ($cart) {
            if ($quantity && $cart->quantity > $quantity) {
                $cart->decrement('quantity', $quantity);
            } else {
                $cart->delete();
            }
        }
    }

    public function getItems(): Collection
    {
        return Cart::where('user_id', $this->user->id)
            ->with(['product', 'color', 'storage'])
            ->whereHas('product', function ($query) {
                $query->whereIsPurchasable();
            })
            ->get();
    }


    public function getItem(int $product_id, ?int $color_id, ?int $storage_id): ?Cart
    {
        $cart_defauls = $this->getDefaultCart(null, $color_id, $storage_id);

        return Cart::where([
            'user_id' => $this->user->id,
            'product_id' => $product_id,
            'color_id' => $cart_defauls['color_id'],
            'storage_id' => $cart_defauls['storage_id'],
        ])
        ->whereHas('product', function ($query) {
            $query->whereIsPurchasable();
        })
        ->first();
    }


    public function clearCart(): void
    {
        Cart::where('user_id', $this->user->id)->delete();
    }
}
