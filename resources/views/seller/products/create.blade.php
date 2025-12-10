@extends('layouts.seller')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Back Button -->
    <a href="{{ route('seller.products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Daftar Produk
    </a>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
        <p class="text-gray-600 mt-2">Lengkapi informasi produk yang akan dijual</p>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-lg shadow-sm p-8 space-y-6">

            <!-- Product Images -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Produk <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-500 mb-3">Upload minimal 1 gambar, maksimal 2 gambar. Gambar pertama akan menjadi thumbnail.</p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="image1" class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition">
                            <div id="preview1" class="hidden">
                                <img src="" alt="Preview" class="w-full h-48 object-cover rounded-lg mb-2">
                                <p class="text-sm text-blue-600 font-semibold">Gambar 1 (Thumbnail)</p>
                            </div>
                            <div id="placeholder1">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-600 font-semibold">Gambar 1 (Wajib)</p>
                                <p class="text-xs text-gray-500 mt-1">Klik untuk upload</p>
                            </div>
                            <input type="file" id="image1" name="images[]" accept="image/*" class="hidden" required onchange="previewImage(this, 1)">
                        </label>
                    </div>

                    <div>
                        <label for="image2" class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition">
                            <div id="preview2" class="hidden">
                                <img src="" alt="Preview" class="w-full h-48 object-cover rounded-lg mb-2">
                                <p class="text-sm text-blue-600 font-semibold">Gambar 2</p>
                            </div>
                            <div id="placeholder2">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-600 font-semibold">Gambar 2 (Opsional)</p>
                                <p class="text-xs text-gray-500 mt-1">Klik untuk upload</p>
                            </div>
                            <input type="file" id="image2" name="images[]" accept="image/*" class="hidden" onchange="previewImage(this, 2)">
                        </label>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: Laptop ASUS ROG Gaming"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="product_category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('product_category_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Condition -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kondisi <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition {{ old('condition') == 'new' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="condition" value="new" class="mr-3" {{ old('condition') == 'new' || !old('condition') ? 'checked' : '' }} required>
                        <div>
                            <p class="font-semibold text-gray-800">Baru</p>
                            <p class="text-xs text-gray-500">Produk baru, belum pernah dipakai</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition {{ old('condition') == 'second' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="condition" value="second" class="mr-3" {{ old('condition') == 'second' ? 'checked' : '' }} required>
                        <div>
                            <p class="font-semibold text-gray-800">Bekas</p>
                            <p class="text-xs text-gray-500">Produk second/bekas pakai</p>
                        </div>
                    </label>
                </div>
                @error('condition')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Produk <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="6"
                    placeholder="Jelaskan detail produk, spesifikasi, kelebihan, dll..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price, Weight, Stock -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                        <input type="number" name="price" value="{{ old('price') }}"
                            placeholder="0"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                    @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Weight -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Berat (gram) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="weight" value="{{ old('weight') }}"
                        placeholder="1000"
                        min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('weight')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}"
                        placeholder="1"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                    Tambah Produk
                </button>
                <a href="{{ route('seller.products.index') }}"
                    class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input, imageNumber) {
        const preview = document.getElementById('preview' + imageNumber);
        const placeholder = document.getElementById('placeholder' + imageNumber);
        const img = preview.querySelector('img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection