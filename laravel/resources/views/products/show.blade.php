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
                    <div class="flex space-x-1">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review_avg)
                                <div class="star-rating text-2xl text-yellow-400">★</div>
                            @else
                                <div class="star-rating text-2xl text-gray-300">★</div>
                            @endif
                        @endfor
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
                    <button class="tab-button border-b-2 border-store-blue text-store-blue py-4 px-1 text-sm font-medium"
                            data-tab="description">
                        Description
                    </button>
                    <button class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium"
                            data-tab="specifications">
                        Specifications
                    </button>
                    <button class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium"
                            data-tab="reviews">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </nav>
            </div>
            <div class="mt-8">
                <!-- Description Tab Content -->
                <div id="description-tab" class="tab-content">
                    <div class="prose max-w-none">
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                <!-- Specifications Tab Content -->
                <div id="specifications-tab" class="tab-content hidden">
                    <div class="prose max-w-none">
                        @if($product->specifications && $product->specifications->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($product->specifications as $spec)
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="font-medium text-gray-700">{{ $spec->name }}:</span>
                                        <span class="text-gray-600">{{ $spec->value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No specifications available for this product.</p>
                        @endif
                    </div>
                </div>

                <!-- Reviews Tab Content -->
                <div id="reviews-tab" class="tab-content hidden">
                    <div class="space-y-6">
                        @if($product->reviews && $product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <div class="flex space-x-1 mr-3">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $review->rating)
                                                    <span class="text-yellow-400">★</span>
                                                @else
                                                    <span class="text-gray-300">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</span>
                                        <span class="text-gray-500 text-sm ml-2">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    @if($review->title)
                                        <h4 class="font-medium text-gray-900 mb-2">{{ $review->title }}</h4>
                                    @endif
                                    <p class="text-gray-600">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                        @endif
                    </div>
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

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active classes from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-store-blue', 'text-store-blue');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Add active classes to clicked button
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.classList.add('border-store-blue', 'text-store-blue');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show target tab content
                    const targetContent = document.getElementById(targetTab + '-tab');
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
@endsection
