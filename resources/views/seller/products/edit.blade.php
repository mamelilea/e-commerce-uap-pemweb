<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$product->name" required />
                        </div>
                        

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(\App\Models\ProductCategory::all() as $category)
                                    <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="price" :value="__('Price (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="$product->price" required />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stock')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="$product->stock" required />
                            </div>
                        </div>


                        <div class="mb-4">
                            <span class="block font-medium text-sm text-gray-700 mb-1">Condition</span>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="condition" value="new" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $product->condition == 'new' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">New</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="condition" value="second" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $product->condition == 'second' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Second</span>
                                </label>
                            </div>
                        </div>


                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="4" required>{{ $product->description }}</textarea>
                        </div>


                         @if($product->productImages->count() > 0)
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-700">Current Image</span>
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="Product Image" class="w-20 h-20 object-cover mt-1 rounded">
                            </div>
                        @endif


                        <div class="mb-4">
                             <x-input-label for="image" :value="__('Update Image (Optional)')" />
                             <input id="image" type="file" name="image" class="block mt-1 w-full border border-gray-300 rounded-md cursor-pointer p-2 focus:outline-none" accept="image/*" />
                             <p class="mt-1 text-sm text-gray-500">Allowed formats: jpg, jpeg, png. Leave blank to keep current image.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
