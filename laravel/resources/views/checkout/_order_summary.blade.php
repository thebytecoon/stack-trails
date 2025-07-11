<!-- Order Summary -->
<div 
    id="checkout-order-summary"
    hx-swap-oob="true"
    class="lg:col-span-1">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-24">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Order Summary</h3>
        </div>
        
        <!-- Order Items -->
        <div class="p-6 border-b border-gray-200">
            <div class="space-y-4">
                @foreach($order->items as $order_item)
                <div class="flex items-center space-x-3">
                    <img src="{{ $order_item->product->image_url_sm() }}" 
                            alt="iPhone 15 Pro" class="w-12 h-12 object-cover rounded-lg">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900">{{ $order_item->product->name }}</h4>
                        <p class="text-xs text-gray-500">Natural Titanium, 256GB</p>
                    </div>
                    <span class="text-sm font-medium">${{ $order_item->total_price }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Price Breakdown -->
        <div class="p-6 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span>${{ $order->subtotal }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Shipping</span>
                @if ($order->delivery_price == 0)
                <span class="text-green-600">Free</span>
                @else
                <span class="text-gray-600">${{ $order->delivery_price }}</span>
                @endif
            </div>
            <hr class="border-gray-200">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total</span>
                <span>${{ $order->total }}</span>
            </div>
            
            <!-- Place Order Button -->
            <button onclick="placeOrder()" 
                    class="w-full bg-store-blue text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors mt-6">
                Place Order
            </button>

            <!-- Security Notice -->
            <div class="mt-4 flex items-center justify-center space-x-2 text-sm text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                <span>256-bit SSL encrypted</span>
            </div>
        </div>
    </div>
</div>