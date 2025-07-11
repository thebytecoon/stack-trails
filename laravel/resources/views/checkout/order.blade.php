@extends('master')

@section('content')
<!-- Checkout Progress -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-store-blue text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Cart</span>
                    </div>
                    <div class="h-0.5 w-16 bg-store-blue"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-store-blue text-white rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Checkout</span>
                    </div>
                    <div class="h-0.5 w-16 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium">3</div>
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
                {{-- {{ form.address }} --}}
            </div>

            <!-- Shipping Options -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Options</h2>
                {{-- {{ form.shipping_option }} --}}
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>
                {{-- {{ form.payment_method }} --}}
            </div>
        </div>

    @include('checkout._order_summary')
</div>
</form>
@endsection