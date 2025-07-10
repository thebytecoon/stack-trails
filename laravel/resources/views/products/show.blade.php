@extends('master')

@section('content')
    <!-- Product Detail -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16">
            <!-- Product Images -->
            <div>
                <div class="bg-gray-100 rounded-2xl h-96 flex items-center justify-center text-8xl mb-4">
                    <img src="{{ $product->image_url_md() }}" alt="{{ $product->name }}">
                </div>
                <div class="grid grid-cols-4 gap-2">
                    <div class="bg-gray-100 rounded-lg h-20 flex items-center justify-center text-2xl cursor-pointer">
                        <img src="{{ $product->image_url_xs() }}" alt="{{ $product->name }}">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    </div>
                    <span class="ml-2 text-gray-600">({{ $product->reviews->count() }} reviews)</span>
                </div>

                <div class="text-3xl font-bold text-store-blue mb-6">${{ $product->price }}</div>

                @include('products/_product_details')

                <!-- Product Features -->
                @if ($product->features->count() > 0)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-semibold mb-4">Key Features</h3>
                        <ul class="space-y-2 text-gray-600">
                            @foreach ($product->features as $key_feature)
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $key_feature->description }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Description -->
        <div class="mt-16">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button class="border-b-2 border-store-blue text-store-blue py-4 px-1 text-sm font-medium">
                        Description
                    </button>
                    <button
                        class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                        Specifications
                    </button>
                    <button
                        class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </nav>
            </div>
            <div class="mt-8">
                <div class="prose max-w-none">
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-20">
            <h2 class="text-2xl font-bold mb-8">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($related_products as $related_product)
                    @include('products.product', ['product' => $related_product])
                @endforeach
            </div>
        </div>
    </div>
@endsection
