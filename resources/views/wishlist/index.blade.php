@extends('layouts.customer')

@section('title', 'My Wishlist')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>

    @if($products->count() === 0)
        <!-- Empty Wishlist State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your wishlist is empty</h2>
            <p class="text-gray-600 mb-6">Save items you love for later.</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Start Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="group relative animate-fade-in">
                    <div class="card overflow-hidden">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden bg-gray-100 aspect-[3/4]">
                            @if($product->productImages->count() > 0)
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Remove from Wishlist -->
                            <!-- Remove from Wishlist -->
                            <button 
                                onclick="event.preventDefault(); toggleWishlist({{ $product->id }}, this)"
                                class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:scale-110 active:scale-95 z-10 w-10 h-10">
                                <svg class="w-5 h-5 text-accent-500 fill-current" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </a>

                        <!-- Product Info -->
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}" class="block space-y-2">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">
                                    {{ $product->store->name ?? 'XIV Shop' }}
                                </p>
                                <h3 class="font-medium text-gray-900 group-hover:text-primary-900 transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-semibold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    @if($product->stock <= 0)
                                        <span class="text-xs text-accent-500 font-medium">Out of Stock</span>
                                    @endif
                                </div>
                            </a>

                            <!-- Add to Cart Button -->
                            @if($product->stock > 0)
                                <button 
                                    onclick="addToCart({{ $product->id }})"
                                    class="w-full mt-3 btn-primary text-sm py-2">
                                    Add to Cart
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    async function addToCart(productId) {
        // Show custom confirmation modal
        const confirmed = await showConfirmModal('Add this product to your cart?', 'Add to Cart');
        if (!confirmed) {
            return; // User cancelled
        }
        
        // Optimistic UI Update
        const desktopCountEl = document.getElementById('cartCountDesktop');
        const mobileCountEl = document.getElementById('cartCountMobile');
        const desktopWrapper = document.getElementById('cartCountWrapper');
        
        let previousCount = 0;
        
        // Get current count
        if (desktopCountEl) {
            previousCount = parseInt(desktopCountEl.textContent || '0');
        } else if (mobileCountEl) {
            previousCount = parseInt(mobileCountEl.textContent || '0');
        }

        const newCount = previousCount + 1; // Always adds 1 from wishlist
        
        // Update Elements
        if (desktopCountEl) desktopCountEl.textContent = newCount;
        if (mobileCountEl) mobileCountEl.textContent = newCount;
        
        // Show wrapper if it was hidden (count > 0)
        if (newCount > 0) {
            if (desktopWrapper) desktopWrapper.classList.remove('hidden');
            if (mobileCountEl) mobileCountEl.classList.remove('hidden');
        }
        
        // Animate
        if (desktopCountEl) {
            desktopCountEl.parentElement.classList.add('scale-125');
            setTimeout(() => desktopCountEl.parentElement.classList.remove('scale-125'), 200);
        }
        if (mobileCountEl) {
            mobileCountEl.classList.add('scale-125');
            setTimeout(() => mobileCountEl.classList.remove('scale-125'), 200);
        }

        // Show Success Toast Immediately
        showToast('Added to Bag', 'success');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/login';
                throw new Error('Unauthorized');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Sync with actual server count
                if (data.cart_count !== undefined) {
                    if (desktopCountEl) desktopCountEl.textContent = data.cart_count;
                    if (mobileCountEl) mobileCountEl.textContent = data.cart_count;
                }

            } else {
                // Revert on failure
                if (desktopCountEl) desktopCountEl.textContent = previousCount;
                if (mobileCountEl) mobileCountEl.textContent = previousCount;
                
                if (previousCount === 0) {
                    if (desktopWrapper) desktopWrapper.classList.add('hidden');
                    if (mobileCountEl) mobileCountEl.classList.add('hidden');
                }
                
                showToast(data.message || 'Failed to add', 'error');
            }
        })
        .catch(error => {
            if (error.message !== 'Unauthorized') {
                console.error('Error:', error);
                
                // Revert on error
                if (desktopCountEl) desktopCountEl.textContent = previousCount;
                if (mobileCountEl) mobileCountEl.textContent = previousCount;
                
                if (previousCount === 0) {
                    if (desktopWrapper) desktopWrapper.classList.add('hidden');
                    if (mobileCountEl) mobileCountEl.classList.add('hidden');
                }

                showToast('An error occurred', 'error');
            }
        });
    }


</script>
@endpush
