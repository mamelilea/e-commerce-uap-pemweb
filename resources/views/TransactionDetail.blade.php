<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Transaksi</h1>
                        <p class="text-gray-600 mt-1">{{ $transaction->code }}</p>
                    </div>
                    <a href="{{ route('transactions.history') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                        Kembali
                    </a>
                </div>

                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Status Pembayaran</p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold mt-1
                                {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $transaction->payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </span>
                        </div>
                        @if($transaction->payment_status === 'unpaid')
                        <button
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Bayar Sekarang
                        </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pembelian</p>
                            <p class="font-semibold text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Resi</p>
                            <p class="font-semibold text-gray-900">
                                {{ $transaction->tracking_number ?? 'Belum ada resi' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Store Info -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Informasi Toko
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-lg font-bold text-gray-600">
                                {{ strtoupper(substr($transaction->store->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $transaction->store->name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->store->city }}</p>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="font-bold text-gray-900 mb-4">Produk yang Dibeli</h2>
                    <div class="space-y-4">
                        @foreach($transaction->transactionDetails as $detail)
                        <div class="flex gap-4 pb-4 border-b last:border-b-0">
                            <div class="w-20 h-20 flex-shrink-0">
                                @php
                                $thumbnail = $detail->product->productImages->first();
                                @endphp
                                @if($thumbnail)
                                <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                    alt="{{ $detail->product->name }}" class="w-full h-full object-cover rounded">
                                @else
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <a href="{{ route('products.show', $detail->product_id) }}"
                                    class="font-semibold text-gray-900 hover:text-blue-600">
                                    {{ $detail->product->name }}
                                </a>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $detail->qty }} x Rp
                                    {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}
                                </p>
                                <p class="text-sm font-semibold text-gray-900 mt-2">
                                    Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>

                            @if($transaction->payment_status === 'paid')
                            <div>
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                    Beli Lagi
                                </button>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Alamat Pengiriman</p>
                            <p class="text-gray-900">{{ $transaction->address }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Metode Pengiriman</p>
                            <p class="font-semibold text-gray-900">
                                {{ $transaction->shipping }} - {{ $transaction->shipping_type }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Ongkir: Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="font-bold text-gray-900 mb-4">Rincian Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal Produk ({{ $transaction->transactionDetails->sum('qty') }} item)</span>
                            <span class="font-semibold">
                                Rp {{ number_format($transaction->transactionDetails->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-semibold">Rp
                                {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Pajak</span>
                            <span class="font-semibold">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600">Rp
                                {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($transaction->payment_status === 'paid')
                <div class="flex gap-4 mt-6">
                    <button
                        class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        Pesanan Diterima
                    </button>
                    <button
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                        Hubungi Penjual
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>