<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs text-slate-500">Detail Produk</p>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                    {{ $product->name }}
                </h2>
                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-600">
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
            </div>
            <a href="{{ url()->previous() ?? route('home') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-5">
        <div class="lg:col-span-3 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5">
                @php
                $images = $product->productImages;
                $firstImage = optional($images->first())->image;
                @endphp

                @if ($firstImage)
                <div class="aspect-[4/3] overflow-hidden rounded-xl bg-slate-100">
                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>
                @else
                <div class="aspect-[4/3] flex items-center justify-center rounded-xl bg-slate-100 text-sm text-slate-400">
                    Tidak ada gambar produk
                </div>
                @endif

                @if ($images->count() > 1)
                <div class="mt-4 grid grid-cols-4 sm:grid-cols-6 gap-3">
                    @foreach ($images as $image)
                    <div class="overflow-hidden rounded-lg border border-slate-100 bg-slate-50">
                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                            class="w-full h-20 object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5 space-y-3">
                <h3 class="text-lg font-semibold text-slate-900">Deskripsi Produk</h3>
                <p class="text-sm leading-relaxed text-slate-700 whitespace-pre-line">{{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <p class="text-xs text-slate-500">Harga</p>
                        <x-currency :value="$product->price" class="text-2xl font-bold text-emerald-600" />
                    </div>
                    <div class="text-right space-y-1 text-xs text-slate-500">
                        @if ($product->condition)
                        <p>Kondisi: <span class="font-semibold text-slate-700">{{ ucfirst($product->condition) }}</span></p>
                        @endif
                        <p>Stok: <span class="font-semibold text-slate-700">{{ $product->stock ?? '-' }}</span></p>
                        @if ($product->weight)
                        <p>Berat: <span class="font-semibold text-slate-700">{{ $product->weight }} gr</span></p>
                        @endif
                        @if ($reviewsCount === 0)
                        <p class="text-sm text-slate-600">
                            Belum ada ulasan untuk produk ini.
                        </p>
                        @else
                        <div class="space-y-4">
                            @foreach ($reviews as $review)
                            {{-- kartu ulasan --}}
                            @endforeach
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            @auth
            <div class="flex flex-col gap-2">
                <form method="POST" action="{{ route('cart.add', $product) }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 text-white px-4 py-2.5 text-sm font-semibold hover:bg-slate-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 2.25h1.5l1.379 7.132a1.5 1.5 0 001.475 1.118h8.742a1.5 1.5 0 001.475-1.118L18.75 6.75H6.862" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.5 1.5 0 11-3 0m-4.5 0a1.5 1.5 0 11-3 0M9 6.75h12.75" />
                        </svg>
                        Tambahkan ke Keranjang
                    </button>
                </form>

                <a href="{{ route('checkout.start', $product) }}"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 text-white px-4 py-2.5 text-sm font-semibold hover:bg-emerald-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m0 0l-6-6m6 6l-6 6" />
                    </svg>
                    Checkout Sekarang
                </a>
            </div>
            @endauth

            @guest
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-2 text-sm text-slate-700">
                <p class="font-semibold text-slate-900">Login untuk membeli</p>
                <p class="text-slate-600">Masuk atau daftar terlebih dahulu untuk menambahkan produk ke keranjang atau checkout.</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800">Masuk</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">Daftar</a>
                </div>
            </div>
            @endguest
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5 space-y-3">
            <h3 class="text-lg font-semibold text-slate-900">Informasi Toko</h3>
            @if ($product->store)
            <div class="space-y-1 text-sm text-slate-700">
                <p class="font-semibold text-slate-900">{{ $product->store->name }}</p>
                @if ($product->store->description)
                <p class="text-slate-600">{{ $product->store->description }}</p>
                @endif
                <p class="text-slate-500">Pemilik: {{ optional($product->store->user)->name ?? '-' }}</p>
            </div>
            @else
            <p class="text-sm text-slate-600">Informasi toko tidak tersedia.</p>
            @endif
        </div>
    </div>
    </div>
    {{-- FORM TAMBAH ULASAN (hanya buyer & belum review) --}}
    @auth
    @if ($canReview)
    <div class="border border-emerald-100 bg-emerald-50/60 rounded-xl p-3 sm:p-4 space-y-3">
        <p class="text-sm font-semibold text-slate-900">
            Tambahkan ulasanmu
        </p>

        @if (session('error'))
        <p class="text-xs text-red-600">
            {{ session('error') }}
        </p>
        @endif

        <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="space-y-3">
            @csrf

            {{-- Rating --}}
            <div class="space-y-1">
                <label for="rating" class="text-xs font-medium text-slate-700">
                    Rating
                </label>
                <select id="rating" name="rating"
                    class="border border-slate-200 rounded-lg text-sm px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ $i === 5 ? 'Sangat puas' : ($i === 4 ? 'Puas' : ($i === 3 ? 'Cukup' : ($i === 2 ? 'Kurang' : 'Buruk'))) }}
                    </option>
                    @endfor
                </select>
                @error('rating')
                <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Review teks --}}
            <div class="space-y-1">
                <label for="review" class="text-xs font-medium text-slate-700">
                    Ulasan (opsional)
                </label>
                <textarea id="review" name="review" rows="3"
                    class="border border-slate-200 rounded-lg text-sm px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="Ceritakan pengalamanmu dengan produk ini...">{{ old('review') }}</textarea>
                @error('review')
                <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-emerald-500 text-white hover:bg-emerald-600">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
    @elseif ($hasReviewed)
    <div class="border border-slate-100 bg-slate-50 rounded-xl p-3 sm:p-4 text-xs text-slate-600">
        Kamu sudah memberikan ulasan untuk produk ini. Terima kasih! 💚
    </div>
    @endif
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Ulasan Pembeli ({{ $reviewsCount }})</h3>

        @if ($reviewsCount === 0)
        <p class="text-sm text-slate-500">Belum ada ulasan.</p>
        @endif

        @foreach ($reviews as $review)
        <div class="border-b border-slate-100 pb-3 mb-3">
            <div class="flex items-center justify-between mb-1">
                <p class="text-sm font-semibold text-slate-900">
                    {{ $review->transaction->user->name ?? 'User tidak diketahui' }}
                </p>
                <p class="text-xs text-emerald-600 font-medium">
                    ⭐ {{ $review->rating }}/5
                </p>
            </div>
            <p class="text-sm text-slate-700">
                {{ $review->comment ?? $review->review }}
            </p>
        </div>
        @endforeach
    </div>

    @endauth
</x-app-layout>