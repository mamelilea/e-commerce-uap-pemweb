<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-pink-300">
            Tambah Produk
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md">

            <form action="{{ route('toko.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="font-medium">Nama Produk</label>
                    <input type="text" name="name" class="w-full p-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="font-medium">Deskripsi</label>
                    <textarea name="description" class="w-full p-2 border rounded-lg"></textarea>
                </div>

                <div>
                    <label class="font-medium">Kategori Produk</label>
                    <select name="product_category_id" class="w-full p-2 border rounded-lg" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-medium">Harga</label>
                    <input type="number" name="price" class="w-full p-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="font-medium">Stok</label>
                    <input type="number" name="stock" class="w-full p-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="font-medium">Gambar Produk</label>
                    <input type="file" name="image" class="w-full p-2 border rounded-lg">
                </div>

                <button class="px-6 py-3 bg-pink-300 text-white rounded-lg shadow hover:bg-pink-400">
                    Simpan Produk
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
