<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Success Icon -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
                    <p class="text-gray-600">Terima kasih telah berbelanja di marketplace kami</p>
                </div>

                <!-- Order Info -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                            <p class="text-lg font-bold text-gray-900">{{ $transaction->code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="text-lg font-bold text-blue-600">Rp
                                {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <p class="text-sm text-gray-500 mb-1">Status Pembayaran</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $transaction->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                        </span>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-sm text-gray-500 mb-1">Metode Pengiriman</p>
                        <p class="font-semibold text-gray-900">{{ $transaction->shipping }} -
                            {{ $transaction->shipping_type }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-1">Alamat Pengiriman</p>
                        <p class="text-gray-900">{{ $transaction->address }}</p>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Produk yang Dipesan</h3>
                    <div class="space-y-4">
                        @foreach($transaction->transactionDetails as $detail)
                        <div class="flex gap-4">
                            <div class="w-20 h-20 flex-shrink-0">
                                @php
                                $thumbnail = $detail->product->productImages->first();
                                @endphp
                                @if($thumbnail)
                                <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                    alt="{{ $detail->product->name }}" class="w-full h-full object-cover rounded">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $detail->product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp
                                    {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">Rp
                                    {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <a href="{{ route('transactions.history') }}"
                        class="flex-1 bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Lihat Pesanan
                    </a>
                    <a href="{{ route('home') }}"
                        class="flex-1 bg-gray-200 text-gray-700 text-center py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>