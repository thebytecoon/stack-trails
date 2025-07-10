<?php

namespace App\Contracts;

use App\Models\Cart;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface CanShop
{
    /**
     * Add an item to the cart.
     *
     * @param int $product_id
     * @param int $quantity
     * @param int|null $color_id
     * @param int|null $storage_id
     * @return void
     */
    public function addItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void;

    /**
     * Remove an item from the cart.
     *
     * @param int $product_id
     * @param int|null $quantity
     * @param int|null $color_id
     * @param int|null $storage_id
     * @return void
     */
    public function removeItem(int $product_id, ?int $quantity, ?int $color_id, ?int $storage_id): void;

    /**
     * Get all items in the cart.
     *
     * @return Collection<Cart>
     */
    public function getItems(): Collection;

    /**
     * Get the total price of items in the cart.
     *
     * @param int $product_id
     * @param int|null $color_id
     * @param int|null $storage_id
     *
     * @return null|Cart
     */
    public function getItem(int $product_id, ?int $color_id, ?int $storage_id): ?Cart;

    /**
     * Clear the cart.
     *
     * @return void
     */
    public function clearCart(): void;
}
