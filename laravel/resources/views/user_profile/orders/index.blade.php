@extends('user_profile.master')

@section('profile_content')
<!-- Orders Content -->
<div class="lg:col-span-3">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
         <form action="">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Your Orders</h1>
                <div class="flex items-center space-x-4">
                    {{-- {{ form }} --}}
                </div>
            </div>
        </div>
        </form>

        <!-- Orders List -->
        @include('user_profile.orders._list')
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <svg class="w-8 h-8 mx-auto text-store-blue mb-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
            <h3 class="font-medium text-gray-900 mb-2">Your Lists</h3>
            <p class="text-sm text-gray-600 mb-3">Create and manage your wish lists</p>
            <button class="text-sm text-store-blue hover:text-blue-700">View all lists</button>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <svg class="w-8 h-8 mx-auto text-store-blue mb-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                </path>
            </svg>
            <h3 class="font-medium text-gray-900 mb-2">Leave a Review</h3>
            <p class="text-sm text-gray-600 mb-3">Help other customers by sharing your experience</p>
            <button class="text-sm text-store-blue hover:text-blue-700">Write a review</button>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
            <svg class="w-8 h-8 mx-auto text-store-blue mb-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
            </svg>
            <h3 class="font-medium text-gray-900 mb-2">Return Items</h3>
            <p class="text-sm text-gray-600 mb-3">Return or exchange items within 30 days</p>
            <button class="text-sm text-store-blue hover:text-blue-700">Start a return</button>
        </div>
    </div>
</div>
@endsection