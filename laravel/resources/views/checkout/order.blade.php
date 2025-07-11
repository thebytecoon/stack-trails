@extends('master')

@section('content')
    <!-- Checkout Progress -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-store-blue text-white rounded-full flex items-center justify-center text-sm font-medium">
                                1</div>
                            <span class="ml-2 text-sm font-medium text-gray-900">Cart</span>
                        </div>
                        <div class="h-0.5 w-16 bg-store-blue"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-store-blue text-white rounded-full flex items-center justify-center text-sm font-medium">
                                2</div>
                            <span class="ml-2 text-sm font-medium text-gray-900">Checkout</span>
                        </div>
                        <div class="h-0.5 w-16 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium">
                                3</div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <form action="{{ route('payment.store', [$order->uuid]) }}" method="post">
        @csrf
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Checkout Form -->
                <div class="space-y-8">
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Address</h2>
                        <div id="id_address">
                            @foreach ($shipping_addresses as $address)
                                <label for="id_address_{{ $address->id }}"
                                    class="flex items-center border border-gray-200 rounded-lg p-4 mb-4">
                                    <input type="radio" name="address" value="{{ $address->id }}"
                                        id="id_address_{{ $address->id }}" required="">
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-900">{{ $address->name }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $address->address_line_1 }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Options -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Options</h2>
                        <div id="id_shipping_option">
                            @foreach ($shipping_options as $option)
                                <label for="id_shipping_option_{{ $option->id }}"
                                    class="flex items-center border border-gray-200 rounded-lg p-4 mb-4">
                                    <input type="radio" name="shipping_option" value="{{ $option->id }}"
                                        id="id_shipping_option_{{ $option->id }}"
                                        hx-vals='{"shipping": "{{ $option->id }}"}'
                                        hx-patch="{{ route('orders.update', [$order->uuid]) }}"
                                        hx-target="#checkout-order-summary"
                                        hx-trigger="click" 
                                        required="true"
                                    >
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-900">{{ $option->name }}</span>
                                            @if ($option->price > 0)
                                                <span class="font-medium">${{ $option->price }}</span>
                                            @else
                                                <span class="text-green-600 font-medium">Free</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $option->description }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>
                        <select name="payment_method"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent mb-4"
                            id="id_payment_method">
                            @foreach ($payment_methods as $payment_method)
                                <option value="{{ $payment_method->id }}">{{ $payment_method->type }} ending ••••
                                    {{ $payment_method->shortNumber() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @include('checkout._order_summary')
            </div>
    </form>
@endsection
