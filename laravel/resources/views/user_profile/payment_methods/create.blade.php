<div id="card-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 id="card-modal-title" class="text-xl font-bold">Add New Card</h3>
            <button 
                hx-on:click="event.currentTarget.closest('#card-modal').remove()"
                class="p-2 rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    <form id="card-form" action="{{ route('user.payment-methods.store') }}" hx-post="{{ route('user.payment-methods.store') }}"
        class="space-y-4" method="POST">
        @include('user_profile.payment_methods._form_fields')
    </form>
    </div>
</div>