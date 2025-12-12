<x-app-layout>
    {{-- Hero Section --}}
    {{-- Hero Slider --}}
    <div x-data="{ 
            activeSlide: 0,
            slides: [
                '{{ asset('storage/banners/banner1.webp') }}', 
                '{{ asset('storage/banners/banner2.webp') }}', 
                '{{ asset('storage/banners/banner3.webp') }}'  
            ],
            loop() {
                setInterval(() => {
                    this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1
                }, 5000)
            }
        }" 
        x-init="loop()"
        class="relative w-full h-[300px] md:h-[500px] overflow-hidden group">
        
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform scale-105"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-105"
                 class="absolute inset-0 w-full h-full">
                <img :src="slide" class="w-full h-full object-cover" alt="Sillia Banner">
            </div>
        </template>

        <!-- Controls -->
        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-hubbub-pink p-4 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm z-10 shadow-lg hover:shadow-pink-200 hover:scale-110">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-hubbub-pink p-4 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm z-10 shadow-lg hover:shadow-pink-200 hover:scale-110">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
        
        <!-- Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="{'w-10 bg-hubbub-pink': activeSlide === index, 'w-3 bg-white/60 hover:bg-white': activeSlide !== index}"
                        class="h-3 rounded-full transition-all duration-300 shadow-sm"></button>
            </template>
        </div>
    </div>

    {{-- Info Cards Section (Sociolla Style) --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 p-8 rounded-[30px] shadow-[0px_10px_40px_rgba(234,92,136,0.05)] text-center hover:-translate-y-1 transition-transform duration-300">
                    <h3 class="font-bold text-hubbub-black text-lg mb-2">Beauty Curated</h3>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">
                        Pilihan produk terkurasi untuk kebutuhan harianmu! Lebih mudah, tanpa bingung.
                    </p>
                </div>
                 <!-- Card 2 -->
                 <div class="bg-white border border-gray-100 p-8 rounded-[30px] shadow-[0px_10px_40px_rgba(234,92,136,0.05)] text-center hover:-translate-y-1 transition-transform duration-300">
                    <h3 class="font-bold text-hubbub-black text-lg mb-2">Studio Glam</h3>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">
                        Koleksi warna menawan untuk tampilan fresh setiap hari.
                    </p>
                </div>
                 <!-- Card 3 -->
                 <div class="bg-white border border-gray-100 p-8 rounded-[30px] shadow-[0px_10px_40px_rgba(234,92,136,0.05)] text-center hover:-translate-y-1 transition-transform duration-300">
                    <h3 class="font-bold text-hubbub-black text-lg mb-2">Gift Ready</h3>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">
                        Dibungkus rapi, siap jadi hadiah bermakna untuk orang tersayang.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Editor's Picks (Split Banners) --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-8">
                <div>
                     <span class="text-gray-400 text-[10px] font-bold font-sans uppercase tracking-widest mb-1 block">Editor's Picks</span>
                    <h2 class="font-sans text-3xl font-bold text-hubbub-black tracking-tight">Rekomendasi Terbaik Minggu Ini</h2>
                     <p class="text-gray-400 text-sm mt-1">Pilihan Produk Unggulan</p>
                </div>
                 <a href="#shop" class="text-hubbub-pink font-bold text-sm hover:underline">Lihat semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-pink-50 rounded-[40px] p-8 md:p-10 relative overflow-hidden group hover:shadow-xl hover:shadow-pink-100 transition-all duration-300 flex flex-col md:flex-row items-center gap-6">
                    <div class="relative z-10 w-full md:w-1/2">
                        <span class="text-hubbub-pink text-[10px] font-bold uppercase tracking-widest mb-2 block">Fresh & Glowing</span>
                        <h3 class="font-header text-3xl font-bold text-hubbub-black mb-4">Daily Hydrating Set</h3>
                        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                            Paket toner-serum-moisturizer lembut untuk glow sehat setiap hari.
                        </p>
                        <a href="#shop" class="inline-block bg-white text-hubbub-black hover:text-white hover:bg-hubbub-pink font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-full transition-all shadow-sm">
                            Lihat Produk
                        </a>
                    </div>
                    <div class="w-full md:w-1/2 h-64 md:h-auto flex items-center justify-center relative">
                         <div class="absolute inset-0 bg-white rounded-full blur-3xl opacity-40 transform scale-75"></div>
                         <img src="{{ asset('img/left-banner-pink.jpg') }}" class="relative z-10 w-full h-full object-contain hover:scale-105 transition-transform duration-500" alt="Glowing Set">
                    </div>
                </div>

                <div class="bg-hubbub-black rounded-[40px] p-8 md:p-10 relative overflow-hidden group hover:shadow-xl hover:shadow-gray-400 transition-all duration-300 flex flex-col md:flex-row items-center gap-6">
                     <div class="relative z-10 w-full md:w-1/2">
                        <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2 block">Bold & Stylish</span>
                        <h3 class="font-header text-3xl font-bold text-white mb-4">Statement Lips & Eyes</h3>
                        <p class="text-gray-400 text-sm mb-8 leading-relaxed">
                            Lip cream matte, eyeliner presisi, dan palette smokey untuk look tegas yang tahan lama.
                        </p>
                        <a href="#shop" class="inline-block bg-white text-hubbub-black font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-full transition-all hover:bg-gray-200 shadow-sm">
                            Eksplor Produk
                        </a>
                    </div>
                    <div class="w-full md:w-1/2 h-64 md:h-auto flex items-center justify-center relative">
                        <div class="absolute inset-0 bg-hubbub-pink rounded-full blur-3xl opacity-20 transform scale-75"></div>
                        <img src="{{ asset('img/right-banner-model.jpg') }}" class="relative z-10 w-full h-full object-cover rounded-2xl hover:scale-105 transition-transform duration-500" alt="Statement Look">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori Favorit (Sociolla Pills) --}}
    <div class="bg-pink-50/30 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-sans text-xl font-bold text-hubbub-black mb-6">Kategori Favorit</h2>
            
            <div class="flex flex-wrap gap-3">
                 <a href="{{ route('home') }}" class="px-6 py-2 rounded-xl font-bold text-[10px] uppercase tracking-wide transition-all duration-300 border {{ !request('category') ? 'bg-hubbub-pink text-white border-hubbub-pink shadow-md shadow-pink-200' : 'bg-pink-100 text-hubbub-pink border-transparent hover:bg-hubbub-pink hover:text-white' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}" class="px-6 py-2 rounded-xl font-bold text-[10px] uppercase tracking-wide transition-all duration-300 border {{ request('category') == $category->slug ? 'bg-hubbub-pink text-white border-hubbub-pink shadow-md shadow-pink-200' : 'bg-pink-100 text-hubbub-pink border-transparent hover:bg-hubbub-pink hover:text-white' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Product Grid --}}
    <div id="shop" class="bg-white py-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 pb-6 gap-6">
                <div>
                     <span class="text-gray-400 text-[10px] font-bold font-sans uppercase tracking-[0.1em] mb-1 block">Marketplace</span>
                    <h2 class="font-sans text-3xl font-bold text-hubbub-black tracking-tight">Produk Pilihan</h2>
                </div>
                 <span class="text-gray-400 font-sans text-xs font-bold">{{ $products->total() }} produk tersedia</span>
            </div>

            {{-- Filter Bar (Sociolla Style: Clean White) --}}
            <div class="bg-white p-6 rounded-[20px] shadow-sm border border-gray-100 mb-12">
                 <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-x-6 gap-y-4 items-end">
                    <!-- Search -->
                     <div class="md:col-span-3">
                        <label for="search" class="block text-[10px] font-bold text-gray-400 mb-1.5 ml-1">Cari Produk</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari lip tint, serum ..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-hubbub-pink focus:ring-1 focus:ring-hubbub-pink outline-none transition-all placeholder-gray-300">
                     </div>

                     <!-- Category -->
                     <div class="md:col-span-3">
                        <label for="category" class="block text-[10px] font-bold text-gray-400 mb-1.5 ml-1">Kategori</label>
                        <select name="category" id="category" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-hubbub-pink focus:ring-1 focus:ring-hubbub-pink outline-none transition-all appearance-none bg-white cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                     </div>

                    <!-- Price -->
                    <div class="md:col-span-2">
                        <label for="min_price" class="block text-[10px] font-bold text-gray-400 mb-1.5 ml-1">Harga Min</label>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-hubbub-pink focus:ring-1 focus:ring-hubbub-pink outline-none transition-all placeholder-gray-300">
                    </div>

                    <div class="md:col-span-2">
                         <label for="max_price" class="block text-[10px] font-bold text-gray-400 mb-1.5 ml-1">Harga Max</label>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="500000" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-hubbub-pink focus:ring-1 focus:ring-hubbub-pink outline-none transition-all placeholder-gray-300">
                    </div>
                    
                     <!-- Buttons -->
                    <div class="md:col-span-2 flex gap-2">
                         <a href="{{ route('home') }}" class="flex-1 bg-white border border-gray-200 text-gray-500 font-bold text-[10px] py-2.5 rounded-lg hover:border-gray-300 transition-all text-center flex items-center justify-center">
                            Reset
                        </a>
                        <button type="submit" class="flex-1 bg-hubbub-pink text-white font-bold text-[10px] py-2.5 rounded-lg hover:bg-pink-600 transition-all shadow-md hover:shadow-lg">
                            Terapkan
                        </button>
                    </div>
                 </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @forelse($products as $product)
                    <div class="group flex flex-col bg-white rounded-2xl overflow-hidden hover:shadow-[0px_10px_30px_rgba(0,0,0,0.05)] transition-all duration-300 border border-transparent hover:border-gray-100 h-full">
                        <div class="relative overflow-hidden aspect-square bg-white p-4">
                            <a href="{{ route('product.details', $product->slug) }}" class="block w-full h-full">
                                @if($product->productImages->first())
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50 rounded-xl">
                                        <svg class="w-8 h-8 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            
                            <!-- Badges -->
                             <span class="absolute top-0 right-0 bg-black text-white text-[9px] font-bold px-2 py-1 rounded-bl-lg z-10">{{ $product->productCategory->name ?? 'Item' }}</span>

                            <!-- Cart Button -->
                            <div class="absolute bottom-3 right-3 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="bg-hubbub-pink text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md hover:bg-pink-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-sans font-bold text-hubbub-black text-xs md:text-sm leading-snug mb-2 line-clamp-2 min-h-[2.5rem] group-hover:text-hubbub-pink transition-colors">
                                <a href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-[10px] text-gray-400 mb-3 line-clamp-1 min-h-[1rem]">{{ $product->description }}</p>
                            
                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                                <p class="font-bold text-hubbub-pink text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <p class="text-gray-400 text-sm">Produk tidak ditemukan.</p>
                        <a href="{{ route('home') }}" class="text-hubbub-pink text-xs font-bold mt-2 inline-block hover:underline">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-16 flex justify-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
