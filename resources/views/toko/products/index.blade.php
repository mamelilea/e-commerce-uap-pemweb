<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-pink-300">Kelola Produk</h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

            <a href="{{ route('toko.products.create') }}"
               class="px-4 py-2 bg-pink-300 text-white rounded-lg mb-4 inline-block">
                + Tambah Produk
            </a>

            <table class="w-full border mt-4">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="border p-2">Foto</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Harga</th>
                        <th class="border p-2">Stok</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="border p-2">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 rounded">
                            </td>
                            <td class="border p-2">{{ $product->name }}</td>
                            <td class="border p-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="border p-2">{{ $product->stock }}</td>
                            <td class="border p-2 space-x-2">
                                <a href="{{ route('seller.products.edit', $product->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-white rounded">
                                    Edit
                                </a>

                                <form action="{{ route('seller.products.delete', $product->id) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-500 text-white rounded"
                                            onclick="return confirm('Hapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">
                                Belum ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</x-app-layout>
