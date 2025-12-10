@extends('layouts.seller')

@section('title', 'Add New Product')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" style="color: #252B42;">Add New Product</h1>
            <p class="text-gray-600">Fill in the product details below</p>
        </div>
        <a href="{{ route('seller.products.index') }}" class="btn-outline">
            ← Back to Products
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Product Name --}}
                <div class="lg:col-span-2">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Product Name <span class="text-danger-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="input-field @error('name') border-danger-500 @enderror"
                        placeholder="e.g., Premium Cotton T-Shirt"
                        required>
                    @error('name')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="product_category_id" class="block text-sm font-bold text-gray-700 mb-2">
                        Category <span class="text-danger-500">*</span>
                    </label>
                    <select 
                        id="product_category_id" 
                        name="product_category_id" 
                        class="input-field @error('product_category_id') border-danger-500 @enderror"
                        required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach($category->children as $child)
                                    <option value="{{ $child->id }}" {{ old('product_category_id') == $child->id ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Condition --}}
                <div>
                    <label for="condition" class="block text-sm font-bold text-gray-700 mb-2">
                        Condition <span class="text-danger-500">*</span>
                    </label>
                    <select 
                        id="condition" 
                        name="condition" 
                        class="input-field @error('condition') border-danger-500 @enderror"
                        required>
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="second" {{ old('condition') == 'second' ? 'selected' : '' }}>Second</option>
                    </select>
                    @error('condition')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-2">
                        Price (Rp) <span class="text-danger-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}"
                        class="input-field @error('price') border-danger-500 @enderror"
                        placeholder="100000"
                        min="0"
                        required>
                    @error('price')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">
                        Stock Quantity <span class="text-danger-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="stock" 
                        name="stock" 
                        value="{{ old('stock') }}"
                        class="input-field @error('stock') border-danger-500 @enderror"
                        placeholder="50"
                        min="0"
                        required>
                    @error('stock')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Weight --}}
                <div>
                    <label for="weight" class="block text-sm font-bold text-gray-700 mb-2">
                        Weight (gram) <span class="text-danger-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="weight" 
                        name="weight" 
                        value="{{ old('weight') }}"
                        class="input-field @error('weight') border-danger-500 @enderror"
                        placeholder="e.g., 500"
                        min="1"
                        required>
                    @error('weight')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Product weight for shipping calculation</p>
                </div>

                {{-- Description --}}
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                        Product Description <span class="text-danger-500">*</span>
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="6"
                        class="input-field @error('description') border-danger-500 @enderror"
                        placeholder="Describe your product in detail..."
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Product Images --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Product Images <span class="text-danger-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <input 
                            type="file" 
                            id="images" 
                            name="images[]" 
                            accept="image/*"
                            multiple
                            class="hidden"
                            onchange="previewImages(event)">
                        <label for="images" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-600 mb-1">Click to upload product images</p>
                            <p class="text-xs text-gray-500">Multiple images allowed (Max 2MB each)</p>
                        </label>
                    </div>
                    
                    {{-- Image Preview --}}
                    <div id="image-preview" class="grid grid-cols-3 md:grid-cols-5 gap-4 mt-4"></div>
                    
                    @error('images.*')
                        <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    Add Product
                </button>
                <a href="{{ route('seller.products.index') }}" class="btn-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImages(event) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative aspect-square rounded-lg overflow-hidden border border-gray-200';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">
                <div class="absolute top-1 right-1 bg-white rounded-full p-1 text-xs font-bold text-primary-500">
                    ${i + 1}
                </div>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
