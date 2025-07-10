<?php

namespace App\ShoppingCart;

use App\Contracts\CanShop;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

final class DatabaseCart implements CanShop
{
    use HasDefaultCart;

    public function __construct(protected User $user)
    {
    }

    public function addItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->firstOrFail();

        $cart_defauls = $this->getDefaultCart($quantity, $color_id, $storage_id);

        $cart = Cart::firstOrCreate([
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
            $cart->increment('quantity', $quantity ?? 1);
        }
    }


    public function removeItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void
    {
        $product = Product::where('id', $product_id)
            ->whereIsPurchasable()
            ->firstOrFail();

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
