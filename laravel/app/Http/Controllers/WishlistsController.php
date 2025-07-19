<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistsController extends Controller
{
    public function __invoke(int $product_id, Request $request)
    {
        $product = Product::whereIsSearchable()
            ->findOrFail($product_id);

        $user = $request->user();

        $user->wishlists()->toggle($product);

        return response()->json([
            'success' => true,
        ]);
    }
}
