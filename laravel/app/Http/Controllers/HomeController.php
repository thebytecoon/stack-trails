<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->wherePurchasable()
            ->whereFeatured(true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('home.index', [
            'products' => $products,
        ]);
    }
}
