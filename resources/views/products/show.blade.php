@extends('layouts.customer')

@section('title', $product->name)

@section('content')
<div class="container-custom py-8">
    {{-- Breadcrumbs --}}
    <nav class="flex text-sm font-medium text-gray-500 mb-8 space-x-2">
        <a href="{{ route('home') }}" class="hover:text-black">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-black">Shop</a>
        <span>/</span>
        <a href="{{ route('products.index', ['category' => $product->productCategory->id]) }}" class="hover:text-black">{{ $product->productCategory->name }}</a>
        <span>/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        {{-- Left Column: Product Images --}}
        <div class="space-y-4">
            {{-- Main Image --}}
            <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                {{-- Floating Action Buttons --}}
                <div class="absolute top-4 right-4 flex flex-col gap-3 z-10">
                    <button onclick="toggleWishlist({{ $product->id }})" 
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 {{ in_array($product->id, session('wishlist', [])) ? 'fill-red-500 text-red-500' : 'text-gray-900' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>

                @if($product->productImages->count() > 0)
                    <img id="mainImage" 
                         src="{{ asset('storage/' . $product->productImages->first()->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Thumbnail Grid --}}
            @if($product->productImages->count() > 1)
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @foreach($product->productImages as $image)
                        <div class="w-20 aspect-[3/4] bg-gray-100 flex-shrink-0 cursor-pointer overflow-hidden border border-transparent hover:border-black transition-all"
                             onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image) }}'">
                            <img src="{{ asset('storage/' . $image->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right Column: Product Info --}}
        <div>
            {{-- Title & Rating --}}
            <div class="mb-6">
                <!-- Brand/Store Name (Subtle) -->
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">
                    {{ $product->store ? $product->store->name : 'JOHN LEWIS ANYDAY' }}
                </p>

                <h1 class="text-3xl font-bold text-gray-900 mb-2 font-serif">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-2">
                    <div class="flex items-center">
                        @php $rating = $product->productReviews->avg('rating') ?: 0; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $rating ? 'text-black fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-medium text-gray-900 underline cursor-pointer">{{ $product->productReviews->count() }} Reviews</span>
                </div>
            </div>

            {{-- Price --}}
            <div class="mb-8">
                <p class="text-3xl font-bold text-gray-900">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                @if(isset($product->original_price) && $product->original_price > $product->price)
                    <p class="text-sm text-gray-500 line-through mt-1">
                         Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </p>
                @endif
            </div>

            {{-- Description --}}
            <div class="mb-8 border-b border-gray-200 pb-8">
                <h3 class="font-bold text-gray-900 mb-2">Description</h3>
                <div class="prose prose-sm text-gray-600">
                    {{ $product->description }}
                </div>
            </div>

            {{-- Product Form (Color, Size, Add to Cart) --}}
            <form id="addToCartForm" class="space-y-8">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">



                <!-- Mock Size Selector -->
                <div>
                    <h3 class="font-bold text-gray-900 mb-3">Size: <span class="text-gray-500 font-normal">M</span></h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['S', 'M', 'L', 'XL', '2XL'] as $size)
                            <button type="button" 
                                    class="h-10 px-4 border text-sm font-bold transition-all
                                           {{ $loop->index == 1 ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-900 hover:border-black' }}">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Quantity & Add to Cart --}}
                <div class="flex flex-col gap-4 pt-4 border-t border-gray-100">
                   @php
                        $isOwnProduct = auth()->check() && auth()->user()->store && $product->store_id === auth()->user()->store->id;
                    @endphp

                    @if($isOwnProduct)
                         <div class="bg-gray-100 p-4 rounded text-center text-gray-600 font-medium">
                            This is your own product
                        </div>
                    @elseif($product->stock > 0)
                        <div class="flex items-center gap-4">
                             <!-- Quantity Custom Input -->
                            <div class="flex items-center border border-gray-300 h-14 w-32">
                                <button type="button" onclick="decrementQty()" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-50">-</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                       class="w-full h-full text-center border-none text-gray-900 font-bold focus:ring-0">
                                <button type="button" onclick="incrementQty()" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-50">+</button>
                            </div>

                            <button type="submit" class="flex-1 h-14 bg-black text-white font-bold uppercase tracking-widest hover:bg-gray-800 transition-colors">
                                Add to Cart
                            </button>
                        </div>
                        <div class="text-center">
                             <span class="text-sm text-gray-500">Free delivery on orders over Rp 500.000</span>
                        </div>
                    @else
                        <button disabled class="w-full h-14 bg-gray-200 text-gray-400 font-bold cursor-not-allowed uppercase tracking-widest">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </form>

            {{-- Reviews Accordion --}}
            <div class="mt-12 border-t border-gray-200">
                <div class="border-b border-gray-200">
                    <button class="w-full py-4 flex justify-between items-center text-left" onclick="this.nextElementSibling.classList.toggle('hidden');">
                        <span class="font-bold text-gray-900">Reviews</span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="hidden pb-4 text-sm text-gray-600">
                        {{-- Reviews Section --}}
    <div class="mt-16 border-t border-gray-200 pt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 font-serif">Product Reviews</h2>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {{-- Review Stats & Filters --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Rating Circle --}}
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full border-4 border-yellow-400 flex items-center justify-center">
                        <span class="text-3xl font-bold text-gray-900">
                            {{ number_format($product->productReviews->avg('rating') ?: 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="flex text-yellow-400 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-xl">★</span>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 font-medium">
                            {{ $product->productReviews->count() }} reviews
                        </p>
                    </div>
                </div>

                {{-- Rating Distribution --}}
                <div class="space-y-3">
                    @foreach(range(5, 1) as $star)
                        @php
                            $count = $product->productReviews->where('rating', $star)->count();
                            $total = $product->productReviews->count();
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-4 text-sm">
                            <span class="w-3 font-bold text-gray-900">{{ $star }}</span>
                            <span class="text-yellow-400">★</span>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-black rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-500">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Filters (Mock) --}}
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="font-bold text-gray-900 mb-4">Reviews Filter</h3>
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <button class="flex justify-between items-center w-full text-sm font-bold text-gray-900">
                                Rating
                                <span class="text-xl leading-none">−</span>
                            </button>
                            <div class="mt-4 space-y-2">
                                @foreach(range(5, 1) as $star)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" value="{{ $star }}" class="review-filter-checkbox rounded border-gray-300 text-black focus:ring-black">
                                        <span class="text-sm text-gray-600">{{ $star }} Stars</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review List --}}
            <div class="lg:col-span-8">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <p class="font-bold text-gray-900">Review List</p>
                    <div class="flex gap-4 text-sm">
                        <button onclick="sortReviews('recent')" id="sortRecent" class="font-bold text-black border-b-2 border-black pb-4 -mb-4.5">Most Recent</button>
                        <button onclick="sortReviews('highest')" id="sortHighest" class="text-gray-500 hover:text-black">Highest Rating</button>
                        <button onclick="sortReviews('lowest')" id="sortLowest" class="text-gray-500 hover:text-black">Lowest Rating</button>
                    </div>
                </div>

                @if($product->productReviews->count() > 0)
                    <div class="space-y-8" id="reviewList">
                        @foreach($product->productReviews as $review)
                            <div class="review-item border-b border-gray-100 pb-8 last:border-0" data-rating="{{ $review->rating }}" data-date="{{ $review->created_at->timestamp }}">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-400">
                                        {{ $review->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <h4 class="font-bold text-gray-900 mb-2">Great Product!</h4>
                                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                    {{ $review->review }}
                                </p>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full overflow-hidden">
                                        <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">
                                            {{ $review->transaction->buyer->user->name }}
                                        </p>
                                        <p class="text-[10px] text-green-600 font-bold uppercase tracking-wider">Verified Buyer</p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-4 mt-6">
                                    <button class="text-xs text-gray-500 hover:text-black flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Helpful ({{ rand(0, 10) }})
                                    </button>
                                    <button class="text-xs text-gray-500 hover:text-black flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                        Not Helpful (0)
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <p class="text-gray-500 mb-4">No reviews yet for this product.</p>
                        <p class="text-sm text-gray-400">Be the first to review this product!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">You might also like</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}

// Add to Cart via AJAX
document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Show custom confirmation modal
    const confirmed = await showConfirmModal('Add this product to your cart?', 'Add to Cart');
    if (!confirmed) {
        return; // User cancelled
    }
    
    // Animate button
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerText;
    submitBtn.innerText = 'Adding...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    const quantity = parseInt(formData.get('quantity'));

    // Optimistic UI Update
    const desktopCountEl = document.getElementById('cartCountDesktop');
    const mobileCountEl = document.getElementById('cartCountMobile');
    const desktopWrapper = document.getElementById('cartCountWrapper');
    
    let previousCount = 0;
    
    // Get current count from either element
    if (desktopCountEl) {
        previousCount = parseInt(desktopCountEl.textContent || '0');
    } else if (mobileCountEl) {
        previousCount = parseInt(mobileCountEl.textContent || '0');
    }

    const newCount = previousCount + quantity;
    
    // Update Elements
    if (desktopCountEl) desktopCountEl.textContent = newCount;
    if (mobileCountEl) mobileCountEl.textContent = newCount;
    
    // Show if hidden
    if (newCount > 0) {
        if (desktopWrapper) desktopWrapper.classList.remove('hidden');
        if (mobileCountEl) mobileCountEl.classList.remove('hidden');
        
        // Mobile badge specific styling if needed, but classlist remove hidden should suffice based on blade
    }
    
    // Animate
    if (desktopCountEl) {
        desktopCountEl.parentElement.classList.add('scale-125'); // Animate the wrapper ()
        setTimeout(() => desktopCountEl.parentElement.classList.remove('scale-125'), 200);
    }
    if (mobileCountEl) {
        mobileCountEl.classList.add('scale-125');
        setTimeout(() => mobileCountEl.classList.remove('scale-125'), 200);
    }

    // Show success message immediately
    if (typeof showToast === 'function') {
        showToast('Added to Bag', 'success');
    }

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: formData.get('product_id'),
            quantity: quantity
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
            if (desktopCountEl) desktopCountEl.textContent = data.cart_count;
            if (mobileCountEl) mobileCountEl.textContent = data.cart_count;
            
            if (data.cart_count > 0) {
                 if (desktopWrapper) desktopWrapper.classList.remove('hidden');
                 if (mobileCountEl) mobileCountEl.classList.remove('hidden');
            }

        } else {
            // Revert
            if (desktopCountEl) desktopCountEl.textContent = previousCount;
            if (mobileCountEl) mobileCountEl.textContent = previousCount;
            
            if (previousCount === 0) {
                if (desktopWrapper) desktopWrapper.classList.add('hidden');
                if (mobileCountEl) mobileCountEl.classList.add('hidden');
            }

            if (typeof showToast === 'function') {
                showToast(data.message || 'Failed to add product to cart', 'error');
            } else {
                alert(data.message || 'Failed to add product to cart');
            }
        }
    })
    .catch(error => {
        if (error.message !== 'Unauthorized') {
             console.error('Error:', error);
             // Revert
            if (desktopCountEl) desktopCountEl.textContent = previousCount;
            if (mobileCountEl) mobileCountEl.textContent = previousCount;
            
            if (previousCount === 0) {
                if (desktopWrapper) desktopWrapper.classList.add('hidden');
                if (mobileCountEl) mobileCountEl.classList.add('hidden');
            }

             if (typeof showToast === 'function') {
                showToast('An error occurred while adding to cart', 'error');
             } else {
                alert('An error occurred');
             }
        }
    })
    .finally(() => {
        submitBtn.innerText = originalText;
        submitBtn.disabled = false;
    });
});

// Review Sorting Function
function sortReviews(sortType) {
    const reviewList = document.getElementById('reviewList');
    const reviews = Array.from(document.querySelectorAll('.review-item'));
    
    // Update active button state
    document.getElementById('sortRecent').classList.remove('font-bold', 'text-black', 'border-b-2', 'border-black');
    document.getElementById('sortRecent').classList.add('text-gray-500', 'hover:text-black');
    document.getElementById('sortHighest').classList.remove('font-bold', 'text-black', 'border-b-2', 'border-black');
    document.getElementById('sortHighest').classList.add('text-gray-500', 'hover:text-black');
    document.getElementById('sortLowest').classList.remove('font-bold', 'text-black', 'border-b-2', 'border-black');
    document.getElementById('sortLowest').classList.add('text-gray-500', 'hover:text-black');
    
    // Set active button
    const activeButton = sortType === 'recent' ? 'sortRecent' : (sortType === 'highest' ? 'sortHighest' : 'sortLowest');
    document.getElementById(activeButton).classList.remove('text-gray-500', 'hover:text-black');
    document.getElementById(activeButton).classList.add('font-bold', 'text-black', 'border-b-2', 'border-black');
    
    // Sort reviews
    reviews.sort((a, b) => {
        if (sortType === 'recent') {
            return parseInt(b.dataset.date) - parseInt(a.dataset.date); // Newest first
        } else if (sortType === 'highest') {
            return parseInt(b.dataset.rating) - parseInt(a.dataset.rating); // Highest first
        } else { // lowest
            return parseInt(a.dataset.rating) - parseInt(b.dataset.rating); // Lowest first
        }
    });
    
    // Reorder DOM
    reviews.forEach(review => reviewList.appendChild(review));
}

// Review Filtering
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.review-filter-checkbox');
    const reviews = document.querySelectorAll('.review-item');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // If checking a box, uncheck all others
            if (this.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== this) cb.checked = false;
                });
            }
            filterReviews();
        });
    });

    function filterReviews() {
        // Get checked rating (should only be one or zero)
        const checkedCheckbox = Array.from(checkboxes).find(cb => cb.checked);
        const checkedRating = checkedCheckbox ? checkedCheckbox.value : null;

        // If no checkbox is checked, show all
        if (!checkedRating) {
            reviews.forEach(review => review.classList.remove('hidden'));
            return;
        }

        // Show/Hide reviews based on rating
        reviews.forEach(review => {
            const rating = review.getAttribute('data-rating');
            if (rating === checkedRating) {
                review.classList.remove('hidden');
            } else {
                review.classList.add('hidden');
            }
        });
    }
});
</script>
@endsection
