<div 
    id="cart-offcanvas"
    hx-swap-oob="true"
    class="fixed top-0 right-0 h-full w-96 bg-white shadow-2xl transform @if (!$enabled) translate-x-full @endif transition-transform duration-300 ease-in-out z-50"
>
    <div class="flex flex-col h-full">
        <!-- Cart Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-store-dark">Shopping Cart</h2>
            <button onclick="toggleCart()" class="p-2 rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            <div id="cart-items">
                @forelse($carts as $cart)
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="bg-gray-100 rounded-lg w-16 h-16 flex items-center justify-center text-2xl">
                            <img src="{{ $cart->product->image_url_sm() }}" 
                                                alt="{{ $cart->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-sm">{{ $cart->product->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $cart->color->name }}, {{ $cart->storage->name }}</p>
                            <div class="flex items-center space-x-2 mt-2 relative">
                                <button hx-post="{{ route('carts.sub', [$cart->product->id]) }}"
                                        hx-target="#cart-offcanvas"
                                        hx-swap="outerHTML" 
                                        hx-vals='{"display": "offcanvas", "color": {{ $cart->color_id }}, "storage": {{ $cart->storage_id }}, "enabled": true }'
                                        hx-indicator="#loading-spinner-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-sm">
                                    @if ($cart->quantity == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 48 48">
                                            <path d="M 24 4 C 20.491685 4 17.570396 6.6214322 17.080078 10 L 10.238281 10 A 1.50015 1.50015 0 0 0 9.9804688 9.9785156 A 1.50015 1.50015 0 0 0 9.7578125 10 L 6.5 10 A 1.50015 1.50015 0 1 0 6.5 13 L 8.6386719 13 L 11.15625 39.029297 C 11.427329 41.835926 13.811782 44 16.630859 44 L 31.367188 44 C 34.186411 44 36.570826 41.836168 36.841797 39.029297 L 39.361328 13 L 41.5 13 A 1.50015 1.50015 0 1 0 41.5 10 L 38.244141 10 A 1.50015 1.50015 0 0 0 37.763672 10 L 30.919922 10 C 30.429604 6.6214322 27.508315 4 24 4 z M 24 7 C 25.879156 7 27.420767 8.2681608 27.861328 10 L 20.138672 10 C 20.579233 8.2681608 22.120844 7 24 7 z M 11.650391 13 L 36.347656 13 L 33.855469 38.740234 C 33.730439 40.035363 32.667963 41 31.367188 41 L 16.630859 41 C 15.331937 41 14.267499 40.033606 14.142578 38.740234 L 11.650391 13 z M 20.476562 17.978516 A 1.50015 1.50015 0 0 0 19 19.5 L 19 34.5 A 1.50015 1.50015 0 1 0 22 34.5 L 22 19.5 A 1.50015 1.50015 0 0 0 20.476562 17.978516 z M 27.476562 17.978516 A 1.50015 1.50015 0 0 0 26 19.5 L 26 34.5 A 1.50015 1.50015 0 1 0 29 34.5 L 29 19.5 A 1.50015 1.50015 0 0 0 27.476562 17.978516 z"></path>
                                        </svg>
                                    @else
                                    -
                                    @endif
                                </button>
                                
                                <span class="text-sm font-medium relative">{{ $cart->quantity }}</span>
                                <button
                                        hx-post="{{ route('carts.add', [$cart->product->id]) }}"
                                        hx-target="#cart-offcanvas"
                                        hx-vals='{"display": "offcanvas", "color": {{ $cart->color_id }}, "storage": {{ $cart->storage_id }}, "enabled": true }'
                                        hx-swap="outerHTML"
                                        hx-indicator="#loading-spinner-{{ $loop->index }}"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-sm"
                                >
                                        +
                                </button>
                                <img src="{% static 'spiner.gif' %}" alt="spiner" class="absolute top-1/2 left-9 transform -translate-x-1/2 -translate-y-1/2 htmx-indicator" style="max-width: 20px; max-height: 20px;" id="loading-spinner-{{ $loop->index }}">
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-store-blue">${{ $cart->total_price }}</p>
                            <button  hx-delete="{{ route('carts.destroy', [$cart->product->id]) }}"
                                        hx-target="#cart-offcanvas"
                                        hx-swap="outerHTML"
                                        hx-vals='{"display": "offcanvas", "color": {{ $cart->color_id }}, "storage": {{ $cart->storage_id }}, "enabled": true }'
                                        class="text-red-500 text-sm hover:underline">Remove</button>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-gray-600 text-center">Your cart is empty.</div>
                @endforelse
            </div>
        </div>

        <!-- Cart Footer -->
        <div class="border-t border-gray-100 p-6">
            <div class="space-y-4">
                <div class="flex justify-between text-sm">
                    <span>Subtotal:</span>
                    <span>${{ '0' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span class="text-store-blue">${{ '0' }}</span>
                    </div>
                </div>
                <a href="{% url 'carts.index' %}" class="w-full bg-store-blue text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium inline-block text-center" href="/checkout">
                    Checkout
                </a>
                <button onclick="toggleCart()" class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</div>