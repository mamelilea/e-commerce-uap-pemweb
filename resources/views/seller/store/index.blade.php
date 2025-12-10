@extends('layouts.seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Profil Toko</h1>
            <p class="text-gray-600 mt-2">Informasi lengkap tentang toko Anda</p>
        </div>
        <a href="{{ route('seller.store.edit') }}"
            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Profil Toko
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Store Status -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 {{ $store->is_verified ? 'bg-green-100' : 'bg-yellow-100' }} rounded-full flex items-center justify-center">
                    @if($store->is_verified)
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @else
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Status Toko</h3>
                    @if($store->is_verified)
                    <p class="text-green-600 font-semibold">✓ Terverifikasi</p>
                    @else
                    <p class="text-yellow-600 font-semibold">⏳ Menunggu Verifikasi Admin</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Store Profile Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column - Logo & Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Logo Toko</h2>

                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
                    @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}"
                        alt="{{ $store->name }}"
                        class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    @endif
                </div>

                @if($store->logo)
                <form action="{{ route('seller.store.delete-logo') }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus logo toko?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-100 text-red-700 py-2 rounded-lg hover:bg-red-200 transition font-semibold text-sm">
                        Hapus Logo
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Right Column - Store Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Toko</h2>

                <div class="space-y-6">
                    <!-- Store Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Toko</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $store->name }}</p>
                    </div>

                    <!-- About -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Tentang Toko</label>
                        <p class="text-gray-800 leading-relaxed">{{ $store->about }}</p>
                    </div>

                    <hr>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Telepon</p>
                                    <p class="text-gray-800 font-semibold">{{ $store->phone }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Pemilik</p>
                                    <p class="text-gray-800 font-semibold">{{ $store->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Address -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Alamat Toko</h3>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 leading-relaxed">{{ $store->address }}</p>
                                <p class="text-gray-600 mt-2">
                                    {{ $store->city }}, {{ $store->postal_code }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Statistics -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Toko</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $store->products->count() }}</p>
                                <p class="text-sm text-gray-600 mt-1">Produk</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $store->transactions->count() }}</p>
                                <p class="text-sm text-gray-600 mt-1">Transaksi</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4 text-center">
                                <p class="text-3xl font-bold text-purple-600">
                                    {{ $store->created_at->diffForHumans() }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Bergabung</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection