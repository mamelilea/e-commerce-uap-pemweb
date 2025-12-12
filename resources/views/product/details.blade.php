<x-app-layout>
    <div class="py-12 bg-white animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16 items-start">
                <div class="space-y-6">
                    @if($product->productImages->first())
                        <div class="aspect-[4/5] bg-gray-50 rounded-[40px] w-full overflow-hidden relative group shadow-2xl shadow-gray-100 border border-gray-100">
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        </div>
                        @if($product->productImages->count() > 1)
                            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                                @foreach($product->productImages as $img)
                                    <div class="w-24 h-24 flex-shrink-0 cursor-pointer rounded-2xl overflow-hidden border-2 border-transparent hover:border-hubbub-pink transition-all transform hover:-translate-y-1 shadow-sm">
                                        <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="aspect-[4/5] bg-gray-50 rounded-[40px] w-full flex items-center justify-center border border-gray-100">
                             <svg class="w-24 h-24 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col h-full pt-4">
                    <div class="mb-8">
                         <div class="flex items-center gap-2 mb-4">
                             <a href="#" class="px-3 py-1 bg-pink-50 text-hubbub-pink text-[10px] font-bold font-sans uppercase tracking-[0.2em] rounded-full border border-pink-100 hover:bg-hubbub-pink hover:text-white transition-colors">
                                {{ $product->productCategory->name ?? 'Beauty' }}
                            </a>
                            @if($product->stock <= 5)
                                <span class="text-red-500 text-[10px] font-bold font-sans uppercase tracking-widest">• Low Stock</span>
                            @endif
                         </div>

                        <h1 class="font-header text-4xl md:text-6xl font-bold text-hubbub-black tracking-tight leading-none mb-6">{{ $product->name }}</h1>
                        
                        <div class="flex items-center justify-between border-b border-gray-100 pb-8">
                             <p class="font-sans text-3xl md:text-4xl font-bold text-hubbub-pink">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                             <div class="text-right">
                                 <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Sold By</p>
                                 <div class="flex items-center gap-2 justify-end">
                                     <span class="font-sans font-bold text-gray-800">{{ $product->store->name }}</span>
                                     @if($product->store->is_verified)
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                     @endif
                                 </div>
                             </div>
                        </div>
                    </div>

                    <div class="prose prose-p:text-gray-500 prose-headings:font-bold font-sans text-gray-600 mb-10 max-w-none leading-relaxed">
                        <h3 class="font-sans text-sm font-bold uppercase tracking-widest text-hubbub-black mb-4">Description</h3>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-10 bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <div>
                            <span class="font-bold uppercase text-[10px] tracking-widest text-gray-400 block mb-1">Condition</span>
                            <span class="font-bold text-hubbub-black">{{ ucfirst($product->condition) }}</span>
                        </div>
                        <div>
                            <span class="font-bold uppercase text-[10px] tracking-widest text-gray-400 block mb-1">Weight</span>
                            <span class="font-bold text-hubbub-black">{{ $product->weight }} gr</span>
                        </div>
                        <div>
                            <span class="font-bold uppercase text-[10px] tracking-widest text-gray-400 block mb-1">Location</span>
                            <span class="font-bold text-hubbub-black">{{ $product->store->city }}</span>
                        </div>
                        <div>
                            <span class="font-bold uppercase text-[10px] tracking-widest text-gray-400 block mb-1">Stock</span>
                            <span class="font-bold text-hubbub-black">{{ $product->stock }} items</span>
                        </div>
                    </div>

                    {{-- Add to Cart --}}
                    @auth
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center gap-4 bg-white p-2 rounded-[30px] shadow-2xl shadow-gray-100 border border-gray-50 sticky bottom-4">
                                <div class="w-32 bg-gray-50 rounded-full flex items-center px-4 relative group">
                                     <label for="quantity" class="sr-only">Quantity</label>
                                     <button type="button" onclick="document.getElementById('quantity').stepDown()" class="text-gray-400 hover:text-hubbub-pink transition-colors font-bold text-lg p-2">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full bg-transparent border-none p-3 text-center font-bold focus:ring-0 text-hubbub-black">
                                    <button type="button" onclick="document.getElementById('quantity').stepUp()" class="text-gray-400 hover:text-hubbub-pink transition-colors font-bold text-lg p-2">+</button>
                                </div>

                                <button type="submit" class="flex-1 bg-hubbub-pink text-white font-sans font-bold uppercase text-sm tracking-widest py-4 rounded-full hover:bg-pink-600 transition-all shadow-lg shadow-pink-200 transform hover:-translate-y-1">
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-gradient-to-r from-gray-50 to-white p-8 text-center mt-auto rounded-3xl border border-gray-100 shadow-sm">
                            <p class="font-sans font-bold uppercase tracking-wide mb-3 text-gray-400 text-xs">Want to cop this?</p>
                            <a href="{{ route('login') }}" class="inline-block bg-hubbub-black text-white px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest hover:bg-hubbub-pink transition-colors shadow-lg">Login to purchase</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
