<!-- Addresses Grid -->
<div 
    id="addresses-list"
    class="p-6"
>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($addresses as $address)
            <div class="border border-gray-200 rounded-lg p-4 relative">
                @if ($address->default)
                    <div class="absolute top-3 right-3">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Default
                        </span>
                    </div>
                @endif
                <div class="pr-16">
                    <h3 class="font-medium text-gray-900 mb-2">{{ $address->name }}</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p class="font-medium">{{ $address->names }}</p>
                        <p>{{ $address->address_line_1 }}</p>
                        <p>{{ $address->address_line_2 }}</p>
                        <p>{{ $address->city }} {{ $address->postal_code }}</p>
                        <p>{{ $address->country }}</p>
                        <p>{{ $address->phone_number }}</p>
                    </div>
                </div>
                <div class="mt-4 flex space-x-2">
                    @if (!$address->default)
                        <button
                            hx-patch="{{ route('user.addresses.set_default', [$address->id]) }}"
                            hx-target="#addresses-list"
                            hx-swap="outerHTML"
                            class="text-sm text-store-blue hover:text-blue-700">Set as Default</button>
                        <span class="text-gray-300">|</span>
                    @endif
                    <button
                        hx-get="{{ route('user.addresses.edit', [$address->id]) }}"
                        hx-target="#modal"
                        hx-swap="innerHTML"
                        class="text-sm text-store-blue hover:text-blue-700">Edit</button>
                    <span class="text-gray-300">|</span>
                    <button
                        hx-delete="{{ route('user.addresses.destroy', [$address->id]) }}"
                        hx-target="#addresses-list"
                        hx-swap="outerHTML"
                        hx-confirm="Are you sure you want to remove this address?"
                        class="text-sm text-red-600 hover:text-red-700">Remove</button>
                </div>
            </div>
            @endforeach

        <!-- Add New Address Card -->
        <div 
            hx-get="{{ route('user.addresses.create') }}"
            hx-target="#modal"
            hx-swap="innerHTML"
            hx-trigger="click"
            class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:border-store-blue transition-colors"
        >
            <div class="text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <p class="text-sm text-gray-600">Add New Address</p>
            </div>
        </div>
    </div>
</div>