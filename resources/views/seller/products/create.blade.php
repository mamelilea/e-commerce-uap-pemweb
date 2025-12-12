<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen animate-fade-in-up">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Product Name</label>
                        <input type="text" name="name" id="name" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="e.g. OVERSIZED TEE">
                    </div>

                    <div class="mb-6">
                        <label for="product_category_id" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Category</label>
                        <select name="product_category_id" id="product_category_id" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 appearance-none" required>
                            <option value="">SELECT CATEGORY</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="price" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Price (Rp)</label>
                            <input type="number" name="price" id="price" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="0">
                        </div>
                        <div>
                            <label for="stock" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Stock</label>
                            <input type="number" name="stock" id="stock" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="0">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans text-gray-600 placeholder-gray-400 resize-none" required placeholder="Product details..."></textarea>
                    </div>

                    <div class="mb-8">
                        <label for="image" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Product Image</label>
                        <input type="file" name="image" id="image" class="w-full bg-gray-50 border border-gray-200 p-2 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink font-sans file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-hubbub-black file:text-white hover:file:bg-hubbub-pink transition-all" accept="image/*" required>
                    </div>

                    <div class="flex justify-between items-center gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('seller.products') }}" class="text-gray-400 font-sans font-bold uppercase text-xs hover:text-hubbub-pink transition-colors">Cancel</a>
                        <button type="submit" class="bg-hubbub-black text-white font-sans font-bold uppercase px-8 py-3 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-0.5 text-xs tracking-wider">
                            Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
