<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('seller.products.update', $product) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', $product->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="product_category_id" :value="__('Kategori')" />
                        <select id="product_category_id" name="product_category_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('product_category_id', $product->product_category_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                :value="old('price', $product->price)" required min="100" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stock" :value="__('Stok')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                :value="old('stock', $product->stock)" required min="0" />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="weight" :value="__('Berat (gram)')" />
                            <x-text-input id="weight" class="block mt-1 w-full" type="number" name="weight"
                                :value="old('weight', $product->weight)" required min="1" />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="condition" :value="__('Kondisi Barang')" />
                        <select id="condition" name="condition"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            required>
                            <option value="new"
                                {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru (New)
                            </option>
                            <option value="used"
                                {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Bekas (Used)
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('condition')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="about" :value="__('Deskripsi Produk')" />
                        <textarea id="about"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            name="about" rows="6" required>{{ old('about', $product->about) }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <div class="text-sm text-gray-600 mb-6 border-l-4 border-yellow-400 p-2 bg-yellow-50">
                        *Catatan: Fitur perubahan gambar di laman edit ini belum diimplementasikan. Untuk saat ini,
                        hanya data produk utama yang bisa diubah.
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-secondary-button href="{{ route('seller.products.index') }}" class="mr-2">
                            {{ __('Batal') }}
                        </x-secondary-button>
                        <x-primary-button>
                            {{ __('Perbarui Produk') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-seller-layout>
