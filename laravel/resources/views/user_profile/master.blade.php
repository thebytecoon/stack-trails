@extends('master')

@section('content')
<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Account</h3>
                <nav class="space-y-2">
                    <a href="{{ route('user.orders.index') }}"
                       class="block px-3 py-2 text-sm rounded-md @if (Route::is('user.orders.index')) text-store-blue bg-blue-50 font-medium @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                        Your Orders
                    </a>
                    <a href="{{ route('user.addresses.index') }}"
                       class="block px-3 py-2 text-sm rounded-md @if (Route::is('user.addresses.index')) text-store-blue bg-blue-50 font-medium @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                        Your Addresses
                    </a>
                    <a href="{{ route('user.payment-methods.index') }}"
                       class="block px-3 py-2 text-sm rounded-md @if (Route::is('user.payment-methods.index')) text-store-blue bg-blue-50 font-medium @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                        Payment Options
                    </a>
                    <a href=""
                       class="block px-3 py-2 text-sm rounded-md @if (Route::is('user.lists.index')) text-store-blue bg-blue-50 font-medium @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                        Your Lists
                    </a>
                </nav>
            </div>
        </div>

        @yield('profile_content')
    </div>
</div>

@yield('profile_bottom')
@endsection