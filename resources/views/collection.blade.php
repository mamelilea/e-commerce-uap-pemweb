<x-app-layout>
    <div class="relative bg-hubbub-black text-white py-24 overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-hubbub-pink rounded-full blur-[150px] opacity-20 transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500 rounded-full blur-[150px] opacity-10 transform -translate-x-1/3 translate-y-1/3"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-hubbub-pink text-xs font-bold font-sans uppercase tracking-[0.2em] mb-4 inline-block border border-white/10 px-4 py-1.5 rounded-full backdrop-blur-sm">Shop The Look</span>
            <h1 class="font-header text-5xl md:text-7xl font-bold uppercase tracking-tight mb-6 leading-none">Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Collection</span></h1>
            <p class="text-gray-400 font-sans max-w-2xl mx-auto text-lg leading-relaxed">Explore the latest drops from Sillia. Curated beauty essentials designed to empower your boldest self.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Header & Filter --}}
        <div class="bg-white p-8 rounded-[40px] shadow-xl shadow-gray-100 border border-white/50 mb-12 relative overflow-hidden animate-fade-in-up">
            <div class="absolute top-0 right-0 w-64 h-64 bg-pink-50 rounded-full blur-[80px] opacity-60 -mr-16 -mt-16 pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 border-b border-gray-100 pb-6">
                    <div>
                         <span class="text-hubbub-pink text-xs font-bold font-sans uppercase tracking-[0.2em] bg-pink-50 border border-pink-100 px-3 py-1 rounded-full mb-3 inline-block">Catalog</span>
                        <h1 class="font-header text-4xl font-bold text-hubbub-black tracking-tight leading-none">Browse <span class="text-hubbub-pink">Collection</span></h1>
                    </div>
                     <span class="text-gray-400 font-sans text-xs font-bold uppercase tracking-wide bg-gray-50 px-3 py-1 rounded-full">{{ $products->total() }} items found</span>
                </div>

                <form action="{{ route('collection') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <!-- Search -->
                     <div class="md:col-span-3">
                        <label for="search" class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2 ml-1">Search</label>
                        <div class="relative group">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-hubbub-pink transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                             </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Find your look..." class="w-full pl-10 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50/50 text-sm focus:border-hubbub-pink focus:ring focus:ring-hubbub-pink/20 transition-all shadow-sm focus:bg-white">
                        </div>
                     </div>

                     <!-- Category -->
                     <div class="md:col-span-3">
                        <label for="category" class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2 ml-1">Category</label>
                        <div class="relative group">
                            <select name="category" id="category" class="w-full pl-4 pr-10 py-3 rounded-2xl border-gray-100 bg-gray-50/50 text-sm focus:border-hubbub-pink focus:ring focus:ring-hubbub-pink/20 transition-all shadow-sm appearance-none focus:bg-white cursor-pointer hover:border-pink-200">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-hubbub-pink transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                     </div>

                    <!-- Price Min -->
                    <div class="md:col-span-2">
                        <label for="min_price" class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2 ml-1">Min Price</label>
                         <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold group-focus-within:text-hubbub-pink transition-colors">Rp</span>
                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full pl-9 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50/50 text-sm focus:border-hubbub-pink focus:ring focus:ring-hubbub-pink/20 transition-all shadow-sm focus:bg-white">
                        </div>
                    </div>

                    <!-- Price Max -->
                    <div class="md:col-span-2">
                         <label for="max_price" class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2 ml-1">Max Price</label>
                        <div class="relative group">
                             <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold group-focus-within:text-hubbub-pink transition-colors">Rp</span>
                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Any" class="w-full pl-9 pr-4 py-3 rounded-2xl border-gray-100 bg-gray-50/50 text-sm focus:border-hubbub-pink focus:ring focus:ring-hubbub-pink/20 transition-all shadow-sm focus:bg-white">
                        </div>
                    </div>
                    
                     <!-- Buttons -->
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="flex-1 bg-hubbub-pink text-white font-bold uppercase text-[10px] tracking-widest py-3 rounded-2xl hover:bg-pink-600 transition-all shadow-lg shadow-pink-200 transform hover:-translate-y-1 hover:shadow-xl">
                            Filter
                        </button>
                         <a href="{{ route('collection') }}" class="flex-1 bg-white text-gray-400 font-bold uppercase text-[10px] tracking-widest py-3 rounded-2xl border border-gray-100 hover:border-gray-300 hover:text-gray-600 transition-all text-center flex items-center justify-center hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @forelse($products as $product)
                <div class="group flex flex-col bg-white rounded-[32px] overflow-hidden hover:shadow-[0px_15px_40px_rgba(234,92,136,0.1)] transition-all duration-500 transform hover:-translate-y-2 border border-white hover:border-pink-50 relative animate-fade-in-up" style="animation-delay: {{ $loop->iteration * 100 }}ms">
                    <div class="relative overflow-hidden aspect-[4/5] bg-gray-50">
                        <a href="{{ route('product.details', $product->slug) }}" class="block w-full h-full">
                            @if($product->productImages->first())
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-1000">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                    <svg class="w-12 h-12 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Hover Action Overlay -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        
                        <div class="absolute bottom-4 right-4 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500 z-10">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-white p-3.5 rounded-full shadow-xl text-hubbub-pink hover:bg-hubbub-pink hover:text-white transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                </button>
                            </form>
                        </div>

                         @if($product->stock <= 5)
                            <div class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-lg shadow-red-200">
                                Low Stock
                            </div>
                        @elseif($loop->iteration <= 3)
                             <div class="absolute top-4 left-4 bg-hubbub-pink text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-lg shadow-pink-200">
                                Popular
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2 hidden"></div> {{-- Spacer --}}
                        <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 border border-gray-100 px-2 py-0.5 rounded-md w-fit">{{ $product->productCategory->name ?? 'Beauty' }}</div>
                        
                        <h3 class="font-sans font-bold text-hubbub-black text-base leading-snug mb-2 flex-grow">
                            <a href="{{ route('product.details', $product->slug) }}" class="hover:text-hubbub-pink transition-colors line-clamp-2">{{ $product->name }}</a>
                        </h3>
                        
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 font-medium uppercase">Price</span>
                                <p class="font-bold text-hubbub-pink text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                5.0
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 bg-white rounded-[40px] border border-dashed border-gray-200 flex flex-col items-center justify-center text-center animate-fade-in-up">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                         <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
                    <p class="text-gray-400 font-sans max-w-sm">We couldn't find any products matching your current filters. Try adjusting them or browse all.</p>
                    <a href="{{ route('collection') }}" class="mt-8 px-8 py-3 bg-hubbub-pink text-white font-bold uppercase text-xs tracking-widest rounded-full hover:bg-pink-600 transition-colors shadow-lg shadow-pink-200">Clear Filters</a>
                </div>
            @endforelse
        </div>

        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
