@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            <!-- Product Images (Left) -->
            <div class="flex flex-col-reverse">
                <!-- Image Grid -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-6">
                        @foreach($product->productImages as $image)
                            <div class="relative h-24 bg-white rounded-lg cursor-pointer overflow-hidden border-2 border-transparent hover:border-k-pink transition-colors group">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image" class="w-full h-full object-center object-cover group-hover:opacity-75">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main Image -->
                <div class="w-full aspect-w-1 aspect-h-1 rounded-2xl overflow-hidden bg-gray-50 relative group shadow-sm">
                     @if($product->productImages->first())
                        <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-500">
                     @else
                        <img src="https://placehold.co/600x600/F8DDE8/333333?text=No+Image" alt="No Image" class="w-full h-full object-center object-cover">
                     @endif
                     
                     <!-- Tag -->
                    <div class="absolute top-4 left-4">
                         <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white/90 text-gray-900 border border-gray-100 shadow-sm backdrop-blur-sm">
                            {{ ucfirst($product->condition) }}
                         </span>
                    </div>
                </div>
            </div>

            <!-- Product Info (Right) -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <div class="mb-8">
                     <p class="text-sm text-k-pink font-bold mb-2 tracking-wide uppercase">{{ $product->productCategory->name ?? 'Merchandise' }}</p>
                     <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 mb-4 font-sans leading-tight">{{ $product->name }}</h1>
                     <div class="flex items-end gap-4">
                        <p class="text-3xl text-gray-900 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @if($product->stock > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-1">
                                Stock: {{ $product->stock }}
                            </span>
                        @else
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mb-1">
                                Out of Stock
                            </span>
                        @endif
                     </div>
                </div>

                <!-- Store Info -->
                <div class="flex items-center gap-4 p-5 bg-white border border-gray-100 shadow-sm rounded-2xl mb-8 transform transition-transform hover:-translate-y-1 duration-300">
                     <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-blue-500 font-bold text-xl overflow-hidden">
                        @if($product->store->logo)
                             <img src="{{ asset('storage/' . $product->store->logo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($product->store->name, 0, 1) }}
                        @endif
                     </div>
                     <div>
                         <h3 class="text-base font-bold text-gray-900">{{ $product->store->name }}</h3>
                         <p class="text-xs text-green-600 flex items-center gap-1 mt-0.5">
                             <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                             Verified Official Store
                         </p>
                     </div>
                     <a href="#" class="ml-auto text-xs font-bold text-gray-900 bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                         Visit Shop
                     </a>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">About the Product</h3>
                    <div class="text-base text-gray-600 space-y-4 leading-relaxed font-light">
                        <p>{{ $product->about ?? 'No description available for this product.' }}</p>
                    </div>
                </div>

                <form id="buyNowForm" action="{{ route('buy.now') }}" method="POST" class="mt-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                         <div class="flex items-center border border-gray-300 rounded-xl bg-white w-max">
                             <button type="button" class="px-4 py-3 text-gray-600 hover:text-gray-900 font-bold" onclick="this.nextElementSibling.stepDown()">-</button>
                             <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-none focus:ring-0 p-0 text-gray-900 font-bold bg-transparent">
                             <button type="button" class="px-4 py-3 text-gray-600 hover:text-gray-900 font-bold" onclick="this.previousElementSibling.stepUp()">+</button>
                         </div>
                    
                        <button type="submit" class="flex-1 bg-gray-900 text-white border border-transparent rounded-xl py-4 px-8 flex items-center justify-center text-base font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Buy Now
                        </button>
                        
                        <button type="button" onclick="submitToCart(event)" class="flex-1 bg-white text-gray-900 border border-gray-200 rounded-xl py-4 px-8 flex items-center justify-center text-base font-bold hover:border-gray-900 transition-all shadow-sm hover:shadow-md">
                            Add to Cart
                        </button>
                    </div>
                </form>

                <script>
                function submitToCart(e) {
                    e.preventDefault();
                    const form = document.getElementById('buyNowForm');
                    form.action = '{{ route('cart.store') }}';
                    form.submit();
                }
                </script>

                <form action="{{ route('wishlist.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="flex items-center gap-2 text-gray-500 hover:text-k-pink transition-colors">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="font-medium">Add to Wishlist</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Product Reviews -->
        <div class="mt-24 border-t border-gray-100 pt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Customer Reviews</h2>
            
            @php
                $reviews = $product->productReviews()->with('transaction.user')->latest()->get();
                $averageRating = $reviews->avg('rating') ?? 0;
                $totalReviews = $reviews->count();
            @endphp

            <!-- Rating Summary -->
            <div class="bg-white rounded-2xl p-8 border border-gray-100 mb-8">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-gray-900 mb-2">{{ number_format($averageRating, 1) }}</div>
                        <div class="flex items-center justify-center gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500">{{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }}</p>
                    </div>

                    <div class="flex-1">
                        @for($star = 5; $star >= 1; $star--)
                            @php
                                $starCount = $reviews->where('rating', $star)->count();
                                $percentage = $totalReviews > 0 ? ($starCount / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-sm text-gray-600 w-12">{{ $star }} star</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-12 text-right">{{ $starCount }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            @if($reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-white rounded-2xl p-6 border border-gray-100">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($review->transaction->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $review->transaction->user->name ?? 'Anonymous' }}</h4>
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $review->review }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-12 border border-gray-100 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h3>
                    <p class="text-gray-500">Be the first to review this product!</p>
                </div>
            @endif
        </div>
        
        <!-- Related Products -->
        <div class="mt-24 border-t border-gray-100 pt-16">
             <div class="flex items-center justify-between mb-8">
                 <h2 class="text-2xl font-bold text-gray-900">You might also like</h2>
                 <a href="{{ route('home') }}" class="text-sm font-medium text-k-pink hover:text-pink-600">Browse All</a>
             </div>
             
             <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                 @foreach($relatedProducts as $related)
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <!-- Image -->
                        <div class="relative w-full h-64 bg-gray-50 overflow-hidden">
                             @if($related->productImages->first())
                                <img src="{{ asset('storage/' . $related->productImages->first()->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                             @else
                                <img src="https://placehold.co/400x400?text=No+Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                             @endif
                             
                             <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                 <a href="{{ route('product.show', $related->id) }}" class="px-4 py-2 bg-white text-gray-900 font-bold rounded-full text-sm hover:bg-k-pink hover:text-white transition-colors shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                     View Details
                                 </a>
                             </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <p class="text-xs text-gray-500 mb-1">{{ $related->productCategory->name ?? 'Uncategorized' }}</p>
                            <a href="{{ route('product.show', $related->id) }}">
                                <h3 class="font-bold text-gray-900 text-lg leading-tight hover:text-k-pink transition-colors line-clamp-1">{{ $related->name }}</h3>
                            </a>
                            
                            <div class="flex items-center justify-between pt-4 mt-2 border-t border-gray-50">
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                 @endforeach
             </div>
        </div>
    </div>
@endsection
