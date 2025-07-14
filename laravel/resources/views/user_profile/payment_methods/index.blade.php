@extends('user_profile.master')

@section('profile_content')
    <!-- Payment Options Content -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">Payment Options</h1>
                    <button hx-get="{{ route('user.payment-methods.create') }}" hx-target="#modal" hx-swap="innerHTML"
                        class="bg-revolut-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Payment Method
                    </button>
                </div>
            </div>

            <!-- Payment Methods List -->
            @include('user_profile.payment_methods._list')

            <!-- Payment Security Info -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900">Secure Payment Processing</h4>
                        <p class="text-sm text-gray-600 mt-1">Your payment information is encrypted and stored securely. We
                            never store your full credit card number on our servers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('profile_bottom')
    <div id="modal"></div>
@endsection
