<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Manajemen</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori Produk</h2>
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
                        <h3 class="font-semibold text-gray-800 text-sm">Daftar Kategori</h3>
                        <p class="text-xs text-gray-500">Kelola kategori produk toko Anda.</p>
                    </div>
                    <a href="{{ route('seller.categories.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-auto self-end">
                        + Tambah Kategori
                    </a>
                </div>

                <div class="px-6 py-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Slug</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Induk</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Tagline</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                                            <p class="text-xs text-gray-500 line-clamp-2">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $category->slug }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $category->parent?->name ?? 'Induk Utama' }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $category->tagline ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('seller.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Edit</a>
                                                <form action="{{ route('seller.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada kategori. Tambahkan kategori pertama Anda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>