@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Pengguna
        </a>
    </div>

    <!-- User Info Card -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center">
                    <span class="text-3xl font-bold text-gray-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $user->role == 'seller' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->role == 'customer' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit User
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus User
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- User Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2">Informasi Akun</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">ID Pengguna</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tanggal Daftar</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Terakhir Update</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($user->role == 'seller')
            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-2">Informasi Toko</h3>
                @if($user->store)
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Nama Toko</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->store->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Lokasi</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->store->city }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        @if($user->store->is_verified)
                        <span
                            class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full font-semibold">Verified</span>
                        @elseif($user->store->rejection_reason)
                        <span
                            class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full font-semibold">Rejected</span>
                        @else
                        <span
                            class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold">Pending</span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('admin.stores.show', $user->store->id) }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Lihat Detail Toko →
                        </a>
                    </div>
                </div>
                @else
                <p class="text-sm text-gray-500">Belum memiliki toko</p>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Store Products (if seller) -->
    @if($user->role == 'seller' && $user->store && $user->store->products->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Produk Toko</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($user->store->products->take(8) as $product)
            <div class="border rounded-lg p-3 hover:shadow-md transition">
                <div class="w-full h-32 bg-gray-200 rounded-lg mb-2 overflow-hidden">
                    @if($product->productImages->first())
                    <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}"
                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <h3 class="font-semibold text-sm text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
            </div>
            @endforeach
        </div>
        @if($user->store->products->count() > 8)
        <div class="mt-4 text-center">
            <a href="{{ route('admin.stores.show', $user->store->id) }}"
                class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                Lihat Semua Produk ({{ $user->store->products->count() }}) →
            </a>
        </div>
        @endif
    </div>
    @endif

    <!-- Customer Transactions -->
    @if($user->role == 'customer' && $transactions->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Transaksi (10 Terakhir)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $transaction->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->store->name }}
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