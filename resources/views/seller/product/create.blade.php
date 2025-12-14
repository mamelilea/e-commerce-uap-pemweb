<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
           <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- LEFT COLUMN: Image & Category -->
                    <div class="md:col-span-1 space-y-6">

                         <!-- Image Upload Card -->
                         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Produk
                            </h3>

                            <div class="space-y-4">
                                <div class="w-full">
                                    <label class="flex justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-xl appearance-none cursor-pointer hover:border-indigo-400 focus:outline-none">
                                        <span class="flex items-center space-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <span class="font-medium text-gray-600">Pilih File...</span>
                                        </span>
                                        <input type="file" name="images[]" class="hidden" multiple required>
                                    </label>
                                </div>
                                <div class="text-xs text-gray-500 text-center">
                                    Format: JPG, PNG, JPEG. Max 2MB per file. Min 1, Max 5 foto.
                                </div>
                                <x-input-error :messages="$errors->get('images')" class="mt-2 text-center" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2 text-center" />
                            </div>
                        </div>

                         <!-- Category Card -->
                         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                Pengelompokan
                            </h3>

                            <!-- Category -->
                            <div class="mb-4">
                                <x-input-label for="product_category_id" :value="__('Kategori Produk')" class="mb-2" />
                                <select id="product_category_id" name="product_category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm block w-full bg-gray-50" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" {{ old('product_category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                            </div>

                            <!-- Condition -->
                            <div class="mb-4">
                                <x-input-label for="condition" :value="__('Kondisi Barang')" class="mb-2" />
                                <select id="condition" name="condition" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm block w-full bg-gray-50" required>
                                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru (New)</option>
                                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Bekas (Used)</option>
                                </select>
                                <x-input-error :messages="$errors->get('condition')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Details & Desc -->
                    <div class="md:col-span-2 space-y-6">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                             <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"></path></svg>
                                Informasi Produk
                            </h3>

                            <!-- Nama Produk -->
                             <div class="mb-6">
                                <x-input-label for="name" :value="__('Nama Produk')" />
                                <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white transition-colors" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Mood Ring Magic" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                             <!-- Pricing & Stock Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <x-input-label for="price" :value="__('Harga (Rp)')" />
                                     <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 font-bold sm:text-sm">Rp</span>
                                        <x-text-input id="price" class="block w-full pl-10 bg-gray-50 border-gray-200 focus:bg-white" type="number" name="price" :value="old('price')" required min="100" placeholder="0" />
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                                 <div>
                                    <x-input-label for="stock" :value="__('Stok')" />
                                    <x-text-input id="stock" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white text-center" type="number" name="stock" :value="old('stock')" required min="0" placeholder="0" />
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>
                                 <div>
                                    <x-input-label for="weight" :value="__('Berat (gram)')" />
                                    <x-text-input id="weight" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white text-center" type="number" name="weight" :value="old('weight')" required min="1" placeholder="0" />
                                    <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-2">
                                <x-input-label for="about" :value="__('Deskripsi Lengkap')" />
                                <textarea id="about" class="block mt-1 w-full rounded-xl border-gray-200 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 focus:bg-white shadow-sm transition-colors" name="about" rows="6" required placeholder="Jelaskan spesifikasi, keunggulan, dan detail lainnya...">{{ old('about') }}</textarea>
                                <x-input-error :messages="$errors->get('about')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                         <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('seller.products.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="px-6 py-2.5 text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                {{ __('Simpan Produk') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-seller-layout>
