@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-green-600">+{{ \App\Models\User::whereDate('created_at', '>=', now()->subDays(7))->count() }}</span> minggu ini
                    </p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Stores -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Toko Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ \App\Models\Store::where('is_verified', false)->whereNull('rejection_reason')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Menunggu verifikasi
                    </p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.stores.verify', ['status' => 'pending']) }}"
                class="text-xs text-orange-600 hover:text-orange-700 font-semibold mt-3 inline-block">
                Lihat Detail →
            </a>
        </div>

        <!-- Total Stores -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Toko</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Store::count() }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-green-600">{{ \App\Models\Store::where('is_verified', true)->count() }}</span> terverifikasi
                    </p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Product::count() }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Dari semua toko
                    </p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.stores.verify') }}"
                class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Verifikasi Toko</p>
                    <p class="text-sm text-gray-600">{{ \App\Models\Store::where('is_verified', false)->whereNull('rejection_reason')->count() }} pending</p>
                </div>
            </a>

            <a href="{{ route('admin.stores.verify', ['status' => 'verified']) }}"
                class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Toko Terverifikasi</p>
                    <p class="text-sm text-gray-600">{{ \App\Models\Store::where('is_verified', true)->count() }} toko</p>
                </div>
            </a>

            <a href="{{ route('admin.stores.verify', ['status' => 'rejected']) }}"
                class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-lg hover:border-red-500 hover:bg-red-50 transition">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Toko Ditolak</p>
                    <p class="text-sm text-gray-600">{{ \App\Models\Store::whereNotNull('rejection_reason')->count() }} toko</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Stores -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Toko Terbaru</h2>
                <a href="{{ route('admin.stores.verify') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    Lihat Semua →
                </a>
            </div>

            @php
            $recentStores = \App\Models\Store::with('user')->latest()->take(5)->get();
            @endphp

            @if($recentStores->count() > 0)
            <div class="space-y-3">
                @foreach($recentStores as $store)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                            @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $store->name }}</p>
                            <p class="text-xs text-gray-500">{{ $store->city }}</p>
                        </div>
                    </div>
                    @if($store->is_verified)
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full font-semibold">Verified</span>
                    @elseif($store->rejection_reason)
                    <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full font-semibold">Rejected</span>
                    @else
                    <span class="text-xs px-2 py-1 bg-orange-100 text-orange-800 rounded-full font-semibold">Pending</span>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">Belum ada toko terdaftar</p>
            @endif
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Pengguna Terbaru</h2>
            </div>

            @php
            $recentUsers = \App\Models\User::latest()->take(5)->get();
            @endphp

            @if($recentUsers->count() > 0)
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-gray-600">{{ substr($user->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold capitalize">
                        {{ $user->role }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">Belum ada pengguna</p>
            @endif
        </div>
    </div>

    <!-- System Info -->
    <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold mb-2">Sistem Berjalan Normal</h3>
                <p class="text-blue-100 text-sm">Semua layanan berfungsi dengan baik</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-100">Terakhir update</p>
                <p class="font-semibold">{{ now()->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection