<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-xs text-slate-500">Detail Transaksi</p>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                    {{ $transaction->code }}
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}
                </p>
            </div>

            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-50">
                Kembali ke Pesanan
            </a>
        </div>
    </x-slot>

    <div class="grid gap-4 lg:grid-cols-5">
        {{-- Kiri: Info pengiriman & pembayaran --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-3 text-sm">
                <h3 class="text-sm font-semibold text-slate-900">Informasi Pengiriman</h3>

                <div class="space-y-1 text-slate-700">
                    <p>
                        <span class="text-slate-500 text-xs">Nama penerima</span><br>
                        <span class="font-semibold">
                            {{ $transaction->buyer->user->name ?? Auth::user()->name }}
                        </span>
                    </p>
                    <p>
                        <span class="text-slate-500 text-xs">Alamat</span><br>
                        <span>{{ $transaction->address }}</span><br>
                        <span>{{ $transaction->city }} {{ $transaction->postal_code }}</span>
                    </p>
                    <p>
                        <span class="text-slate-500 text-xs">Toko</span><br>
                        <span class="font-semibold">{{ $transaction->store->name ?? '-' }}</span>
                    </p>
                </div>

                <div class="border-t border-slate-200 pt-3 mt-2 space-y-1 text-sm">
                    <h4 class="text-xs font-semibold text-slate-500 uppercase">Pengiriman</h4>
                    <p class="text-slate-700">
                        {{ $transaction->shipping }} — {{ $transaction->shipping_type }}
                    </p>
                    <p class="text-xs text-slate-500">
                        No. Resi:
                        <span class="font-mono">
                            {{ $transaction->tracking_number ?? '-' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-3 text-sm">
                <h3 class="text-sm font-semibold text-slate-900">Pembayaran</h3>

                <p class="text-slate-700">
                    Metode Pembayaran:<br>
                    @php
                    $methodLabel = match($transaction->payment_method) {
                    'bank_transfer' => 'Transfer Bank',
                    'ewallet' => 'E-Wallet',
                    'cod' => 'Bayar di Tempat (COD)',
                    default => 'Belum dipilih (simulasi)',
                    };
                    @endphp
                    <span class="font-semibold">{{ $methodLabel }}</span>
                </p>

                <p class="text-slate-700">
                    Status Pembayaran:<br>
                    @if ($transaction->payment_status === 'paid')
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                        Lunas
                    </span>
                    @if ($transaction->paid_at)
                    <span class="block text-[11px] text-slate-500 mt-1">
                        Dibayar pada: {{ \Illuminate\Support\Carbon::parse($transaction->paid_at)->format('d M Y H:i') }}
                    </span>
                    @endif
                    @else
                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700">
                        Belum dibayar
                    </span>
                    @endif
                </p>

                @if ($transaction->payment_status !== 'paid')
                <form method="POST" action="{{ route('orders.pay', $transaction) }}" class="space-y-2">
                    @csrf

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-600">
                            Pilih Metode Pembayaran (simulasi)
                        </label>
                        <select name="payment_method"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cod">Bayar di Tempat (COD)</option>
                        </select>
                        @error('payment_method')
                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-600">
                        Bayar Sekarang (Simulasi)
                    </button>
                </form>
                @endif
            </div>

        </div>

        {{-- Kanan: daftar produk + ringkasan biaya --}}
        <div class="lg:col-span-3 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-4 text-sm">
                <h3 class="text-sm font-semibold text-slate-900">Produk yang Dibeli</h3>

                <div class="space-y-3">
                    @foreach ($transaction->transactionDetails as $detail)
                    @php
                    $product = $detail->product;
                    $firstImage = optional($product->productImages->first())->image ?? null;
                    @endphp

                    <div class="flex gap-3 border-b border-slate-100 pb-3 last:border-b-0 last:pb-0">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400">
                                Tidak ada<br>gambar
                            </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900">
                                <a href="{{ route('products.show', $product) }}"
                                    class="hover:text-emerald-600">
                                    {{ $product->name }}
                                </a>
                            </p>
                            <p class="text-xs text-slate-500">
                                Qty: {{ $detail->qty }}
                            </p>
                        </div>

                        <div class="text-right text-sm">
                            <x-currency :value="$detail->subtotal" class="font-semibold text-slate-900" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-2 text-sm">
                <h3 class="text-sm font-semibold text-slate-900 mb-2">Ringkasan Pembayaran</h3>

                <div class="flex justify-between">
                    <span class="text-slate-600">Subtotal</span>
                    <x-currency :value="$itemsSubtotal" class="font-medium text-slate-900" />
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Ongkos Kirim</span>
                    <x-currency :value="$transaction->shipping_cost" class="font-medium text-slate-900" />
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">PPN</span>
                    <x-currency :value="$transaction->tax" class="font-medium text-slate-900" />
                </div>

                <div class="border-t border-slate-200 my-2"></div>

                <div class="flex justify-between text-sm font-semibold">
                    <span class="text-slate-900">Total</span>
                    <x-currency :value="$transaction->grand_total" class="text-emerald-600" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>