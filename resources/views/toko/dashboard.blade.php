<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('Home Toko') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center">

                {{-- Cek apakah user sudah punya toko --}}
                @if (auth()->user()->store)
                    {{-- Jika sudah punya toko --}}
                    <h3 class="text-gray-700 text-lg font-semibold mb-4">
                        Selamat datang di toko kamu, {{ auth()->user()->store->name }} 🌸
                    </h3>

                    @if (!auth()->user()->store->is_verified)
                        <p class="text-gray-600">
                            Toko kamu masih menunggu verifikasi dari admin.
                        </p>
                    @else
                        <p class="text-gray-600 mb-8">
                            Toko kamu sudah terverifikasi ✅  
                            Sekarang kamu bisa mulai mengelola toko kamu!
                        </p>

                        {{-- Tombol Navigasi --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">

                            {{-- Kelola Pesanan --}}
                            <a href="{{ route('toko.orders.home') }}"
                               class="block w-full sm:w-auto px-6 py-4 bg-pink-300 text-white rounded-xl shadow-md hover:bg-pink-400 font-semibold transition">
                                🛒 Kelola Pesanan
                            </a>

                            {{-- Tambah Produk --}}
                            <a href="{{ route('toko.products.create') }}"
                            class="block w-full sm:w-auto px-6 py-4 bg-pink-300 text-white rounded-xl shadow-md hover:bg-pink-400 font-semibold transition">
                                🌼 Tambah Produk
                            </a>

                            {{-- Lihat Saldo --}}
                            <a href="{{ route('toko.saldo.index') }}"
                               class="block w-full sm:w-auto px-6 py-4 bg-pink-300 text-white rounded-xl shadow-md hover:bg-pink-400 font-semibold transition">
                                💰 Lihat Saldo
                            </a>

                            {{-- Penarikan --}}
                            <a href="{{ route('toko.withdraw.home') }}"
                               class="block w-full sm:w-auto px-6 py-4 bg-pink-300 text-white rounded-xl shadow-md hover:bg-pink-400 font-semibold transition">
                                💸 Penarikan
                            </a>

                            {{-- Kelola Profil Toko --}}
                            <a href="{{ route('toko.products.index') }}"
                            class="block w-full sm:w-auto px-6 py-4 bg-pink-300 text-white rounded-xl shadow-md hover:bg-pink-400 font-semibold transition">
                                🏪 Kelola Profil Toko
                            </a>
                        </div>
                    @endif

                @else
                    {{-- Jika belum punya toko --}}
                    <div class="text-center py-10 px-6">
                        <h3 class="text-gray-700 text-lg font-semibold mb-4">
                            Kamu belum memiliki toko.
                        </h3>

                        <p class="text-gray-600 mb-6">
                            Daftarkan toko kamu untuk mulai berjualan di NaCup Florist 🌷
                        </p>

                        <a href="{{ route('toko.register') }}"
                           class="inline-block px-6 py-3 bg-pink-300 hover:bg-pink-400 text-white font-semibold rounded-lg shadow-md transition">
                            Daftarkan Toko Sekarang
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
