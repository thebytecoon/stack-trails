<div id="product-details" hx-swap-oob="true">
    <div class="mb-6">
        <h3 class="font-semibold mb-3">Color</h3>
        <div class="flex space-x-2">
            @foreach($available_colors as $color)
                <button 
                    class="w-12 h-12 rounded-full bg-[{{ $color->hex_code }}] border-2 border-gray-300 @if ($selected_color == $color->id) border-store-blue @else hover:border-store-blue @endif"
                    hx-get="{{ Request::fullUrlWithQuery(['color' => $color->id]) }}"
                    hx-target="#product-details"
                    hx-swap="outerHTML"
                >
                </button>
            @endforeach
        </div>
    </div>

    <div class="mb-6">
        <h3 class="font-semibold mb-3">Storage</h3>
        <div class="grid grid-cols-3 gap-3">
            @foreach($available_storage as $storage)
                <button 
                    class="border-2 @if ($selected_storage == $storage->id) border-store-blue bg-store-blue text-white @else border-gray-300 @endif px-4 py-2 rounded-lg text-sm font-medium"
                    hx-get="{{ Request::fullUrlWithQuery(['storage' => $storage->id]) }}"
                    hx-target="#product-details"
                    hx-swap="outerHTML"
                >
                    {{ $storage->name }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="mb-8">
        <h3 class="font-semibold mb-3">Quantity</h3>
        <div class="flex items-center space-x-3">
            <button 
                class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                hx-get="{{ Request::fullUrlWithQuery(['quantity' => $quantity ? $quantity - 1 : $quantity]) }}"
                hx-target="#product-details"
                hx-swap="outerHTML"
                @if ($quantity == 1) disabled @endif
            >-</button>
            <span class="text-lg font-medium">{{ $quantity }}</span>
            <button 
                class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                hx-get="{{ Request::fullUrlWithQuery(['quantity' => $quantity ? $quantity + 1 : $quantity]) }}"
                hx-target="#product-details"
                hx-swap="outerHTML"
                @if ($quantity == $product->stock)
                disabled
                title="Maximum stock reached"
                @endif
            >+</button>
        </div>
    </div>

    <div class="flex space-x-4 mb-8">
        <button 
            hx-post="{% url 'carts.add' product.id %}"
            hx-vals='{"display": "cart", "color": {{ $selected_color }}, "storage": {{ $selected_storage }}, "quantity": {{ $quantity }} }'
            class="disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 flex-1 bg-store-blue text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium"
            @if (!$can_add_to_cart) disabled @endif
            >
            Add to Cart
        </button>
        <button class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
    </div>
</div>
