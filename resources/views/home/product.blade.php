<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-8">

                    <div class="w-full md:w-1/2">
                        <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($product->productImages->count() > 0)
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 text-2xl">Product Image</span>
                            @endif
                        </div>
                    </div>
                    

                    <div class="w-full md:w-1/2">
                        <div class="flex justify-between items-start mb-2">
                            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                            <div class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                                <span class="text-[#ff9900] font-bold mr-1">{{ number_format($product->average_rating, 1) }}</span>
                                <svg class="w-5 h-5 text-[#ff9900] fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <span class="text-xs text-gray-500 ml-1">({{ $product->review_count }})</span>
                            </div>
                        </div>
                        <p class="text-2xl text-primary font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="text-sm text-gray-500">
                                Category: <span class="font-medium text-gray-700">{{ $product->productCategory->name }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Condition: <span class="font-medium text-gray-700 capitalize">{{ $product->condition }}</span>
                            </div>
                            <div class="text-sm text-gray-500">

                            </div>
                        </div>

                        <div class="border-t border-b py-4 mb-6">
                            <h3 class="font-semibold mb-2">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>
                        
                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">Store:</span>
                                <span class="font-semibold">{{ $product->store->name }}</span>
                                @if($product->store->is_verified)
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Verified</span>
                                @endif
                                <span class="text-xs text-gray-400">({{ $product->store->city }})</span>
                            </div>
                        </div>


                        <div class="flex gap-4">
                            <a href="{{ route('checkout', $product->slug) }}" class="bg-black text-white px-6 py-3 rounded-lg font-semibold w-full transition duration-200 text-center hover:bg-[#ff9900] hover:text-black">
                                Buy Now
                            </a>
                            <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-white text-black border border-black px-6 py-3 rounded-lg font-semibold transition duration-200 whitespace-nowrap hover:border-[#ff9900] hover:text-[#ff9900]">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="p-6 mt-8 border-t pt-8 bg-gray-50">
                    <h2 class="text-2xl font-bold mb-6">Customer Reviews ({{ $product->review_count }})</h2>
                    
                    @if($product->reviews->isEmpty())
                        <p class="text-gray-500 italic">No reviews yet. Be the first to rate this product!</p>
                    @else
                        <div class="grid gap-6">
                            @foreach($product->reviews as $review)
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                                @if($review->user->avatar)
                                                    <img src="{{ asset('storage/' . $review->user->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-gray-500 font-bold">{{ substr($review->user->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center bg-orange-50 px-2 py-1 rounded border border-orange-100">
                                            <span class="font-bold text-[#ff9900] mr-1">{{ $review->rating }}</span>
                                            <svg class="w-4 h-4 text-[#ff9900] fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
