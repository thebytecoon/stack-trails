<div id="user-orders-list" hx-swap-oob="true" class="divide-y divide-gray-200">
    @foreach ($orders as $order)
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="grid grid-cols-4 gap-8 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">ORDER PLACED</p>
                        <p class="text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">TOTAL</p>
                        <p class="text-gray-600">${{ $order->total }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">SHIP TO</p>
                        <p class="text-gray-600">{{ $order->names }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">ORDER #</p>
                        <p class="text-store-blue">{{ $order->shortCode() }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('user.orders.show', [$order->uuid]) }}"
                        class="text-sm text-store-blue hover:text-blue-700">
                        View order details
                    </a>
                    <span class="text-gray-300">|</span>
                    <button class="text-sm text-store-blue hover:text-blue-700">Invoice</button>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Order Item 1 -->
                @foreach ($order->items as $item)
                    <div class="flex items-start space-x-4 border-l-4 border-green-500 pl-4">
                        <img src="{{ $item->product->image_url_sm() }}" alt="{{ $item->product->name }}"
                            class="w-20 h-20 object-cover rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600">Natural Titanium, 256GB</p>
                            <p class="text-sm text-green-600 font-medium mt-1">Delivered
                                {{ $order->created_at->format('M d, Y') }}</p>
                            <div class="flex space-x-4 mt-2">
                                <button class="text-sm text-store-blue hover:text-blue-700">Buy it again</button>
                                <button class="text-sm text-store-blue hover:text-blue-700">View your item</button>
                                <button class="text-sm text-store-blue hover:text-blue-700">Write a product
                                    review</button>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">${{ $item->total_price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
