@extends('user_profile.master')

@section('profile_content')
    <!-- Order Details Content -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 gap-8">
            <!-- Main Content -->
            <div class="space-y-8">
                <!-- Order Header -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-store-dark mb-2">Order #TS-240567891</h1>
                            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                Delivered
                            </span>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Order Status</h3>
                        <div class="relative">
                            <!-- Timeline -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                            <div class="absolute left-4 top-0 w-0.5 bg-green-500" style="height: 100%;"></div>

                            <div class="space-y-6">
                                <!-- Status 1 -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-medium text-gray-900">Order Confirmed</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->created_at->format("M d, Y \a\t h:i A") }}</p>
                                    </div>
                                </div>

                                <!-- Status 2 -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-medium text-gray-900">Processing</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->processed_at->format("M d, Y \a\t h:i A") }}</p>
                                    </div>
                                </div>

                                <!-- Status 3 -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-medium text-gray-900">Shipped</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->shipped_at->format("M d, Y \a\t h:i A") }}</p>
                                        <p class="text-sm text-store-blue">Tracking: 1Z999AA1234567890</p>
                                    </div>
                                </div>

                                <!-- Status 4 -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-medium text-gray-900">Delivered</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->delivered_at->format("M d, Y \a\t h:i A") }}</p>
                                        <p class="text-sm text-gray-600">Left at front door</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold mb-6">Order Items</h2>

                    <div class="space-y-6">
                        <!-- Item 1 -->
                        @foreach ($order->items as $order_item)
                            <div class="flex items-start space-x-4 pb-6 border-b border-gray-100 last:border-b-0 last:pb-0">
                                <div
                                    class="bg-gray-100 rounded-lg w-20 h-20 flex items-center justify-center text-3xl flex-shrink-0">
                                    <img src="{{ $order_item->product->image_url_sm() }}"
                                        alt="{{ $order_item->product->name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $order_item->product->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $order_item->color->display_name }}, {{ $order_item->storage->display_name }}</p>
                                    <p class="text-sm text-gray-600">Quantity: {{ $order_item->quantity }}</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @if ($order_item->review)
                                            <button
                                                hx-get="{{ route('user.orders.reviews.edit', [
                                                    $order->id,
                                                    $order_item->id,
                                                    $order_item->review->id,
                                                ]) }}"
                                                hx-target="#modal"
                                                hx-swap="innerHTML"
                                                class="text-sm bg-store-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                                Edit a Review
                                            </button>
                                        @else
                                            <button
                                                hx-get="{{ route('user.orders.reviews.create', ['order_id' => $order->id, 'item_id' => $order_item->id]) }}"
                                                hx-target="#modal"
                                                hx-swap="innerHTML"
                                                class="text-sm bg-store-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                                Write a Review
                                            </button>
                                        @endif
                                        <a href="{% url 'products.show' $order_item->product.slug %}"
                                            class="text-sm border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                            Buy Again
                                        </a>
                                        <button
                                            class="text-sm border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                            Return Item
                                        </button>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-store-blue text-lg">${{ $order_item->total_price }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary & Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold mb-6">Order Summary</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ $order->items->count() }} items):</span>
                                <span>${{ $order->subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping:</span>
                                <span>{{ $order->formatted_shipping_price }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total:</span>
                                    <span class="text-store-blue">${{ $order->total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold mb-6">Payment Information</h2>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M7.5 4A1.5 1.5 0 006 5.5v13A1.5 1.5 0 007.5 20h9a1.5 1.5 0 001.5-1.5v-13A1.5 1.5 0 0016.5 4h-9z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">Visa ending in 4242</p>
                                    <p class="text-sm text-gray-600">Charged on May 15, 2024</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Status:</span>
                                    <span class="text-green-600 font-medium">Paid</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold mb-6">Shipping Information</h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Shipping Address -->
                        <div>
                            <h3 class="font-semibold mb-3">Shipping Address</h3>
                            <div class="text-gray-600 space-y-1">
                                <p>{{ $order->names }}</p>
                                <p>{{ $order->address_1 }}</p>
                                <p>{{ $order->address_2 }}</p>
                                <p>{{ $order->city }}, {{ $order->zip_code }}</p>
                                <p>{{ $order->country }}</p>
                            </div>
                        </div>

                        <!-- Delivery Details -->
                        <div>
                            <h3 class="font-semibold mb-3">Delivery Details</h3>
                            <div class="text-gray-600 space-y-2">
                                <div class="flex justify-between">
                                    <span>Carrier:</span>
                                    <span>UPS</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Service:</span>
                                    <span>UPS Ground</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tracking:</span>
                                    <span class="text-store-blue">1Z999AA1234567890</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Estimated Delivery:</span>
                                    <span>May 18, 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold mb-6">Order Actions</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button class="bg-store-blue text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Download Invoice
                        </button>
                        <button
                            class="border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                            Print Order Details
                        </button>
                        <button
                            class="border border-red-300 text-red-600 py-3 rounded-lg hover:bg-red-50 transition-colors">
                            Report a Problem
                        </button>
                    </div>
                </div>

                <!-- Need Help? -->
                <div class="bg-store-light-gray rounded-lg p-6">
                    <h3 class="font-bold mb-3">Need Help?</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Our customer service team is here to help with any questions about your $order->
                    </p>
                    <button
                        class="bg-store-blue text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Contact Support
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('profile_bottom')
    <div id="modal"></div>
@endsection
