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
        <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
        <p class="text-gray-600 mt-2">Update informasi produk Anda</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

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
    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm p-8 space-y-6">

            <!-- Current Images -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk Saat Ini</label>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    @foreach($product->productImages as $image)
                    <div class="relative border-2 rounded-lg overflow-hidden {{ $image->is_thumbnail ? 'border-blue-500' : 'border-gray-300' }}">
                        <img src="{{ asset('storage/' . $image->image) }}"
                            alt="Product Image"
                            class="w-full h-48 object-cover">

                        @if($image->is_thumbnail)
                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded font-semibold">
                            Thumbnail
                        </div>
                        @endif

                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 p-2 flex gap-2">
                            @if(!$image->is_thumbnail)
                            <form action="{{ route('seller.products.set-thumbnail', [$product->id, $image->id]) }}"
                                method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white text-xs py-1 rounded hover:bg-blue-700 transition">
                                    Jadikan Thumbnail
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('seller.products.delete-image', [$product->id, $image->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus gambar ini?')"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 text-white text-xs py-1 rounded hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Upload New Images -->
                @if($product->productImages->count() < 2)
                    <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tambah Gambar Baru ({{ 2 - $product->productImages->count() }} slot tersisa)
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        @for($i = 1; $i <= (2 - $product->productImages->count()); $i++)
                            <label for="new_image{{ $i }}" class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition">
                                <div id="new_preview{{ $i }}" class="hidden">
                                    <img src="" alt="Preview" class="w-full h-48 object-cover rounded-lg mb-2">
                                </div>
                                <div id="new_placeholder{{ $i }}">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-600">Klik untuk upload</p>
                                </div>
                                <input type="file" id="new_image{{ $i }}" name="images[]" accept="image/*" class="hidden" onchange="previewNewImage(this, '{{ $i }}')">
                            </label>
                            @endfor
                    </div>
            </div>
            @else
            <p class="text-sm text-gray-500 italic">Maksimal 2 gambar sudah tercapai. Hapus gambar lama untuk menambah yang baru.</p>
            @endif
        </div>

        <hr>

        <!-- Product Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
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
                <option value="{{ $category->id }}"
                    {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
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
                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition {{ old('condition', $product->condition) == 'new' ? 'border-blue-500 bg-blue-50' : '' }}">
                    <input type="radio" name="condition" value="new" class="mr-3"
                        {{ old('condition', $product->condition) == 'new' ? 'checked' : '' }} required>
                    <div>
                        <p class="font-semibold text-gray-800">Baru</p>
                        <p class="text-xs text-gray-500">Produk baru, belum pernah dipakai</p>
                    </div>
                </label>
                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition {{ old('condition', $product->condition) == 'second' ? 'border-blue-500 bg-blue-50' : '' }}">
                    <input type="radio" name="condition" value="second" class="mr-3"
                        {{ old('condition', $product->condition) == 'second' ? 'checked' : '' }} required>
                    <div>
                        <p class="font-semibold text-gray-800">Bekas</p>
                        <p class="text-xs text-gray-500">Produk second/bekas pakai</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Deskripsi Produk <span class="text-red-500">*</span>
            </label>
            <textarea name="description" rows="6"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required>{{ old('description', $product->description) }}</textarea>
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
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
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
                <input type="number" name="weight" value="{{ old('weight', $product->weight) }}"
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
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
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
                Simpan Perubahan
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
    function previewNewImage(input, imageNumber) {
        const preview = document.getElementById('new_preview' + imageNumber);
        const placeholder = document.getElementById('new_placeholder' + imageNumber);
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