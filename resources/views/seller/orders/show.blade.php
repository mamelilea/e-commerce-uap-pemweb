<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <a href="{{ route('seller.orders.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ __('Detail Pesanan: #') . $transaction->code }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Left Column: Order Items & Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-2xl border border-white/10 group hover:shadow-[0_0_30px_rgba(255,255,255,0.05)] transition-all duration-500 hover:border-white/20">
                        <div class="p-6 bg-[#161616] border-b border-white/10">
                            <h3 class="text-lg font-bold mb-4 text-[#EDEDEC]">Produk yang Dipesan</h3>
                             <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-white/10">
                                    <tbody class="divide-y divide-white/5">
                                        @foreach ($transaction->transactionDetails as $detail)
                                            <tr>
                                                <td class="py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="h-16 w-16 flex-shrink-0">
                                                            @if($detail->product->thumbnail && $detail->product->thumbnail->image)
                                                             <img class="h-16 w-16 rounded-md object-cover bg-white/5 border border-white/10" src="{{ asset('storage/' . $detail->product->thumbnail->image) }}" alt="{{ $detail->product->name }}">
                                                            @else
                                                             <img class="h-16 w-16 rounded-md object-cover bg-white/5 border border-white/10" src="{{ asset('images/default-product.png') }}" alt="{{ $detail->product->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-[#EDEDEC]">{{ $detail->product->name }}</div>
                                                            <div class="text-sm text-gray-400">{{ $detail->qty }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 whitespace-nowrap text-right text-sm font-medium text-[#EDEDEC]">
                                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-2xl border border-white/10 group hover:shadow-[0_0_30px_rgba(99,102,241,0.1)] transition-all duration-500 hover:border-indigo-500/20">
                         <div class="p-6 bg-[#161616] border-b border-white/10 text-[#EDEDEC]">
                            <h3 class="text-lg font-bold mb-4">Informasi Pengiriman</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400 uppercase font-bold">Penerima</p>
                                    <p class="font-medium">{{ optional($transaction->buyer->user)->name ?? 'Guest' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400 uppercase font-bold">Email</p>
                                    <p class="font-medium">{{ optional($transaction->buyer->user)->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400 uppercase font-bold">No. Telepon</p>
                                    <p class="font-medium">{{ optional($transaction->buyer)->phone_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400 uppercase font-bold">Alamat</p>
                                    <p class="font-medium">{{ $transaction->address }}</p>
                                    <p>{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- Right Column: Summary & Actions -->
                <div class="md:col-span-1 space-y-6">
                    
                    <!-- Order Summary -->
                    <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-2xl border border-white/10 group hover:shadow-[0_0_30px_rgba(16,185,129,0.1)] transition-all duration-500 hover:border-green-500/20">
                        <div class="p-6 bg-[#161616] border-b border-white/10 text-[#EDEDEC]">
                            <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Metode Pengiriman</span>
                                <span class="font-bold capitalize">{{ str_replace('_', ' ', $transaction->shipping_type) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Ongkos Kirim</span>
                                <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                             <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Pajak (11%)</span>
                                <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-4 border-white/10">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Bayar</span>
                                <span class="text-indigo-400">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </div>
                             <div class="mt-4 space-y-2">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $transaction->payment_status === 'paid' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                    Pembayaran: {{ ucfirst($transaction->payment_status) }}
                                </span>
                                <br>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $transaction->delivery_status === 'shipped' ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : ($transaction->delivery_status === 'delivered' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20') }}">
                                    Pengiriman: {{ ucfirst($transaction->delivery_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                     <!-- Actions / Tracking Number -->
                    <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-2xl border border-white/10 group hover:shadow-[0_0_30px_rgba(59,130,246,0.1)] transition-all duration-500 hover:border-blue-500/20">
                         <div class="p-6 bg-[#161616] border-b border-white/10 text-[#EDEDEC]">
                             
                             @if (session('success'))
                                <div class="mb-4 text-sm text-green-400 font-bold">
                                    {{ session('success') }}
                                </div>
                             @endif
                             
                             @if (session('error'))
                                <div class="mb-4 text-sm text-red-400 font-bold">
                                    {{ session('error') }}
                                </div>
                             @endif

                            @if($transaction->delivery_status === 'completed')
                                <div class="mb-3 p-3 bg-green-500/10 border border-green-500/20 rounded-md text-center">
                                    <span class="text-green-400 font-bold text-sm">Pesanan Selesai</span>
                                    <p class="text-xs text-green-300/70 mt-1">Pesanan telah diterima oleh pembeli.</p>
                                </div>
                            
                            @elseif($transaction->delivery_status === 'shipped')
                                <div class="mb-3 p-3 bg-blue-500/10 border border-blue-500/20 rounded-md text-center">
                                    <span class="text-blue-400 font-bold text-sm">Pesanan Sedang Dikirim</span>
                                    <p class="text-xs text-blue-300/70 mt-1">Resi: {{ $transaction->tracking_number }}</p>
                                </div>
                             @endif

                             @if($transaction->delivery_status === 'pending' || is_null($transaction->delivery_status))
                                <h3 class="text-lg font-bold mb-4">Aksi Pesanan</h3>
                                <div class="flex flex-col gap-3">
                                    @if($transaction->payment_status === 'paid')
                                        <form action="{{ route('seller.orders.confirm', $transaction->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full group/btn relative overflow-hidden flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:scale-[1.02] hover:shadow-blue-500/50" onclick="return confirm('Apakah anda yakin ingin mengirim pesanan ini? Resi akan dibuat otomatis.')">
                                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                                                <div class="flex items-center gap-2 relative z-10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                    Kirim Pesanan
                                                </div>
                                            </button>
                                        </form>
                                    @else
                                        <div class="mb-3 p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-md text-center">
                                            <span class="text-yellow-400 font-bold text-sm">Menunggu Pembayaran</span>
                                            <p class="text-xs text-yellow-300/70 mt-1">Pesanan belum dibayar oleh customer.</p>
                                        </div>
                                    @endif
                                </div>

                             @elseif($transaction->delivery_status === 'canceled')
                                <div class="text-center p-4 bg-red-500/10 border border-red-500/20 rounded-md">
                                    <h3 class="text-lg font-bold text-red-400 mb-2">Pesanan Ditolak</h3>
                                    <p class="text-sm text-red-300">Pesanan ini telah dibatalkan/ditolak oleh toko.</p>
                                </div>

                             @else
                                 <h3 class="text-lg font-bold mb-4">Update Resi</h3>
                                 <form>
                                    <div class="mb-4">
                                        <label for="tracking_number" class="block text-sm font-medium text-gray-400">Nomor Resi</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" id="tracking_number" 
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-white/10 bg-[#0a0a0a] text-[#EDEDEC] cursor-not-allowed"
                                                   value="{{ $transaction->tracking_number }}" readonly>
                                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-white/10 bg-white/5 text-gray-400 text-sm">
                                                Otomatis
                                            </span>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">Resi dibuat otomatis oleh sistem.</p>
                                    </div>
                                 </form>
                             @endif
                         </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-seller-layout>
