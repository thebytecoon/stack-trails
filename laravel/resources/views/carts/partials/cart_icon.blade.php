<button 
    id="cart-button"
    hx-swap-oob="true"
    onclick="toggleCart()"
    class="p-2 rounded-full hover:bg-gray-100 relative"
>
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13h10m0 0v6a1 1 0 01-1 1H8a1 1 0 01-1-1v-6m8 0V9a1 1 0 00-1-1H8a1 1 0 00-1 1v4.01"></path>
    </svg>
    @if ($carts->count() > 0)
    <span id="cart-count" class="absolute -top-1 -right-1 bg-store-blue text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        {{ $carts->count() }}
    </span>
    @endif
</button>