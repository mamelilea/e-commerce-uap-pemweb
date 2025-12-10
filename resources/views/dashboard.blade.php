<x-app-layout>
    <!DOCTYPE html>
    <html lang="id">

    <body class="bg-gray-50">
        <main>
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- ========== SIDEBAR FILTER ========== -->
                    <aside class="w-full lg:w-64 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">

                            <!-- KATEGORI -->
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Kategori</h2>
                            <ul class="space-y-1">
                                <!-- Semua Produk -->
                                <li>
                                    <a href="{{ route('dashboard', request()->only(['search'])) }}"
                                        class="block py-2.5 px-4 rounded-lg transition {{ !request('category') && !request('condition') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <div class="flex items-center justify-between">
                                            <span>Semua Produk</span>
                                            @if(!request('category') && !request('condition'))
                                            <span class="text-sm text-blue-100">
                                                ({{ $products->total() }})
                                            </span>
                                            @endif
                                        </div>
                                    </a>
                                </li>

                                <!-- Loop Kategori -->
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('dashboard', array_merge(['category' => $category->id], request()->only(['search', 'condition']))) }}"
                                        class="block py-2.5 px-4 rounded-lg transition {{ request('category') == $category->id ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <div class="flex items-center justify-between">
                                            <span>{{ $category->name }}</span>
                                            <span
                                                class="text-sm {{ request('category') == $category->id ? 'text-blue-100' : 'text-gray-500' }}">
                                                ({{ $category->products_count }})
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                            <!-- FILTER KONDISI -->
                            <div class="mt-6 pt-6 border-t">
                                <h3 class="font-semibold mb-3 text-gray-800">Kondisi</h3>
                                <div class="space-y-2">
                                    <!-- Semua Kondisi -->
                                    <a href="{{ route('dashboard', request()->except('condition')) }}"
                                        class="block py-2 px-4 rounded-lg transition {{ !request('condition') ? 'bg-gray-200 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                        Semua
                                    </a>

                                    <!-- Baru -->
                                    <a href="{{ route('dashboard', array_merge(request()->except('condition'), ['condition' => 'new'])) }}"
                                        class="block py-2 px-4 rounded-lg transition {{ request('condition') == 'new' ? 'bg-gray-200 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                        Baru
                                    </a>

                                    <!-- Bekas -->
                                    <a href="{{ route('dashboard', array_merge(request()->except('condition'), ['condition' => 'used'])) }}"
                                        class="block py-2 px-4 rounded-lg transition {{ request('condition') == 'used' ? 'bg-gray-200 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                        Bekas
                                    </a>
                                </div>
                            </div>

                            <!-- RESET FILTER -->
                            @if(request()->hasAny(['category', 'condition']))
                            <div class="mt-6 pt-6 border-t">
                                <a href="{{ route('dashboard', request()->only('search')) }}"
                                    class="block w-full text-center py-2 text-sm text-red-600 hover:text-red-700 font-semibold border border-red-300 rounded-lg hover:bg-red-50 transition">
                                    Reset Filter
                                </a>
                            </div>
                            @endif
                        </div>
                    </aside>

                    <!-- ========== MAIN CONTENT ========== -->
                    <div class="flex-1 min-w-0">
                        <!-- Header -->
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                                @if(request('category'))
                                {{ $categories->firstWhere('id', request('category'))?->name ?? 'Produk' }}
                                @else
                                Semua Produk
                                @endif

                                @if(request('condition'))
                                - {{ request('condition') == 'new' ? 'Baru' : 'Bekas' }}
                                @endif
                            </h1>

                            <p class="text-gray-600">
                                Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
                                @if(request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                                @endif
                            </p>

                            <!-- Active Filters Tags -->
                            @if(request()->hasAny(['category', 'condition']))
                            <div class="flex flex-wrap gap-2 mt-4">
                                <span class="text-sm text-gray-600 font-medium">Filter aktif:</span>

                                @if(request('category'))
                                @php $currentCategory = $categories->firstWhere('id', request('category')); @endphp
                                @if($currentCategory)
                                <a href="{{ route('dashboard', request()->except('category')) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                                    {{ $currentCategory->name }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                                @endif
                                @endif

                                @if(request('condition'))
                                <a href="{{ route('dashboard', request()->except('condition')) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium hover:bg-green-200 transition">
                                    {{ request('condition') == 'new' ? 'Baru' : 'Bekas' }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Products Grid -->
                        @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                            <div
                                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <a href="{{ route('products.show', $product->id) }}" class="block">
                                    <!-- Product Image -->
                                    <div class="aspect-square bg-gray-100 relative overflow-hidden group">
                                        @php
                                        $thumbnail = $product->productImages->firstWhere('is_thumbnail', true);
                                        if (!$thumbnail) {
                                        $thumbnail = $product->productImages->first();
                                        }
                                        @endphp

                                        @if($thumbnail)
                                        <img src="{{ asset('storage/' . $thumbnail->image) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-20 h-20" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif

                                        <!-- Badges -->
                                        <div class="absolute top-2 left-2">
                                            <span
                                                class="inline-block text-xs px-2 py-1 rounded-full font-semibold {{ $product->condition == 'new' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                                {{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}
                                            </span>
                                        </div>

                                        @if($product->stock < 10) <div
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                            Stok Terbatas
                                    </div>
                                    @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="inline-block text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded">
                                        {{ $product->productCategory->name }}
                                    </span>
                                    @if($product->store)
                                    <span class="text-xs text-gray-500">
                                        {{ $product->store->name }}
                                    </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-semibold text-gray-800 mt-2 line-clamp-2 min-h-[3rem]">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-gray-600 text-sm mt-2 line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->description }}
                                </p>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>Stok: {{ $product->stock }}</span>
                                        <span>Berat: {{ $product->weight }}kg</span>
                                    </div>
                                </div>
                            </div>
                            </a>

                            <!-- Add to Cart Button -->
                            <div class="px-4 pb-4">
                                @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" onclick="event.stopPropagation()"
                                        class="w-full bg-blue-500 text-white py-2.5 rounded-lg hover:bg-blue-600 transition-colors font-semibold flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" onclick="event.stopPropagation()"
                                    class="block w-full bg-blue-500 text-white py-2.5 rounded-lg hover:bg-blue-600 transition-colors font-semibold text-center">
                                    Login untuk Membeli
                                </a>
                                @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm p-16 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-6 text-2xl font-bold text-gray-800">Produk tidak ditemukan</h3>
                        <p class="mt-3 text-gray-600 max-w-md mx-auto">
                            Maaf, kami tidak menemukan produk yang sesuai dengan filter Anda. Silakan coba filter lain.
                        </p>
                        <div class="flex gap-3 justify-center mt-6">
                            <a href="{{ route('dashboard') }}"
                                class="inline-block px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                Lihat Semua Produk
                            </a>
                            @if(request()->hasAny(['category', 'condition']))
                            <a href="{{ route('dashboard', request()->only('search')) }}"
                                class="inline-block px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                Reset Filter
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </main>

        <!-- ========== FOOTER ========== -->
        <footer class="bg-gray-800 text-white mt-16 py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tentang Kami</h3>
                        <p class="text-gray-400">Electromart terpercaya dengan berbagai pilihan produk dari toko
                            terpercaya.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Untuk Pembeli</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="/" class="hover:text-white transition">Cara Berbelanja</a></li>
                            <li><a href="#" class="hover:text-white transition">Kebijakan Pengembalian</a></li>
                            <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Untuk Penjual</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('seller.register') }}" class="hover:text-white transition">Daftar
                                    Sebagai Penjual</a></li>
                            <li><a href="#" class="hover:text-white transition">Panduan Penjual</a></li>
                            <li><a href="#" class="hover:text-white transition">Pusat Edukasi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li>Email: info@electromart.com</li>
                            <li>Telp: (021) 1234-5678</li>
                            <li>WA: 0822-4558-0089</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 pt-6 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Electromart. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>

    </html>
</x-app-layout>