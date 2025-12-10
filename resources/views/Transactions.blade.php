<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Transaksi</h1>
                <p class="text-gray-600 mt-1">Semua pesanan Anda</p>
            </div>

            <!-- Filter Status -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('transactions.history') }}"
                        class="px-4 py-2 rounded-lg transition {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('transactions.history', ['status' => 'unpaid']) }}"
                        class="px-4 py-2 rounded-lg transition {{ request('status') == 'unpaid' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Belum Bayar
                    </a>
                    <a href="{{ route('transactions.history', ['status' => 'paid']) }}"
                        class="px-4 py-2 rounded-lg transition {{ request('status') == 'paid' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Sudah Bayar
                    </a>
                </div>
            </div>

            <!-- Transactions List -->
            @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    <!-- Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                            <p class="font-bold text-gray-900">{{ $transaction->code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pembelian</p>
                            <p class="font-semibold text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $transaction->payment_status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </span>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <!-- Store Info -->
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span class="font-semibold text-gray-700">{{ $transaction->store->name }}</span>
                        </div>

                        <!-- Products -->
                        <div class="space-y-3 mb-4">
                            @foreach($transaction->transactionDetails->take(2) as $detail)
                            <div class="flex gap-4">
                                <div class="w-16 h-16 flex-shrink-0">
                                    @php
                                    $thumbnail = $detail->product->productImages->first();
                                    @endphp
                                    @if($thumbnail)
                                    <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                        alt="{{ $detail->product->name }}" class="w-full h-full object-cover rounded">
                                    @else
                                    <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $detail->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp
                                        {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach

                            @if($transaction->transactionDetails->count() > 2)
                            <p class="text-sm text-gray-500 italic">
                                +{{ $transaction->transactionDetails->count() - 2 }} produk lainnya
                            </p>
                            @endif
                        </div>

                        <!-- Total & Action -->
                        <div class="flex flex-wrap justify-between items-center pt-4 border-t gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Total Belanja</p>
                                <p class="text-xl font-bold text-gray-900">Rp
                                    {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                @if($transaction->payment_status === 'unpaid')
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                    Bayar Sekarang
                                </button>
                                @endif
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-16 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="mt-6 text-2xl font-bold text-gray-800">Belum Ada Transaksi</h3>
                <p class="mt-3 text-gray-600">
                    Anda belum memiliki riwayat transaksi
                </p>
                <a href="{{ route('home') }}"
                    class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Mulai Belanja
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>