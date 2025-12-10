<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 font-semibold">{{ $product->name }}</li>
                </ol>
            </nav>

            <!-- Product Detail Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 lg:p-8">

                    <!-- Product Images -->
                    <div>
                        <div class="mb-4"
                            x-data="{ mainImage: '{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image) : '' }}' }">
                            <!-- Main Image -->
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
                                @if($product->productImages->count() > 0)
                                <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <!-- Thumbnail Images -->
                            @if($product->productImages->count() > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->productImages as $image)
                                <button @click="mainImage = '{{ asset('storage/' . $image->image) }}'"
                                    class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 hover:border-blue-500 transition">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div>
                        <!-- Product Name -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                        <!-- Category & Condition Badge -->
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-block text-sm text-blue-600 font-semibold bg-blue-50 px-3 py-1 rounded">
                                {{ $product->productCategory->name }}
                            </span>
                            <span
                                class="inline-block text-sm font-semibold px-3 py-1 rounded 
                                {{ $product->condition == 'new' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}
                            </span>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <p class="text-4xl font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Stock Info -->
                        <div class="mb-6 pb-6 border-b">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Stok:</span>
                                <span
                                    class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock }} tersedia
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm mt-2">
                                <span class="text-gray-600">Berat:</span>
                                <span class="font-semibold text-gray-900">{{ $product->weight }} kg</span>
                            </div>
                        </div>

                        <!-- Store Info -->
                        @if($product->store)
                        <div class="mb-6 pb-6 border-b">
                            <h3 class="font-semibold text-gray-900 mb-3">Informasi Toko</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-bold text-gray-600">
                                        {{ strtoupper(substr($product->store->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->store->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->store->city }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Quantity Selector & Add to Cart -->
                        <div class="mb-6" x-data="{ quantity: 1 }">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Jumlah</label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button @click="quantity = Math.max(1, quantity - 1)"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" x-model="quantity" min="1" max="{{ $product->stock }}"
                                        class="w-16 text-center border-0 focus:ring-0" readonly>
                                    <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600">Tersisa <span
                                        class="font-semibold">{{ $product->stock }}</span> produk</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex gap-4">
                                @auth
                                @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                    class="flex-1 flex gap-4" x-data="{ quantity: 1 }">
                                    @csrf
                                    <input type="hidden" name="quantity" x-model="quantity">

                                    <button type="submit"
                                        class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                                @else
                                <button disabled
                                    class="flex-1 bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                    Stok Habis
                                </button>
                                @endif
                                @else
                                <a href="{{ route('login') }}"
                                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                                    Login untuk Membeli
                                </a>
                                @endauth
                            </div>
                            <a href="{{ route('checkout') }}"
                                class="block w-full text-center mt-3 text-gray-600 hover:text-gray-900">
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="border-t p-6 lg:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Produk</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $product->description }}
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->id) }}"
                        class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="aspect-square bg-gray-100 relative overflow-hidden">
                            @php
                            $thumb = $related->productImages->first();
                            @endphp
                            @if($thumb)
                            <img src="{{ asset('storage/' . $thumb->image) }}" alt="{{ $related->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-base font-semibold text-gray-800 line-clamp-2 mb-2">
                                {{ $related->name }}
                            </h3>
                            <p class="text-xl font-bold text-gray-900">
                                Rp {{ number_format($related->price, 0, ',', '.') }}
                            </p>
                            @if($related->store)
                            <p class="text-sm text-gray-500 mt-1">{{ $related->store->name }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>