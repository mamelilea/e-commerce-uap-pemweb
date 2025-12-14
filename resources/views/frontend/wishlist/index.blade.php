@extends('layouts.frontend')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Wishlist</h1>

    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <!-- Product Image -->
                    <div class="relative w-full h-64 bg-gray-50 overflow-hidden">
                        @if($item->product->productImages->first())
                            <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://placehold.co/400x400?text=No+Image" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <a href="{{ route('product.show', $item->product->slug) }}" 
                               class="px-4 py-2 bg-white text-gray-900 font-bold rounded-full text-sm hover:bg-k-pink hover:text-white transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                View Details
                            </a>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1">{{ $item->product->productCategory->name ?? 'Uncategorized' }}</p>
                        <a href="{{ route('product.show', $item->product->slug) }}">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight hover:text-k-pink transition-colors line-clamp-2 mb-2">
                                {{ $item->product->name }}
                            </h3>
                        </a>
                        
                        <div class="flex items-center justify-between pt-4 mt-2 border-t border-gray-50">
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                        </div>

                        <!-- Add to Cart Button -->
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-k-pink text-white py-2.5 rounded-lg font-bold hover:bg-pink-400 transition-colors">
                                Add to Cart
                            </button>
                        </form>

                        <!-- Remove from Wishlist -->
                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-gray-500 text-sm hover:text-red-500 transition-colors py-2">
                                Remove from Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Your Wishlist is Empty</h2>
            <p class="text-gray-500 mb-8">Save items you love here for later.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-k-pink hover:bg-pink-400 transition-colors">
                Discover Products
            </a>
        </div>
    @endif
</div>
@endsection
