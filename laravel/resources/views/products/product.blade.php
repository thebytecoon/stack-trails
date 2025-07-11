<div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
    <div class="bg-gray-100 h-64 flex items-center justify-center text-6xl group-hover:scale-105 transition-transform">
        <img src="{{ $product->image_url_md() }}"
            alt="{{ $product->name }}" class="object-cover rounded-lg">
    </div>
    <div class="p-6">
        <a href="{{ route('products.show', [$product->slug]) }}">
            <h3 class="font-bold text-xl mb-2">{{ $product->name }}</h3>
        </a>
        <p class="text-gray-600 mb-4">{{ $product->short_description }}</p>
        <div class="flex justify-between items-center">
            <span class="text-2xl font-bold text-store-blue">${{ $product->price }}</span>
            <button 
                hx-post="{{ route('carts.add', [$product->id]) }}"
                hx-target="#cart-offcanvas"
                hx-swap="outerHTML"
                hx-vals='{"display": "offcanvas"}'
                class="bg-store-dark text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                Add to Cart
            </button>
        </div>
    </div>
</div>