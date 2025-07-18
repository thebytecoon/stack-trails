@csrf
<div class="flex items-center space-x-3 mb-4">
    <div id="review-product-icon"
        class="bg-gray-100 rounded-lg flex items-center justify-center text-xl">
        <img src="{{ $product->image_url_sm() }}"
        alt="{{ $product->name }}" class="w-full h-24 object-cover rounded-md">
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
        <button type="button" onclick="setRating(1)"
            class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
        <button type="button" onclick="setRating(2)"
            class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
        <button type="button" onclick="setRating(3)"
            class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
        <button type="button" onclick="setRating(4)"
            class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
        <button type="button" onclick="setRating(5)"
            class="star-rating text-2xl text-gray-300 hover:text-yellow-400">★</button>
    </div>

    <input type="hidden" name="rating" id="rating" value="0" class="hidden">

    @if ($errors->has('rating'))
        <span class="text-red-500 text-sm">{{ $errors->first('rating') }}</span>
    @endif
</div>

<!-- Review Title -->
<div class="mb-4">
    <label for="title" class="block text-sm font-medium mb-2">Review Title</label>
    <input type="text" name="title" value="{{ old('title', $model->title) }}" placeholder="Summarize your experience"
        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent">

    @if ($errors->has('title'))
        <span class="text-red-500 text-sm">{{ $errors->first('title') }}</span>
    @endif
</div>

<!-- Review Text -->
<div class="mb-6">
    <label for="comment" class="block text-sm font-medium mb-2">Your Review</label>
    <textarea rows="4" name="comment" placeholder="Tell others about your experience with this product"
        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent resize-none">{{ old('comment', $model->comment) }}</textarea>

    @if ($errors->has('comment'))
        <span class="text-red-500 text-sm">{{ $errors->first('comment') }}</span>
    @endif
</div>

<div class="flex space-x-3">
    <button class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
        Cancel
    </button>
    <button class="flex-1 bg-store-blue text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
        Submit Review
    </button>
</div>

<script>
    @if (old('rating', $model->rating))
        setRating({{ old('rating', $model->rating) }});
    @endif

    function setRating(rating) {
        const stars = document.querySelectorAll('.star-rating');
        console.log(stars, rating);
        stars.forEach((star, index) => {
            star.classList.toggle('text-yellow-400', index < rating);
            star.classList.toggle('text-gray-300', index >= rating);
        });

        document.getElementById('rating').value = rating;
    }
</script>
