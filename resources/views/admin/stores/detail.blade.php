@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Toko
        </a>
    </div>

    <!-- Store Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                    @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}"
                        class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h1>
                    <p class="text-gray-600">{{ $store->city }}</p>
                    <div class="flex gap-2 mt-2">
                        @if($store->is_verified)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            ✓ Verified
                        </span>
                        @elseif($store->rejection_reason)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            ✗ Rejected
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            ⏳ Pending
                        </span>
                        @endif

                        @if($store->status == 'active')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Active
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            Suspended
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                @if($store->status == 'active')
                <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin suspend toko ini?')">
                    @csrf
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Suspend Toko
                    </button>
                </form>
                @else
                <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Aktifkan Toko
                    </button>
                </form>
                @endif

                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus toko ini? Semua produk akan ikut terhapus!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Toko
                    </button>
                </form>
            </div>
        </div>

        <!-- Store Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 border-t pt-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Informasi Pemilik</h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs text-gray-500">Nama</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->user->email }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.show', $store->user->id) }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Lihat Profile User →
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Informasi Toko</h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs text-gray-500">Deskripsi</p>
                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($store->description, 100) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Alamat</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->address }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Produk</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->products_count }} produk</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Timeline</h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs text-gray-500">Tanggal Daftar</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @if($store->verified_at)
                    <div>
                        <p class="text-xs text-gray-500">Tanggal Verifikasi</p>
                        <p class="text-sm font-medium text-gray-900">{{ $store->verified_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    @if($store->rejection_reason)
                    <div>
                        <p class="text-xs text-gray-500">Alasan Ditolak</p>
                        <p class="text-sm font-medium text-red-600">{{ $store->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Store Products -->
    @if($store->products->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Produk Toko ({{ $store->products_count }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($store->products as $product)
            <div class="border rounded-lg p-3 hover:shadow-md transition">
                <div class="w-full h-32 bg-gray-200 rounded-lg mb-2 overflow-hidden">
                    @if($product->productImages->first())
                    <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}"
                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <h3 class="font-semibold text-sm text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="flex justify-between items-center mt-2">
                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                    <span
                        class="text-xs px-2 py-1 rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-6">
        <p class="text-center text-gray-500 py-8">Toko belum memiliki produk</p>
    </div>
    @endif

    <!-- Transactions (if available) -->
    @if($transactions->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Transaksi Terakhir (10)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $transaction->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->buyer->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $transaction->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection