<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Manajemen</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produk Toko</h2>
        </div>
    </x-slot>
    <x-seller.navbar />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Daftar Produk</h3>
                        <p class="text-xs text-gray-500">Kelola produk yang tampil di toko Anda.</p>
                    </div>
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> 
                        + Tambah Produk
            </a>
                </div>

                <div class="px-6 py-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Produk</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Kategori</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Harga</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Stok</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                    @php
                                        $thumbnail = $product->productImages->firstWhere('is_thumbnail', true) ?? $product->productImages->first();
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="h-12 w-12 rounded overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                                    @if($thumbnail)
                                                        <img src="{{ asset('storage/'.$thumbnail->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                                    <p class="text-xs text-gray-500">{{ $product->condition === 'new' ? 'Baru' : 'Bekas' }} • Berat {{ $product->weight }} gr</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $product->productCategory?->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-900 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $product->stock }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Edit</a>
                                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada produk. Tambahkan produk pertama Anda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>