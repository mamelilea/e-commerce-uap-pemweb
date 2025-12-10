{{-- Toolbar --}}
<div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex items-center justify-between">
    <p class="text-sm text-gray-600">
        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
    </p>
    
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Sort by:</label>
            <select name="sort" class="input-field py-2 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
            </select>
        </div>
    </div>
</div>

@if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }}
    </div>
@else
    <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">No products found</h3>
        <p class="text-gray-500 mb-4">Try adjusting your filters or search criteria</p>
        <a href="{{ route('products.index') }}" class="btn-primary inline-block">Clear All Filters</a>
    </div>
@endif
