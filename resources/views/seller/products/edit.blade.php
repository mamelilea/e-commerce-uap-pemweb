<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('seller.products.index') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-full border border-gray-200 bg-white text-xs font-medium text-gray-600 shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Produk</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded">
                    <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800 text-sm">Detail Produk</h3>
                    <p class="text-xs text-gray-500">Perbarui informasi produk.</p>
                </div>

                <div class="px-6 py-5">
                    <form action="{{ route('seller.products.update', $product) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('name') border-red-500 @enderror">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('slug') border-red-500 @enderror">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="product_category_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('product_category_id') border-red-500 @enderror">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('product_category_id', $product->product_category_id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                                <select name="condition" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('condition') border-red-500 @enderror">
                                    <option value="new" @selected(old('condition', $product->condition) === 'new')>Baru</option>
                                    <option value="second" @selected(old('condition', $product->condition) === 'second')>Bekas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('price') border-red-500 @enderror">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Berat (gram)</label>
                                <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('weight') border-red-500 @enderror">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('stock') border-red-500 @enderror">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Galeri Produk</h3>
                        <p class="text-xs text-gray-500">Atur gambar produk dan thumbnail.</p>
                    </div>
                    <form action="{{ route('seller.products.images.store', $product) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                        @csrf
                        <div>
                            <input type="file" name="image" class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                            <p class="text-[11px] text-gray-500 mt-1">Unggah satu foto.</p>
                        </div>
                        <label class="inline-flex items-center text-xs text-gray-700 gap-2">
                            <input type="checkbox" name="set_as_thumbnail" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Jadikan thumbnail
                        </label>
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            + Tambah Gambar
                        </button>
                    </form>
                </div>

                <div class="px-6 py-5">
                    @if($product->productImages->isEmpty())
                        <p class="text-gray-500 text-sm">Belum ada gambar untuk produk ini.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($product->productImages as $image)
                                <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                    <div class="aspect-square bg-gray-100">
                                        <img src="{{ asset('storage/'.$image->image) }}" alt="Gambar produk" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-3 space-y-2">
                                        @if($image->is_thumbnail)
                                            <span class="inline-flex items-center px-2 py-1 text-[11px] font-semibold rounded-full bg-green-100 text-green-800">Thumbnail</span>
                                        @endif
                                        <div class="flex items-center gap-3 text-xs">
                                            @unless($image->is_thumbnail)
                                                <form action="{{ route('seller.products.images.thumbnail', [$product, $image]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-semibold">Jadikan thumbnail</button>
                                                </form>
                                            @endunless
                                            <form action="{{ route('seller.products.images.destroy', [$product, $image]) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>