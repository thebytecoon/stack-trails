@extends('master')

@section('content')
<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @include('carts.partials.cart_page_items')

            <!-- Recommended Products -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recommended for you</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($recomended_products as $product)
                            @include('products.product_mini', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @include('carts.partials.cart_page_order_summary')
    </div>
</div>
@endsection