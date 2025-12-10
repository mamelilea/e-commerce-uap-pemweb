<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                    KiloMeter – Katalog Sepatu
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Jelajahi berbagai koleksi sepatu dari berbagai toko di KiloMeter.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- 🔔 Alert sukses --}}
        @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
        @endif

        {{-- 🌈 FULL-WIDTH HERO SLIDER (smooth + responsive) --}}
        <section
            x-data="{
        current: 0,
        slides: [0, 1],
        next() { this.current = (this.current + 1) % this.slides.length },
        prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length }
    }"
            x-init="setInterval(() => next(), 10000)"
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-sky-500 text-white shadow-md">
            {{-- Dekorasi background --}}
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <div class="absolute -left-24 -top-24 w-48 h-48 sm:w-64 sm:h-64 rounded-full bg-white/20 blur-3xl"></div>
                <div class="absolute -right-10 bottom-0 w-56 h-56 sm:w-72 sm:h-72 rounded-full bg-sky-400/30 blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
                <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-10">

                    {{-- Slide 1: Katalog --}}
                    <div
                        x-show="current === 0"
                        x-cloak
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-400"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-3"
                        class="w-full lg:w-1/2 space-y-3 sm:space-y-4">
                        <p class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-[11px] sm:text-xs font-medium backdrop-blur">
                            ✨ Koleksi sepatu pilihan hanya di KiloMeter
                        </p>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight">
                            Temukan sepatu terbaik<br class="hidden sm:block">
                            untuk setiap langkahmu.
                        </h1>

                        <p class="text-xs sm:text-sm md:text-base text-emerald-50/90 max-w-md">
                            Jelajahi berbagai kategori sepatu dari berbagai toko terpercaya.
                            Mulai dari running, basket, futsal, hingga casual – semua ada di sini.
                        </p>

                        @if($categories->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-1 sm:mt-2">
                            @foreach($categories->take(4) as $category)
                            <a href="{{ route('home', ['category' => $category->slug]) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/90 text-[11px] sm:text-xs font-semibold text-emerald-700 shadow-sm hover:bg-white">
                                {{ $category->name }}
                            </a>
                            @endforeach

                            @if($categories->count() > 4)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-white/60 text-[11px] sm:text-xs font-medium text-emerald-50/90">
                                + {{ $categories->count() - 4 }} kategori lainnya
                            </span>
                            @endif
                        </div>
                        @endif

                        <div class="flex flex-wrap gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-4 py-2 rounded-full bg-white text-emerald-700 text-xs sm:text-sm font-semibold shadow hover:bg-emerald-50">
                                Mulai Jelajahi Katalog
                            </a>

                            <a href="#category-filter"
                                class="inline-flex items-center px-4 py-2 rounded-full border border-white/60 text-xs sm:text-sm font-semibold text-white/90 hover:bg-white/10">
                                Lihat kategori
                            </a>
                        </div>
                    </div>

                    {{-- Slide 2: Ajak jadi seller --}}
                    <div
                        x-show="current === 1"
                        x-cloak
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-3"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-400"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-3"
                        class="w-full lg:w-1/2 space-y-3 sm:space-y-4">
                        <p class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-[11px] sm:text-xs font-medium backdrop-blur">
                            🚀 Untuk pemilik brand & toko sepatu
                        </p>

                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight">
                            Punya toko sepatu?<br class="hidden sm:block">
                            Saatnya go online di KiloMeter.
                        </h2>

                        <p class="text-xs sm:text-sm md:text-base text-emerald-50/90 max-w-md">
                            Dapatkan etalase online yang rapi, mudah dikelola, dan langsung terhubung
                            dengan pembeli yang memang mencari sepatu. Daftarkan tokomu sekarang.
                        </p>

                        <ul class="text-[11px] sm:text-xs md:text-sm text-emerald-50/90 space-y-1">
                            <li>• Kelola produk & stok dengan mudah</li>
                            <li>• Tampilkan foto produk berkualitas dengan galeri khusus</li>
                            <li>• Pantau transaksi & ulasan pembeli dari satu dashboard</li>
                        </ul>

                        <div class="flex flex-wrap gap-2 sm:gap-3 pt-1 sm:pt-2">
                            <a href="{{ auth()->check() ? route('seller.profile.edit') : route('login') }}"
                                class="inline-flex items-center px-4 py-2 rounded-full bg-white text-emerald-700 text-xs sm:text-sm font-semibold shadow hover:bg-emerald-50">
                                Daftarkan Toko Sekarang
                            </a>

                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-4 py-2 rounded-full border border-white/60 text-xs sm:text-sm font-semibold text-white/90 hover:bg-white/10">
                                Lihat contoh produk
                            </a>
                        </div>
                    </div>

                    {{-- Ilustrasi di kanan --}}
                    <div class="w-full lg:w-1/2 flex justify-center lg:justify-end mt-4 lg:mt-0">
                        <div
                            class="relative w-full max-w-xs sm:max-w-sm h-40 sm:h-52 md:h-56"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                            <div class="absolute inset-0 rounded-3xl bg-white/10 backdrop-blur shadow-lg border border-white/10"></div>

                            <div class="absolute inset-3 rounded-2xl bg-white/95 text-slate-900 p-4 flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] text-slate-500">Contoh tampilan</p>
                                        <p class="text-sm font-semibold">Katalog produkmu</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 text-[10px] px-2 py-0.5">
                                        Seller Dashboard
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-2 mt-3">
                                    <div class="rounded-xl bg-slate-100 h-16 sm:h-20"></div>
                                    <div class="rounded-xl bg-slate-100 h-16 sm:h-20"></div>
                                    <div class="rounded-xl bg-slate-100 h-16 sm:h-20"></div>
                                </div>

                                <div class="mt-3 flex items-center justify-between text-[10px] sm:text-[11px]">
                                    <div class="space-y-0.5">
                                        <p class="text-slate-500">Estimasi pendapatan</p>
                                        <p class="font-semibold text-emerald-600">Naik hingga 3x</p>
                                    </div>
                                    <div class="flex -space-x-2">
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-500 border-2 border-white"></span>
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-sky-400 border-2 border-white"></span>
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-400 border-2 border-white"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Controls & indicators --}}
                <div class="mt-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="prev"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs">
                            ‹
                        </button>
                        <button
                            type="button"
                            @click="next"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs">
                            ›
                        </button>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <span
                            class="h-1.5 w-5 rounded-full transition-all"
                            :class="current === 0 ? 'bg-white' : 'bg-white/40'">
                        </span>
                        <span
                            class="h-1.5 w-5 rounded-full transition-all"
                            :class="current === 1 ? 'bg-white' : 'bg-white/40'">
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- 🔽 Filter Kategori (aku beri id untuk anchor dari hero) --}}
        <div id="category-filter" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">
                        Filter berdasarkan kategori
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Pilih kategori untuk menampilkan produk sesuai minatmu.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    {{-- Tombol "Semua" --}}
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border
                        {{ !$activeCategorySlug ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                        Semua
                    </a>

                    @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border
                            {{ $activeCategorySlug === $category->slug ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 🛍 Daftar Produk --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5">
            @if ($products->isEmpty())
            <div class="py-10 text-center text-sm text-slate-500">
                Belum ada produk yang tersedia untuk kategori ini.
            </div>
            @else
            <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                @php
                $firstImage = optional($product->productImages->first())->image;
                @endphp

                <div class="group flex flex-col h-full bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-200">
                    {{-- Gambar Produk --}}
                    <a href="{{ route('products.show', $product) }}" class="block">
                        @if ($firstImage)
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $firstImage) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @else
                        <div class="aspect-[4/3] flex items-center justify-center bg-slate-100 text-xs text-slate-400">
                            Tidak ada gambar
                        </div>
                        @endif
                    </a>

                    {{-- Konten Produk --}}
                    <div class="flex flex-col flex-1 px-4 pt-4 pb-2">
                        <a href="{{ route('products.show', $product) }}" class="block space-y-2">
                            <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-emerald-600">
                                {{ $product->name }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                @if ($product->store)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-50 border border-slate-100">
                                    {{ $product->store->name }}
                                </span>
                                @endif

                                @if ($product->productCategory)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700">
                                    {{ $product->productCategory->name }}
                                </span>
                                @endif
                            </div>
                        </a>

                        <div class="mt-3 pl-1">
                            <x-currency :value="$product->price" class="text-base font-semibold text-emerald-600" />
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="px-4 pb-4 pt-1 border-t border-slate-100">
                        <div class="flex items-center justify-between gap-2">

                            @guest
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800">
                                Login untuk checkout
                            </a>
                            @endguest

                            @auth
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button type="submit"
                                    class="group inline-flex items-center rounded-full bg-slate-900 text-white px-2 py-1.5 hover:bg-slate-800 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 2.25h1.386c.51 0 .955.343 1.087.835L5.91 8.25m0 0h12.24m-12.24 0l1.318 5.272c.132.492.577.835 1.087.835h7.67c.51 0 .955-.343 1.087-.835L18.75 8.25m-1.44 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-8.31 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    </svg>
                                    <span
                                        class="ml-0 max-w-0 overflow-hidden whitespace-nowrap text-[10px] font-semibold transition-all duration-200 group-hover:ml-2 group-hover:max-w-[80px]">
                                        Add to cart
                                    </span>
                                </button>
                            </form>

                            <a href="{{ route('checkout.start', $product) }}"
                                class="group inline-flex items-center rounded-full bg-emerald-500 text-white px-2 py-1.5 hover:bg-emerald-600 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 12h15m0 0l-4.5-4.5M19.5 12l-4.5 4.5" />
                                </svg>
                                <span
                                    class="ml-0 max-w-0 overflow-hidden whitespace-nowrap text-[10px] font-semibold transition-all duration-200 group-hover:ml-2 group-hover:max-w-[80px]">
                                    Checkout
                                </span>
                            </a>
                            @endauth

                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>