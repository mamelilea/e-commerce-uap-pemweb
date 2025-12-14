@extends('layouts.frontend')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <a href="{{ route('store.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-k-pink mb-3 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Add New Product</h1>
            <p class="text-gray-500 mt-2">Create a new listing for your store.</p>
        </div>
    </div>

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Basic Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Details Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">01</span>
                        Basic Information
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
                            <input type="text" name="name" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="e.g., NewJeans 'OMG' Album" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="about" rows="6" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="Describe your product in detail...">{{ old('about') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2 text-right">Keep it engaging and descriptive.</p>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">02</span>
                        Pricing & Inventory
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Price (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">Rp</span>
                                <input type="number" name="price" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 pl-12 pr-4" placeholder="0" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stock</label>
                            <input type="number" name="stock" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Verification & Media -->
            <div class="space-y-8">
                 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">03</span>
                        Details
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                            <select name="product_category_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4 appearance-none" required>
                                <option value="">Select Category</option>
                                @foreach(\App\Models\ProductCategory::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Condition</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="condition" value="new" class="peer sr-only" checked>
                                    <div class="rounded-xl border border-gray-200 p-3 text-center hover:bg-gray-50 peer-checked:border-k-pink peer-checked:bg-pink-50 peer-checked:text-k-pink transition-all">
                                        <span class="text-sm font-bold">New</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="condition" value="used" class="peer sr-only">
                                    <div class="rounded-xl border border-gray-200 p-3 text-center hover:bg-gray-50 peer-checked:border-k-pink peer-checked:bg-pink-50 peer-checked:text-k-pink transition-all">
                                        <span class="text-sm font-bold">Used</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Media Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">04</span>
                        Media
                    </h2>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Product Images</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-k-pink hover:bg-pink-50/30 transition-all group">
                            <div class="space-y-1 text-center w-full">
                                <div id="uploadPlaceholder">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-k-pink transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="images-upload" class="relative cursor-pointer rounded-md font-bold text-k-pink hover:text-pink-600 focus-within:outline-none">
                                            <span>Upload files</span>
                                            <input id="images-upload" name="images[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(event)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB (Max 5 images)</p>
                                </div>
                                
                                <div id="imagePreviewContainer" class="hidden grid grid-cols-2 gap-4 mt-4">
                                    <!-- Previews will be inserted here -->
                                </div>
                                <button id="resetImagesBtn" type="button" onclick="resetImages()" class="hidden mt-4 text-xs text-red-500 hover:text-red-700 font-bold">Remove All</button>
                            </div>
                        </div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                             <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gray-900 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-gray-800 transition-all transform hover:-translate-y-0.5">
                        Create Product
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="px-6 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const container = document.getElementById('imagePreviewContainer');
    const placeholders = document.getElementById('uploadPlaceholder');
    const resetBtn = document.getElementById('resetImagesBtn');
    const files = event.target.files;
    
    container.innerHTML = ''; // Clear previous previews
    
    if (files.length > 0) {
        placeholders.classList.add('hidden');
        container.classList.remove('hidden');
        resetBtn.classList.remove('hidden');

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="h-24 w-full object-cover rounded-lg border border-gray-200">
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

function resetImages() {
    const input = document.getElementById('images-upload');
    const container = document.getElementById('imagePreviewContainer');
    const placeholders = document.getElementById('uploadPlaceholder');
    const resetBtn = document.getElementById('resetImagesBtn');
    
    input.value = '';
    container.innerHTML = '';
    container.classList.add('hidden');
    resetBtn.classList.add('hidden');
    placeholders.classList.remove('hidden');
}
</script>
@endsection
