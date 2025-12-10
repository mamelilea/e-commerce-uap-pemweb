@extends('layouts.customer')

@section('title', 'Fayren - Shop')

@section('content')
{{-- Hero Banner --}}
<div class="relative overflow-hidden bg-gray-900" style="max-height: 600px;">
    {{-- Banner Image --}}
    <img src="{{ asset('images/hero-banner.png') }}" alt="New Collection" class="w-full h-full object-cover object-center" style="max-height: 600px;">
    
    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/30 to-transparent"></div>
    
    {{-- Content Overlay --}}
    <div class="absolute inset-0 flex items-center">
        <div class="container-custom">
            <div class="max-w-xl">
                <p class="text-white/90 text-sm font-bold mb-4 uppercase tracking-wider">Summer 2025</p>
                <h1 class="text-white text-5xl md:text-6xl font-extrabold mb-4 leading-tight">
                    NEW COLLECTION
                </h1>
                <p class="text-white/80 text-lg mb-8 leading-relaxed">
                    We know how large objects will act, but things on a small scale.
                </p>
                <a href="{{ route('products.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-md text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    SHOP NOW
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Editor's Pick Categories --}}
<section class="bg-white py-20">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold mb-3" style="color: #252B42;">Curated Collections</h2>
            <p class="text-gray-600 text-lg">Discover our handpicked selections for every style</p>
        </div>
        
        {{-- Centered 2 Column Grid --}}
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Women Category --}}
                {{-- Women Category --}}
                <a href="{{ route('products.index', ['category' => \App\Models\ProductCategory::where('name', 'women')->value('id')]) }}" class="group relative block rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" style="will-change: transform;">
                    <div class="w-full h-full rounded-2xl overflow-hidden relative" style="transform: translateZ(0); -webkit-transform: translateZ(0);">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/category-women.jpg') }}" alt="Women's Fashion" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <h3 class="text-3xl font-bold mb-2 text-white">WOMEN</h3>
                            <p class="text-white/90 text-sm mb-4">
                                {{ \App\Models\Product::whereHas('productCategory', function($q) {
                                    $q->where('name', 'women')->orWhereHas('parent', fn($sq) => $sq->where('name', 'women'));
                                })->count() }} Items
                            </p>
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold">
                                Shop Women
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Men Category --}}
                <a href="{{ route('products.index', ['category' => \App\Models\ProductCategory::where('name', 'men')->value('id')]) }}" class="group relative block rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" style="will-change: transform;">
                    <div class="w-full h-full rounded-2xl overflow-hidden relative" style="transform: translateZ(0); -webkit-transform: translateZ(0);">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/category-men.jpg') }}" alt="Men's Fashion" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <h3 class="text-3xl font-bold mb-2 text-white">MEN</h3>
                            <p class="text-white/90 text-sm mb-4">
                                {{ \App\Models\Product::whereHas('productCategory', function($q) {
                                    $q->where('name', 'men')->orWhereHas('parent', fn($sq) => $sq->where('name', 'men'));
                                })->count() }} Items
                            </p>
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold">
                                Shop Men
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="bg-white py-16">
    <div class="container-custom">
        <h2 class="text-2xl font-bold text-center mb-2" style="color: #252B42;">Popular This Week</h2>
        <p class="text-center text-gray-600 mb-8">Trending products loved by our customers</p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">No products available yet.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="btn-outline inline-block">
                View All Products →
            </a>
        </div>
    </div>
</section>
@endsection
