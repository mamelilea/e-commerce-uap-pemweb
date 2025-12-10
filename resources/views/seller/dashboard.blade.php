<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Dashboard</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Penjual</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau kinerja toko dan kelola kebutuhan seller dari satu tempat.</p>
        </div>
    </x-slot>

    @if (! $store || ! $store->is_verified)
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-10 sm:p-14 text-center space-y-6">
                        <div class="text-6xl font-black text-gray-100">404</div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 text-sm font-semibold uppercase tracking-wide">
                            {{ $store ? 'Akun Toko Belum Terverifikasi' : 'Toko Belum Terdaftar' }}
                        </div>
                        <div class="space-y-3 max-w-2xl mx-auto">
                            <h3 class="text-2xl font-semibold text-gray-800">Akses dashboard penjual belum tersedia</h3>
                            <p class="text-gray-600">
                                @if ($store)
                                    Kami sedang memproses verifikasi toko Anda. Setelah disetujui oleh tim admin, Anda dapat mulai mengelola produk, pesanan, dan saldo dari dashboard ini.
                                @else
                                    Anda belum memiliki toko yang dapat diakses. Daftarkan toko terlebih dahulu untuk membuka dashboard penjual.
                                @endif
                            </p>
                            @if ($store)
                                <div class="grid sm:grid-cols-2 gap-3 text-sm text-left bg-gray-50 border border-gray-100 rounded-xl p-4">
                                    <div>
                                        <p class="text-gray-500">Nama Toko</p>
                                        <p class="font-semibold text-gray-800">{{ $store->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Kontak Toko</p>
                                        <p class="font-semibold text-gray-800">{{ $store->phone ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800">
                                Kembali ke Beranda
                            </a>
                            @if ($store)
                                <a href="{{ route('seller.profile.edit') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Perbarui Profil Toko
                                </a>
                            @else
                                <a href="{{ route('stores.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Daftarkan Toko
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Produk</p>
                            <div class="h-9 w-9 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mt-3">{{ $metrics['products'] }}</h3>
                        <p class="text-sm text-gray-500">Total produk aktif di toko</p>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wide text-indigo-500">Pesanan</p>
                            <div class="h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-1.5 13.5a2 2 0 01-2 1.5H6.5a2 2 0 01-2-1.5L3 3z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mt-3">{{ $metrics['orders'] }}</h3>
                        <p class="text-sm text-gray-500">Total pesanan yang masuk</p>
                    </div>
                    
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-500">Saldo</p>
                            <div class="h-9 w-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.38 0 2.5.895 2.5 2S13.38 12 12 12s-2.5.895-2.5 2S10.62 16 12 16m0-8V6m0 10v2" />
                                </svg>
                            </div>
                        </div>
                            <h3 class="text-3xl font-bold text-gray-900 mt-3">Rp {{ number_format($metrics['balance'], 0, ',', '.') }}</h3>
                            <p class="text-sm text-gray-500">Saldo tersedia di dompet toko</p>
                        </div>
                    </div>
                    
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Aktivitas</p>
                                    <h3 class="font-semibold text-gray-800">Pesanan Terbaru</h3>
                                </div>
                                <a href="{{ route('seller.orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                    
                     <div class="space-y-4">
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Navigasi</p>
                                <h3 class="font-semibold text-gray-800">Akses Cepat</h3>
                            </div>
                            <div class="p-4 space-y-3">
                                <a href="{{ route('seller.products.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Kelola Produk</p>
                                        <p class="text-xs text-gray-500">Tambah, ubah, atau hapus produk.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('seller.categories.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Kategori Produk</p>
                                        <p class="text-xs text-gray-500">Atur kategori untuk memudahkan pembeli.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('seller.orders.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Kelola Pesanan</p>
                                        <p class="text-xs text-gray-500">Update status dan nomor resi.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('seller.balance.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Saldo & Mutasi</p>
                                        <p class="text-xs text-gray-500">Lihat saldo toko dan riwayat transaksi.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('seller.withdrawals.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Penarikan Dana</p>
                                        <p class="text-xs text-gray-500">Ajukan pencairan dan kelola rekening.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('seller.profile.edit') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Profil Toko</p>
                                        <p class="text-xs text-gray-500">Perbarui informasi dan identitas toko.</p>
                                    </div>
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         @endif
</x-app-layout>