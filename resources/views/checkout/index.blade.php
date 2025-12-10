<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                Checkout Produk
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Isi detail pengiriman dan konfirmasi pesananmu.
            </p>
        </div>
    </x-slot>

    <div class="max-w-4xl space-y-4">

        @if (session('error'))
            <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Informasi produk --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 flex gap-4">
            @php
                $firstImage = optional($product->productImages->first())->image;
            @endphp

            <div class="w-28 h-28 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                @if ($firstImage)
                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            <div class="flex-1 space-y-1">
                <h3 class="text-lg font-semibold text-slate-900">
                    {{ $product->name }}
                </h3>
                <p class="text-sm text-slate-500">
                    Toko: {{ $product->store->name ?? 'Tidak diketahui' }}
                </p>
                @if ($product->productCategory)
                    <p class="text-xs text-emerald-600">
                        Kategori: {{ $product->productCategory->name }}
                    </p>
                @endif
                <x-currency :value="$product->price" class="block text-xl font-bold text-emerald-600 mt-2" />
            </div>

            <div class="w-32">
                <label class="block text-xs font-medium text-slate-600 mb-1">
                    Jumlah
                </label>
                <input type="number" name="qty" form="checkout-form"
                       min="1"
                       value="{{ old('qty', $qty) }}"
                       class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                @error('qty')
                    <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Form checkout --}}
        <form id="checkout-form" method="POST" action="{{ route('checkout.process', $product) }}"
              class="grid gap-4 lg:grid-cols-5">
            @csrf

            {{-- Alamat --}}
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-3">
                    <h3 class="text-sm font-semibold text-slate-900">Alamat Pengiriman</h3>

                    <div class="space-y-1">
                        <label for="address" class="text-xs font-medium text-slate-600">
                            Alamat lengkap
                        </label>
                        <textarea id="address" name="address" rows="3"
                                  class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="city" class="text-xs font-medium text-slate-600">
                                Kota / Kabupaten
                            </label>
                            <input id="city" name="city" type="text"
                                   value="{{ old('city') }}"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('city')
                                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="postal_code" class="text-xs font-medium text-slate-600">
                                Kode Pos
                            </label>
                            <input id="postal_code" name="postal_code" type="text"
                                   value="{{ old('postal_code') }}"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('postal_code')
                                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengiriman + Ringkasan --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-3">
                    <h3 class="text-sm font-semibold text-slate-900">Metode Pengiriman</h3>

                    <div class="space-y-2">
                        @foreach ($shippingOptions as $option)
                            <label class="flex items-center justify-between gap-2 rounded-xl border px-3 py-2 text-xs sm:text-sm cursor-pointer
                                           {{ old('shipping_option', $shippingOptions[0]['code']) === $option['code'] ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/40' }}">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="shipping_option" value="{{ $option['code'] }}"
                                           class="text-emerald-500 focus:ring-emerald-500"
                                           {{ old('shipping_option', $shippingOptions[0]['code']) === $option['code'] ? 'checked' : '' }}>
                                    <span class="font-medium text-slate-800">{{ $option['name'] }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">{{ $option['type'] }}</p>
                                    <x-currency :value="$option['cost']" class="text-xs font-semibold text-slate-900" />
                                </div>
                            </label>
                        @endforeach
                        @error('shipping_option')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Ringkasan biaya (estimasi, dihitung lagi di controller) --}}
                @php
                    $qtyLocal = old('qty', $qty);
                    $subtotalLocal = $product->price * $qtyLocal;
                    $selectedCode = old('shipping_option', $shippingOptions[0]['code']);
                    $selectedLocal = collect($shippingOptions)->firstWhere('code', $selectedCode);
                    $shippingCostLocal = $selectedLocal['cost'] ?? 0;
                    $taxLocal = round($subtotalLocal * 0.11, 2);
                    $grandTotalLocal = $subtotalLocal + $shippingCostLocal + $taxLocal;
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-2 text-sm">
                    <h3 class="text-sm font-semibold text-slate-900 mb-2">Ringkasan Pembayaran</h3>

                    <div class="flex justify-between">
                        <span class="text-slate-600">Subtotal ({{ $qtyLocal }} x)</span>
                        <x-currency :value="$subtotalLocal" class="font-medium text-slate-900" />
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Ongkos kirim</span>
                        <x-currency :value="$shippingCostLocal" class="font-medium text-slate-900" />
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">PPN 11%</span>
                        <x-currency :value="$taxLocal" class="font-medium text-slate-900" />
                    </div>

                    <div class="border-t border-slate-200 my-2"></div>

                    <div class="flex justify-between text-sm font-semibold">
                        <span class="text-slate-900">Total</span>
                        <x-currency :value="$grandTotalLocal" class="text-emerald-600" />
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200">
                        Kembali ke Katalog
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-emerald-500 text-white hover:bg-emerald-600">
                        Konfirmasi Checkout
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
