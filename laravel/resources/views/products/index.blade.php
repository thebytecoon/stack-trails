@extends("master")

@section('content')
<form method="get" action="{{ route('products.index') }}" id="filter-form">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-4 lg:gap-8">
        <!-- Filters Sidebar -->
        <div class="hidden lg:block">
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-6">Filters</h2>
                @include("products._filters")

                <button type="button" onclick="clearAllFilters()" class="w-full text-sm text-store-blue hover:underline">
                    Clear all filters
                </button>
            </div>
        </div>
        

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Sort and View Options -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">All Products</h1>
                    {{-- <p class="text-gray-600">Showing {{ page_obj.start_index }}-{{ page_obj.end_index }} of {{ page_obj.paginator.count }} products</p> --}}
                </div>
                <div class="flex items-center space-x-4">
                    {{-- {{ filters.sort_by }} --}}
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    @include("products.product")
                @endforeach
            </div>
            {!! $products->links() !!}
        </div>
    </div>
</div>
</form>
@endsection

@section('scripts')
@parent
<script>
function clearAllFilters() {
    const form = document.getElementById('filter-form');

    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        } else {
            input.value = input.defaultValue || '';
        }
    });

    form.submit();
}
</script>
@endsection