<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                Keranjang Belanja
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Cek kembali produk yang ingin kamu beli sebelum checkout.
            </p>
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- Alert --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Jika keranjang kosong --}}
        @if ($items->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center space-y-3">
                <p class="text-sm text-slate-600">
                    Keranjangmu masih kosong.
                </p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-emerald-500 text-white hover:bg-emerald-600">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid gap-4 lg:grid-cols-3">

                {{-- List item --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-4">
                    @foreach ($items as $item)
                        @php
                            $product = $item['product'];
                            $qty     = $item['qty'];
                            $subtotal = $item['subtotal'];
                            $firstImage = optional($product->productImages->first())->image;
                        @endphp

                        <div class="flex gap-4 border-b border-slate-100 pb-4 last:border-b-0 last:pb-0">
                            {{-- Gambar --}}
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
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

                            {{-- Info produk --}}
                            <div class="flex-1 space-y-1">
                                <a href="{{ route('products.show', $product) }}"
                                   class="text-sm font-semibold text-slate-900 hover:text-emerald-600">
                                    {{ $product->name }}
                                </a>

                                @if ($product->store)
                                    <p class="text-xs text-slate-500">
                                        {{ $product->store->name }}
                                    </p>
                                @endif

                                <x-currency :value="$product->price"
                                            class="text-sm font-semibold text-emerald-600" />
                            </div>

                            {{-- Qty + subtotal + aksi --}}
                            <div class="flex flex-col items-end gap-2 text-right">
                                {{-- Qty --}}
                                <form method="POST" action="{{ route('cart.update', $product) }}"
                                      class="flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')

                                    <input type="number" name="qty" min="1"
                                           value="{{ $qty }}"
                                           class="w-16 rounded-lg border border-slate-200 px-2 py-1 text-xs text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <button type="submit"
                                            class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700">
                                        Update
                                    </button>
                                </form>

                                {{-- Subtotal --}}
                                <x-currency :value="$subtotal"
                                            class="text-sm font-semibold text-slate-900" />

                                {{-- Aksi --}}
                                <div class="flex items-center gap-2">
                                    {{-- Checkout item ini --}}
                                    <a href="{{ route('checkout.start', $product) }}"
                                       class="inline-flex items-center rounded-full bg-emerald-500 px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-emerald-600">
                                        Checkout
                                    </a>

                                    {{-- Hapus dari cart --}}
                                    <form method="POST" action="{{ route('cart.remove', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1.5 text-[11px] font-semibold text-slate-600 hover:bg-slate-50"
                                                onclick="return confirm('Hapus produk ini dari keranjang?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-slate-900">Ringkasan Keranjang</h3>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">Total</span>
                        <x-currency :value="$total" class="text-lg font-bold text-emerald-600" />
                    </div>

                    <div class="border-t border-slate-200 pt-4 mt-2 space-y-2">
                        <a href="{{ route('home') }}"
                           class="w-full inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            Lanjut Belanja
                        </a>

                        <form method="POST" action="{{ route('cart.clear') }}"
                              onsubmit="return confirm('Kosongkan semua isi keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center rounded-full bg-red-500 px-4 py-2 text-xs font-semibold text-white hover:bg-red-600">
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>

                    <p class="text-[11px] text-slate-500">
                        Untuk saat ini checkout masih dilakukan per produk.  
                        Tekan tombol <strong>Checkout</strong> pada produk yang ingin kamu beli.
                    </p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
