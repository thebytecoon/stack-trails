@csrf
<div class="space-y-4">
    <div>
        <label for="type" class="block text-sm font-medium text-gray-700">Card type</label>
        <select name="type"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @foreach ($types as $type)
                <option
                    value="{{ $type->value }}"
                    @if (old('type') === $type->value) selected @endif
                >{{ $type->getLabel() }}</option>
            @endforeach
        </select>

        @if ($errors->has('type'))
            <span class="text-red-500 text-sm">{{ $errors->first('type') }}</span>
        @endif
    </div>

    <div>
        <label for="card_number" class="block text-sm font-medium text-gray-700">Card number</label>
        <input type="text" id="card_number" name="card_number" value="{{ old('card_number') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('card_number'))
            <span class="text-red-500 text-sm">{{ $errors->first('card_number') }}</span>
        @endif
    </div>

    <div>
        <label for="cardholder_name" class="block text-sm font-medium text-gray-700">Card holder name</label>
        <input type="text" id="cardholder_name" name="cardholder_name" value="{{ old('cardholder_name') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('cardholder_name'))
            <span class="text-red-500 text-sm">{{ $errors->first('cardholder_name') }}</span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
        <div>
            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiration date</label>
            <input type="month" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('expiry_date'))
                <span class="text-red-500 text-sm">{{ $errors->first('expiry_date') }}</span>
            @endif
        </div>
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('code'))
                <span class="text-red-500 text-sm">{{ $errors->first('code') }}</span>
            @endif
        </div>
    </div>

    <div>
        <label for="default" class="flex items-center space-x-2">
            <input type="checkbox" id="default" name="default" value="1"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="text-sm font-medium text-gray-700">Set as Default</span>
        </label>
    </div>
</div>

<div class="flex space-x-3 pt-4">
    <button type="button" hx-on:click="event.currentTarget.closest('#card-modal').remove()"
        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
        Cancel
    </button>
    <button type="submit"
        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-store-blue rounded-lg hover:bg-blue-700">
        Save
    </button>
</div>


<script>
    const input = document.getElementById('expiry');
    input.addEventListener('change', () => {
        const [year, month] = input.value.split("-");
        console.log(`${month}-${year}`); // MM-YYYY
    });
</script>
