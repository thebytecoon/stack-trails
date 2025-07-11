<div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
    <img src="{{ $product->image_url_sm() }}"
        alt="{{ $product->name }}" class="w-full h-24 object-cover rounded-md">
    <h4 class="mt-2 text-sm font-medium text-gray-900">{{ $product->name }}</h4>
    <p class="text-sm text-gray-600">${{ $product->price }}</p>
    <button 
        hx-post="{{ route('carts.add', [$product->id]) }}"
        hx-target="#cart-offcanvas"
        hx-swap="outerHTML"
        hx-vals='{"display": "product_list"}'
        class="mt-2 w-full bg-store-blue text-white py-1 px-3 rounded-md text-sm hover:bg-blue-700">
        Add toCart
    </button>
</div>
