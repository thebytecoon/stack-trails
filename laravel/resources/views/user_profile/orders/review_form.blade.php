<div class="bg-white rounded-lg max-w-md w-full p-6">
    <div class="mb-6">
        <div class="flex items-center space-x-3 mb-4">
            <div id="review-product-icon"
                class="bg-gray-100 rounded-lg w-12 h-12 flex items-center justify-center text-xl">
                <img src="{{ $product->image_url_sm() }}" alt="{{ $product->name }}"
                    class="w-full h-24 object-cover rounded-md">
            </div>
            <div>
                <p id="review-product-name" class="font-semibold">{{ $product->name }}</p>
                <p class="text-sm text-gray-600">Rate your experience</p>
            </div>
        </div>

        <!-- Star Rating -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Rating</label>
            <div class="flex space-x-1">
                <button onclick="setRating(1)"
                    class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
                <button onclick="setRating(2)"
                    class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
                <button onclick="setRating(3)"
                    class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
                <button onclick="setRating(4)"
                    class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
                <button onclick="setRating(5)"
                    class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
            </div>
        </div>

        <!-- Review Title -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Review Title</label>
            <input type="text" placeholder="Summarize your experience"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent">
        </div>

        <!-- Review Text -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Your Review</label>
            <textarea rows="4" placeholder="Tell others about your experience with this product"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent resize-none"></textarea>
        </div>
    </div>

    <div class="flex space-x-3">
        <button
            class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
            Cancel
        </button>
        <button class="flex-1 bg-revolut-blue text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Submit Review
        </button>
    </div>
</div>
