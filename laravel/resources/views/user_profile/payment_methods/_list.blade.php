<div 
    id="payment-methods-list"
    class="divide-y divide-gray-200"
>
    @foreach($payment_methods as $payment_method)
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-8 bg-gradient-to-r {{ $payment_method->getCardCssClasses() }} rounded flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ ucfirst($payment_method->type) }}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <h3 class="font-medium text-gray-900">{{ $payment_method->hiddenCardNumber() }}</h3>
                        @if ($payment_method->default)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Default
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600">Expires {{ $payment_method->expiry_date->format('m/y') }}</p>
                    <p class="text-sm text-gray-600">{{ $payment_method->cardholder_name }}</p>
                </div>
                <div class="flex space-x-2">
                    @if (!$payment_method->default)
                    <button 
                        hx-patch="{{ route('user.payment-methods.default', [$payment_method->id]) }}"
                        hx-target="#payment-methods-list"
                        hx-swap="outerHTML"
                        class="text-sm text-revolut-blue hover:text-blue-700">Set as Default</button>
                    <span class="text-gray-300">|</span>
                    @endif
                    <button 
                        hx-delete="{{ route('user.payment-methods.destroy', [$payment_method->id]) }}"
                        hx-target="#payment-methods-list"
                        hx-swap="outerHTML"
                        hx-confirm="Are you sure you want to remove this address?"
                        class="text-sm text-red-600 hover:text-red-700">Remove</button>
                </div>
            </div>
        </div>
    @endforeach
</div>