<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->input('q');

        if ($q == '') {
            return response()->json([
                'error' => 'Query parameter is required',
            ], 422);
        }

        $products = Product::query()
            ->whereIsSearchable()
            ->where(function ($query) use($q) {
                return $query->where('name', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhereRelation('category', 'name', 'like', '%' . $q . '%')
                    ->orWhereRelation('brand', 'name', 'like', '%' . $q . '%');
            })
            ->orderByDesc('id')
            ->take(5)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'error' => 'No products were found',
            ], 404);
        }

        return new ProductCollection($products);
    }
}
