<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
                <p class="text-gray-600 mt-1">
                    {{ $cart->cartItems->count() }} produk dalam keranjang
                </p>
            </div>

            @if($cart->cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        @foreach($cart->cartItems as $item)
                        <div class="p-6 border-b last:border-b-0">
                            <div class="flex gap-4">
                                <!-- Product Image -->
                                <div class="w-24 h-24 flex-shrink-0">
                                    @php
                                    $thumbnail = $item->product->productImages->first();
                                    @endphp
                                    @if($thumbnail)
                                    <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                <a href="{{ route('products.show', $item->product->id) }}"
                                                    class="hover:text-blue-600">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            @if($item->product->store)
                                            <p class="text-sm text-gray-500">{{ $item->product->store->name }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600 mt-1">Stok: {{ $item->product->stock }}</p>
                                        </div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Hapus produk dari keranjang?')"
                                                class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Quantity & Price -->
                                    <div class="flex items-center justify-between mt-4">
                                        <!-- Quantity Selector -->
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button type="button" onclick="decreaseQuantity(this)"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                                    -
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                    min="1" max="{{ $item->product->stock }}"
                                                    class="w-16 text-center border-0 focus:ring-0" readonly>
                                                <button type="button"
                                                    onclick="increaseQuantity(this, {{ $item->product->stock }})"
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                                    +
                                                </button>
                                            </div>
                                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                                                Update
                                            </button>
                                        </form>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">
                                                Rp {{ number_format($item->price, 0, ',', '.') }} ×
                                                {{ $item->quantity }}
                                            </p>
                                            <p class="text-lg font-bold text-gray-900">
                                                Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Clear Cart Button -->
                    <div class="mt-4">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Kosongkan seluruh keranjang?')"
                                class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Belanja</h2>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ $cart->getTotalItems() }} produk)</span>
                                <span class="font-semibold">Rp
                                    {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span class="text-sm text-gray-500">Dihitung di checkout</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span>Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}"
                            class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Lanjut ke Checkout
                        </a>

                        <a href="{{ route('dashboard') }}"
                            class="block w-full text-center mt-3 text-gray-600 hover:text-gray-900">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
            @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-sm p-16 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-6 text-2xl font-bold text-gray-800">Keranjang Kosong</h3>
                <p class="mt-3 text-gray-600">
                    Belum ada produk dalam keranjang Anda
                </p>
                <a href="{{ route('dashboard') }}"
                    class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Mulai Belanja
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
    function increaseQuantity(btn, maxStock) {
        const input = btn.previousElementSibling;
        const currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
        }
    }

    function decreaseQuantity(btn) {
        const input = btn.nextElementSibling;
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
    </script>
</x-app-layout>