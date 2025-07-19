<!-- Navigation -->
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                    <h1 class="text-2xl font-bold text-store-dark">TechStore</h1>
                    </a>
                </div>
                <div class="hidden md:block ml-10">
                    <div class="flex items-baseline space-x-8">
                        <a href="{{ route('products.index') }}"
                           class="px-3 py-2 text-sm font-medium @if (Route::is('products.index')) text-store-blue @else text-gray-900 @endif hover:text-store-blue">
                           Products
                        </a>
                        <a href="/categories"
                           class="px-3 py-2 text-sm font-medium @if (Route::is('categories.index')) text-store-blue @else text-gray-600 @endif hover:text-store-blue">
                           Categories
                        </a>
                        <a href="/support"
                           class="px-3 py-2 text-sm font-medium @if (Route::is('support.index')) text-store-blue @else text-gray-600 @endif hover:text-store-blue">
                           Support
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Search Component -->
                <div class="relative">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search-input"
                            placeholder="Search products..." 
                            class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-store-blue focus:border-transparent"
                            onInput="handleSearch(this.value)"
                            onFocus="showSearchResults()"
                            onBlur="hideSearchResults()"
                        >
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Search Results Dropdown -->
                    <div id="search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-96 overflow-y-auto z-50 hidden">
                        <div id="search-loading" class="p-4 text-center text-gray-500 hidden">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-store-blue mx-auto"></div>
                            <p class="mt-2 text-sm">Searching...</p>
                        </div>
                        <div id="search-content">
                            <!-- Search results will be populated here -->
                        </div>
                        <div id="search-empty" class="p-4 text-center text-gray-500 hidden">
                            <p class="text-sm">No products found</p>
                        </div>
                    </div>
                </div>
                @include('carts.partials.cart_icon')
                @auth
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ asset('assets/avatar.png') }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full">
                            <span class="hidden md:inline-block text-sm text-gray-700">{{ auth()->user()->name }}</span>
                        </button>
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                            <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('user.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                            <a href="{{ route('user.addresses.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Addresses</a>
                            <a href="{{ route('user.payment-methods.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Payment Options</a>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                        </div>
                    <script>
                        document.getElementById('user-menu-button').addEventListener('click', function() {
                            const menu = document.getElementById('user-menu');
                            menu.classList.toggle('hidden');
                        });
                        document.addEventListener('click', function(event) {
                            const userMenuButton = document.getElementById('user-menu-button');
                            const userMenu = document.getElementById('user-menu');
                            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                                userMenu.classList.add('hidden');
                            }
                        });
                    </script>
                </div>
                @else
                <a href="{{ route('login') }}" class="bg-store-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Sign In
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Shopping Cart Offcanvas -->
<div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" onclick="toggleCart()"></div>

@include('carts.partials.offcanvas', [
    'enabled' => false,
])