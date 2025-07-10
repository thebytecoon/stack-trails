<div class="mb-6">
    <h3 class="font-semibold mb-3">Categories</h3>
    <div id="id_categories" class="space-y-2">
        @foreach ($categories as $category)
            <div>
                <label for="id_categories_{{ $category->id }}">
                    <input
                        type="checkbox"
                        name="categories[]"
                        value="{{ $category->name }}"
                        onclick="this.form.submit()"
                        @if (request()->array('categories') && in_array($category->name, request()->array('categories'))) 
                        checked
                        @endif
                        class="space-y-2" id="id_categories_{{ $category->id }}">
                    {{ $category->display_name }} ({{ $category->products_count }})
                </label>
            </div>
        @endforeach
    </div>
</div>
<div class="mb-6">
    <h3 class="font-semibold mb-3">Brands</h3>
    <div id="id_brands" class="space-y-2">
        @foreach ($brands as $brand)
            <div>
                <label for="id_brands_{{ $brand->id }}">
                    <input
                        type="checkbox"
                        name="brands[]"
                        value="{{ $brand->name }}"
                        onclick="this.form.submit()"
                        @if (request()->array('brands') && in_array($brand->name, request()->array('brands'))) 
                        checked
                        @endif
                        class="space-y-2" id="id_brands_{{ $brand->id }}">
                    {{ $brand->display_name }} ({{ $brand->products_count }})
                </label>
            </div>
        @endforeach
    </div>
</div>
