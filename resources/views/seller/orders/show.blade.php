@extends('layouts.seller')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button & Header -->
    <div class="mb-8">
        <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Pesanan
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
                <p class="text-gray-600 mt-2">Kode Pesanan: <span class="font-mono font-semibold text-blue-600">{{ $transaction->code }}</span></p>
            </div>
            <div>
                @if($transaction->payment_status == 'paid')
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg bg-green-100 text-green-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sudah Dibayar
                </span>
                @else
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg bg-yellow-100 text-yellow-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Belum Dibayar
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        {{ $errors->first('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (Left Column) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Product Items -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Produk yang Dibeli
                </h2>
                <div class="space-y-4">
                    @foreach($transaction->transactionDetails as $detail)
                    <div class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                            @php
                            $thumbnail = $detail->product->productImages->firstWhere('is_thumbnail', true)
                            ?? $detail->product->productImages->first();
                            @endphp
                            @if($thumbnail)
                            <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                alt="{{ $detail->product->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $detail->product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $detail->product->productCategory->name }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    Rp {{ number_format($detail->product->price, 0, ',', '.') }} x {{ $detail->qty }}
                                </span>
                                <span class="font-semibold text-gray-800">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($transaction->transactionDetails->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Pengiriman ({{ $transaction->shipping }})</span>
                        <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pajak</span>
                        <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Informasi Pengiriman
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Kurir</label>
                        <p class="text-gray-800">{{ strtoupper($transaction->shipping) }} - {{ $transaction->shipping_type }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Alamat Pengiriman</label>
                        <p class="text-gray-800">{{ $transaction->address }}</p>
                        <p class="text-gray-600 text-sm">{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Right Column) -->
        <div class="space-y-6">

            <!-- Buyer Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Pembeli
                </h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama</label>
                        <p class="text-gray-800">{{ $transaction->buyer->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <p class="text-gray-800">{{ $transaction->buyer->user->email }}</p>
                    </div>
                    @if($transaction->buyer->phone_number)
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Telepon</label>
                        <p class="text-gray-800">{{ $transaction->buyer->phone_number }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tracking Number Management -->
            @if($transaction->payment_status == 'paid')
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Nomor Resi
                </h2>

                @if($transaction->tracking_number)
                <!-- Show Existing Tracking Number -->
                <div class="mb-4 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <label class="text-sm font-semibold text-gray-600 block mb-2">Nomor Resi Saat Ini</label>
                    <p class="font-mono text-lg font-bold text-purple-700">{{ $transaction->tracking_number }}</p>
                </div>

                <!-- Update Form -->
                <form action="{{ route('seller.orders.update-tracking', $transaction->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Perbarui Nomor Resi</label>
                    <div class="flex gap-2">
                        <input type="text"
                            name="tracking_number"
                            value="{{ old('tracking_number', $transaction->tracking_number) }}"
                            placeholder="Masukkan nomor resi baru"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold whitespace-nowrap">
                            Update
                        </button>
                    </div>
                    @error('tracking_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </form>

                <!-- Delete Button -->
                <form action="{{ route('seller.orders.remove-tracking', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nomor resi?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition font-semibold text-sm">
                        Hapus Nomor Resi
                    </button>
                </form>

                @else
                <!-- Add Tracking Number Form -->
                <form action="{{ route('seller.orders.update-tracking', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Nomor Resi</label>
                    <div class="flex gap-2">
                        <input type="text"
                            name="tracking_number"
                            value="{{ old('tracking_number') }}"
                            placeholder="Contoh: JNE123456789"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold whitespace-nowrap">
                            Simpan
                        </button>
                    </div>
                    @error('tracking_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </form>
                <p class="text-sm text-gray-500 mt-3">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Masukkan nomor resi setelah paket dikirim oleh kurir
                </p>
                @endif
            </div>
            @else
            <!-- Payment Not Completed Warning -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-800 mb-1">Menunggu Pembayaran</h3>
                        <p class="text-sm text-yellow-700">
                            Pesanan ini belum dibayar oleh pembeli. Nomor resi hanya bisa diinput setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Order Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pesanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Pesanan</span>
                        <span class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kode Transaksi</span>
                        <span class="font-mono font-semibold text-blue-600">{{ $transaction->code }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection