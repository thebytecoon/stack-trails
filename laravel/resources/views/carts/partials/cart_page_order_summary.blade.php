<!-- Order Summary -->
<div 
    id="order-page-summary"
    hx-swap-oob="true" 
    class="lg:col-span-1">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-24">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Order Summary</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal ({{ $carts->count() }} items)</span>
                <span class="font-medium">${{ $carts->sum('total_price') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Shipping</span>
                <span class="font-medium text-green-600">Free</span>
            </div>
            <hr class="border-gray-200">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total</span>
                <span>${{ $carts->sum('total_price') }}</span>
            </div>
            
            <!-- Promo Code -->
            <div class="mt-6">
                <label for="promo-code" class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
                <div class="flex">
                    <input type="text" id="promo-code" placeholder="Enter code" 
                            class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-store-blue">
                    <button class="bg-gray-900 text-white px-4 py-2 rounded-r-md hover:bg-gray-800">Apply</button>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="post">
                @csrf
                <button type="submit"
                        class="text-center inline-block w-full bg-store-blue text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors mt-6">
                    Proceed to Checkout
                </button>
            </form>

            <!-- Payment Methods -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600 mb-2">We accept</p>
                <div class="flex justify-center space-x-2">
                    <div class="w-8 h-5 bg-blue-600 rounded text-white text-xs flex items-center justify-center">VISA</div>
                    <div class="w-8 h-5 bg-red-600 rounded text-white text-xs flex items-center justify-center">MC</div>
                    <div class="w-8 h-5 bg-blue-500 rounded text-white text-xs flex items-center justify-center">AMEX</div>
                    <div class="w-8 h-5 bg-blue-800 rounded text-white text-xs flex items-center justify-center">PP</div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-4 flex items-center justify-center space-x-2 text-sm text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Secure checkout</span>
            </div>
        </div>
    </div>
</div>