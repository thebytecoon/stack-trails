@csrf
<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $model->name) }}" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('name'))
            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
        @endif
    </div>

    <div>
        <label for="names" class="block text-sm font-medium text-gray-700">Person names</label>
        <input type="text" id="names" name="names" value="{{ old('names', $model->names) }}" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('names'))
            <span class="text-red-500 text-sm">{{ $errors->first('names') }}</span>
        @endif
    </div>

    <div>
        <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
        <input type="text" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $model->address_line_1) }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('address_line_1'))
            <span class="text-red-500 text-sm">{{ $errors->first('address_line_1') }}</span>
        @endif
    </div>

    <div>
        <label for="address_line_2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
        <input type="text" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $model->address_line_2) }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

        @if ($errors->has('address_line_2'))
            <span class="text-red-500 text-sm">{{ $errors->first('address_line_2') }}</span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" id="city" name="city" value="{{ old('city', $model->city) }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('city'))
                <span class="text-red-500 text-sm">{{ $errors->first('city') }}</span>
            @endif
        </div>

        <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $model->postal_code) }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('postal_code'))
                <span class="text-red-500 text-sm">{{ $errors->first('postal_code') }}</span>
            @endif
        </div>
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <input type="text" id="country" name="country" value="{{ old('country', $model->country) }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('country'))
                <span class="text-red-500 text-sm">{{ $errors->first('country') }}</span>
            @endif
        </div>
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $model->phone_number) }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

            @if ($errors->has('phone_number'))
                <span class="text-red-500 text-sm">{{ $errors->first('phone_number') }}</span>
            @endif
        </div>
    </div>
    <div>
        <label for="default" class="flex items-center space-x-2">
            <input type="hidden" id="default" name="default" value="0">
            <input type="checkbox" id="default" name="default" value="1"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="text-sm font-medium text-gray-700">Set as Default Address</span>
        </label>
    </div>
</div>
<div class="flex space-x-3 pt-4">
    <button type="button" hx-on:click="event.currentTarget.closest('#address-modal').remove()"
        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
        Cancel
    </button>
    <button type="submit"
        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-store-blue rounded-lg hover:bg-blue-700">
        Save Address
    </button>
</div>
