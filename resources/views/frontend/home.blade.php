@extends('layouts.frontend')

@section('title', 'Discover K-Aesthetic')

@section('content')
    <!-- Hero Section (Dribbble/Clean Style) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="flex flex-col md:flex-row items-center justify-between gap-12">
            <!-- Left: Text -->
            <div class="md:w-1/2 text-center md:text-left space-y-6">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 leading-snug">
                    Discover the best <br>
                    <span class="text-k-pink">K-Pop merchandise</span> <br>
                    in a beautifully curated space.
                </h1>
                <p class="text-lg text-gray-500 max-w-xl mx-auto md:mx-0 leading-relaxed font-light">
                    Temukan lightstick, album, photocard, dan produk estetis favoritmu dari berbagai artis — semua dalam satu tempat yang nyaman dan inspiratif.
                </p>
                <div class="pt-2 flex justify-center md:justify-start">
                    <a href="#products" class="px-8 py-3.5 bg-k-pink text-white text-base font-bold rounded-full hover:bg-pink-400 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Belanja sekarang & wujudkan koleksi impianmu
                    </a>
                </div>
            </div>
            
            <!-- Right: Image -->
            <div class="md:w-1/2 flex justify-center items-center relative mt-8 md:mt-0">
                 <div class="relative w-full max-w-lg">
                     <!-- Decorative Blobs -->
                     <div class="absolute -top-12 -right-8 w-40 h-40 bg-blue-50 rounded-full blur-2xl opacity-70"></div>
                     <div class="absolute -bottom-8 -left-12 w-48 h-48 bg-pink-50 rounded-full blur-2xl opacity-70"></div>
                     
                     <img src="{{ asset('hero-image.jpg') }}" alt="K-Pop Merchandise" class="relative z-10 w-full rounded-[2.5rem] shadow-2xl h-auto">
                 </div>
            </div>
        </div>
    </div>

    @if(isset($category) && $category)
        {{-- Filtered Category View --}}
        <div id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">{{ $categoryName ?? ucfirst($category) }}</h2>
                <p class="text-sm text-gray-500 mt-1">Showing all {{ strtolower($categoryName ?? $category) }} products</p>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <a href="{{ route('product.show', $product->id) }}" class="group">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-k-pink">
                                <div class="aspect-square bg-gray-50 overflow-hidden relative">
                                    @if($product->productImages->first())
                                        <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">{{ $product->store->name }}</p>
                                    <h3 class="font-bold text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-k-pink transition-colors">{{ $product->name }}</h3>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-bold text-k-pink">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        @if($product->stock > 0)
                                            <span class="text-xs text-green-600 font-medium">In Stock</span>
                                        @else
                                            <span class="text-xs text-red-600 font-medium">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
                    <p class="text-gray-500">No products available in this category yet.</p>
                </div>
            @endif
        </div>
    @else
        {{-- Default Official/Fanmade Split View --}}
        <!-- Official Merchandise Section -->
        <div id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Official Merchandise</h2>
                    <p class="text-sm text-gray-500 mt-1">Albums, Lightsticks, and Photocards</p>
                </div>
                <a href="#" class="text-sm font-medium text-k-pink hover:text-pink-600">View All</a>
            </div>

            @if($officialProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach($officialProducts as $product)
                        <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <!-- Image -->
                            <div class="relative w-full h-64 bg-gray-50 overflow-hidden">
                                 @if($product->productImages->first())
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                 @else
                                    <img src="https://placehold.co/400x400?text=No+Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                 @endif
                                 
                                 <!-- Category Badge -->
                                 <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-700 rounded-full shadow">
                                     {{ $product->productCategory->name ?? 'Uncategorized' }}
                                 </span>
                                 
                                 <!-- Quick Action Overlay -->
                                 <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                     <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-white text-gray-900 font-bold rounded-full text-sm hover:bg-k-pink hover:text-white transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                         View Details
                                     </a>
                                 </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">{{ $product->productCategory->name ?? 'Uncategorized' }}</p>
                                        <a href="{{ route('product.show', $product->id) }}">
                                            <h3 class="font-bold text-gray-900 text-lg leading-tight hover:text-k-pink transition-colors line-clamp-1">{{ $product->name }}</h3>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-5 h-5 rounded-full bg-gray-200 overflow-hidden">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->store->name) }}&background=F8DDE8&color=333" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-xs font-medium text-gray-500">{{ $product->store->name }}</span>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                    <span class="text-lg font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @if($product->stock > 0)
                                        <span class="text-xs text-green-600 font-medium">In Stock</span>
                                    @else
                                        <span class="text-xs text-red-600 font-medium">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No official merchandise available at the moment.</p>
            @endif
        </div>

        <!-- Fanmade Merchandise Section -->
        <div id="fanmade" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Fanmade Merchandise</h2>
                    <p class="text-sm text-gray-500 mt-1">Apparel, Dolls, Keychains & Stickers</p>
                </div>
                <a href="#" class="text-sm font-medium text-k-pink hover:text-pink-600">View All</a>
            </div>

            @if($fanmadeProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach($fanmadeProducts as $product)
                        <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <!-- Image -->
                            <div class="relative w-full h-64 bg-gray-50 overflow-hidden">
                                @if($product->productImages->first())
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://placehold.co/400x400?text=No+Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                                
                                <!-- Category Badge -->
                                <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-700 rounded-full shadow">
                                    {{ $product->productCategory->name ?? 'Uncategorized' }}
                                </span>
                                
                                <!-- Quick Action Overlay -->
                                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-white text-gray-900 font-bold rounded-full text-sm hover:bg-k-pink hover:text-white transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <p class="text-xs text-gray-500 mb-1">{{ $product->productCategory->name ?? 'Uncategorized' }}</p>
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight hover:text-k-pink transition-colors line-clamp-1">{{ $product->name }}</h3>
                                </a>
                                
                                <div class="flex items-center justify-between pt-4 mt-2 border-t border-gray-50">
                                    <span class="text-lg font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @if($product->stock > 0)
                                        <span class="text-xs text-green-600 font-medium">In Stock</span>
                                    @else
                                        <span class="text-xs text-red-600 font-medium">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No fanmade merchandise available at the moment.</p>
            @endif
        </div>
    @endif
@endsection
