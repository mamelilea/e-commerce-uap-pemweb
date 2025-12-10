@props(['product'])

{{-- Check if this is the seller's own product --}}
@php
    $isOwnProduct = auth()->check() && 
                    auth()->user()->store && 
                    $product->store_id === auth()->user()->store->id;
@endphp

{{-- Bandage Style Product Card --}}
<div class="product-card group {{ $isOwnProduct ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer' }}" 
     onclick="{{ $isOwnProduct ? 'event.preventDefault()' : "window.location.href='" . route('products.show', $product->slug) . "'" }}">
    {{-- Product Image with 3:4 Aspect Ratio --}}
    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
        @if($product->productImages->count() > 0)
            <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" 
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        {{-- Wishlist Button (top right) --}}
        <button 
            onclick="event.stopPropagation(); {{ $isOwnProduct ? 'return false;' : 'toggleWishlist(' . $product->id . ', this)' }}" 
            class="absolute top-4 right-4 p-2 rounded-full bg-white shadow-md {{ $isOwnProduct ? 'opacity-50 cursor-not-allowed' : 'hover:scale-110' }} transition-all duration-200 z-10"
            {{ $isOwnProduct ? 'disabled' : '' }}>
            <svg class="w-5 h-5 wishlist-icon {{ in_array($product->id, session('wishlist', [])) ? 'fill-red-500 text-red-500' : 'text-gray-600' }}" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>

        {{-- Sale Badge (if any) --}}
        @if($product->discount ?? false)
            <div class="absolute top-4 left-4 bg-danger-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                SALE
            </div>
        @endif

        {{-- Your Product Badge for seller's own products --}}
        @if($isOwnProduct)
            <div class="absolute top-4 left-4 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                Your Product
            </div>
        @endif
    </div>

    {{-- Product Info --}}
    <div class="px-6 py-5 text-center space-y-2">
        {{-- Department/Category --}}
        <h5 class="text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ $product->productCategory->name ?? 'Graphic Design' }}
        </h5>

        {{-- Product Name --}}
        <h3 class="text-base font-bold text-gray-900 line-clamp-2 min-h-[3rem]">
            {{ $product->name }}
        </h3>

        {{-- Store Name (subtle) --}}
        @if($product->store)
            <p class="text-xs text-gray-500">
                {{ $product->store->name }}
            </p>
        @endif

        {{-- Price --}}
        <div class="flex items-center justify-center gap-2">
            @if(isset($product->original_price) && $product->original_price > $product->price)
                <span class="text-sm font-bold text-gray-400 line-through">
                    ${{ number_format($product->original_price, 2) }}
                </span>
                <span class="text-base font-bold text-success-500">
                    ${{ number_format($product->price, 2) }}
                </span>
            @else
                <span class="text-lg font-bold text-gray-900">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            @endif
        </div>

        {{-- Stock Indicator --}}
        @if($product->stock <= 0)
            <div class="pt-2">
                <span class="inline-block text-xs font-bold text-danger-500 bg-danger-50 px-3 py-1 rounded-full">
                    Out of Stock
                </span>
            </div>
        @elseif($product->stock < 10)
            <div class="pt-2">
                <span class="inline-block text-xs font-bold text-warning-500 bg-warning-50 px-3 py-1 rounded-full">
                    Only {{ $product->stock }} left
                </span>
            </div>
        @endif
    </div>
</div>
