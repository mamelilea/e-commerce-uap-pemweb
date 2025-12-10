<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-600 mt-1">Lengkapi data pengiriman Anda</p>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Form Section -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Alamat Pengiriman -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Alamat Pengiriman</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Penerima <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="recipient_name"
                                        value="{{ old('recipient_name', Auth::user()->name) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    @error('recipient_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="recipient_phone" value="{{ old('recipient_phone') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="08xxxxxxxxxx" required>
                                    @error('recipient_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="shipping_address" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan"
                                        required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Provinsi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="province" value="{{ old('province') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    @error('province')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kode Pos <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        maxlength="5" required>
                                    @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Metode Pengiriman -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Metode Pengiriman</h2>

                            <div class="space-y-3">
                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="shipping_method" value="JNE" class="w-4 h-4 text-blue-600"
                                        required checked>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900">JNE Regular</p>
                                        <p class="text-sm text-gray-500">Estimasi 2-3 hari</p>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp 15.000</span>
                                </label>

                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="shipping_method" value="JNT" class="w-4 h-4 text-blue-600"
                                        required>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900">J&T Express</p>
                                        <p class="text-sm text-gray-500">Estimasi 2-4 hari</p>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp 12.000</span>
                                </label>

                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="shipping_method" value="SiCepat"
                                        class="w-4 h-4 text-blue-600" required>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900">SiCepat Reguler</p>
                                        <p class="text-sm text-gray-500">Estimasi 3-5 hari</p>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp 10.000</span>
                                </label>
                            </div>
                            @error('shipping_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Metode Pembayaran</h2>

                            <div class="space-y-3">
                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="payment_method" value="COD" class="w-4 h-4 text-blue-600"
                                        required checked>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Cash on Delivery (COD)</p>
                                        <p class="text-sm text-gray-500">Bayar saat barang diterima</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="payment_method" value="Transfer Bank"
                                        class="w-4 h-4 text-blue-600" required>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Transfer Bank</p>
                                        <p class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="payment_method" value="E-Wallet"
                                        class="w-4 h-4 text-blue-600" required>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">E-Wallet</p>
                                        <p class="text-sm text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Catatan (Opsional)</h2>
                            <textarea name="notes" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Tambahkan catatan untuk penjual...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                            <!-- Products -->
                            <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                                @foreach($cart->cartItems as $item)
                                <div class="flex gap-3">
                                    <div class="w-16 h-16 flex-shrink-0">
                                        @php
                                        $thumbnail = $item->product->productImages->first();
                                        @endphp
                                        @if($thumbnail)
                                        <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Summary -->
                            <div class="border-t pt-4 space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cart->getTotalItems() }} produk)</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkos Kirim</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($shippingCost, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between text-xl font-bold text-gray-900">
                                    <span>Total</span>
                                    <span>Rp
                                        {{ number_format($cart->getSubtotal() + $shippingCost, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Buat Pesanan
                            </button>

                            <a href="{{ route('cart') }}"
                                class="block w-full text-center mt-3 text-gray-600 hover:text-gray-900">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>