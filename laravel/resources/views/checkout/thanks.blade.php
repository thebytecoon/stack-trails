@extends('master')

@section('content')
    <!-- Thank You Message -->
    <div class="min-h-screen flex items-center justify-center py-16 px-4">
        <div class="bg-white rounded-lg shadow-sm p-8 text-center max-w-lg w-full">
            <div class="text-green-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Thank you for your purchase!</h1>
            <p class="text-gray-600 mb-6">Your order <span class="font-medium">#TS-240567123</span> has been
                successfully placed.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="order-details.html"
                    class="bg-revolut-blue text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">View
                    Order Details</a>
                <a href="{{ route('home') }}"
                    class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors">Continue
                    Shopping</a>
            </div>
        </div>
    </div>
@endsection
