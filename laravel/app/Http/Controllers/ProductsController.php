<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductStorage;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->whereIsSearchable()
            ->when($request->has('categories'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->whereIn('name', $request->array('categories', []));
                });
            })
            ->when($request->has('brands'), function ($query) use ($request) {
                $query->whereHas('brand', function ($q) use ($request) {
                    $q->whereIn('name', $request->array('brands', []));
                });
            })
            ->orderByDesc('id');

        $products = $query->paginate(15);

        $categories = Category::withCount([
            'products' => function ($query) {
                $query->whereIsSearchable()
                    ->when(request()->has('brands'), function ($query) {
                        $query->whereHas('brand', function ($q) {
                            $q->whereIn('name', request()->array('brands', []));
                        });
                    });
            }
        ])->get();

        $brands = Brand::withCount([
            'products' => function ($query) {
                $query->whereIsSearchable()
                    ->when(request()->has('categories'), function ($query) {
                        $query->whereHas('category', function ($q) {
                            $q->whereIn('name', request()->array('categories', []));
                        });
                    });
            }
        ])->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $slug, Request $request)
    {
        $product = Product::whereIsSearchable()
            ->where('slug', $slug)
            ->firstOrFail();

        $available_colors = Color::all();
        $available_storage = ProductStorage::all();

        $selected_color = null;
        if ($request->has('color')) {
            $selected_color = $request->integer('color');
        }

        $selected_storage = null;
        if ($request->has('storage')) {
            $selected_storage = $request->integer('storage');
        }

        $quantity = 1;
        if ($request->has('quantity') && $request->integer('quantity') > 0) {
            $quantity = $request->integer('quantity');
        }

        $can_add_to_cart = (
            $selected_color &&
            $selected_storage &&
            $quantity > 0 &&
            $quantity <= $product->stock
        );

        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $review_avg = $product->reviews()
            ->avg('rating');

        return view('products.show', [
            'product' => $product,
            'available_colors' => $available_colors,
            'available_storage' => $available_storage,
            'selected_color' => $selected_color,
            'selected_storage' => $selected_storage,
            'quantity' => $quantity,
            'can_add_to_cart' => $can_add_to_cart,
            'related_products' => $related_products,
            'review_avg' => $review_avg,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
