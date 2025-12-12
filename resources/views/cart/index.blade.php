<x-app-layout>
    <div class="py-12 bg-white md:bg-gray-50 min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-header text-4xl font-bold uppercase text-hubbub-black tracking-tighter mb-8">Your Cart</h1>
            
                @if($carts->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    {{-- Cart Items Column (Span 2) --}}
                    <div class="lg:col-span-2 space-y-8">
                        @foreach($carts->groupBy('product.store.name') as $storeName => $storeItems)
                            @php
                                $storeId = $storeItems->first()->product->store_id;
                                $storeTotal = $storeItems->sum(fn($item) => $item->product->price * $item->quantity);
                            @endphp
                            {{-- Store Card --}}
                            <div class="bg-white p-0 rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                                {{-- Card Header --}}
                                <div class="flex items-center gap-3 p-5 border-b border-gray-100 bg-pink-50/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h3 class="font-sans text-[10px] font-bold uppercase text-hubbub-black tracking-widest">{{ $storeName }}</h3>
                                </div>

                                {{-- Items List --}}
                                <div class="p-6 space-y-8">
                                    @foreach($storeItems as $item)
                                        <div class="flex gap-4 sm:gap-6 group">
                                            {{-- Product Image --}}
                                            <div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 relative">
                                                @if($item->product->productImages->first())
                                                    <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-300 font-bold uppercase tracking-widest">No IMG</div>
                                                @endif
                                            </div>

                                            {{-- Product Details --}}
                                            <div class="flex-1 flex flex-col sm:flex-row sm:justify-between gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-sans text-lg font-bold text-hubbub-black leading-tight mb-1">
                                                        <a href="{{ route('product.details', $item->product->slug) }}" class="hover:text-hubbub-pink transition-colors">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h4>
                                                    <p class="font-sans text-[10px] text-gray-400 mb-2 uppercase tracking-widest font-bold">{{ $item->product->productCategory->name ?? 'Beauty' }}</p>
                                                    <p class="font-bold text-hubbub-pink text-lg">
                                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                {{-- Actions --}}
                                                <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-between gap-4">
                                                    {{-- Delete --}}
                                                     <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-full" title="Remove Item">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    {{-- Quantity --}}
                                                    <div class="flex items-center bg-gray-50 rounded-full p-1 border border-gray-100">
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-hubbub-pink hover:bg-white inset-shadow rounded-full font-bold transition-all {{ $item->quantity <= 1 ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                                        </form>
                                                        
                                                        <div class="w-8 h-8 flex items-center justify-center font-sans font-bold text-sm text-hubbub-black select-none">
                                                            {{ $item->quantity }}
                                                        </div>

                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-hubbub-pink hover:bg-white inset-shadow rounded-full font-bold transition-all">+</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Card Footer --}}
                                <div class="bg-gray-50 p-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-gray-100">
                                    <div class="text-center sm:text-left">
                                        <p class="text-[10px] uppercase font-bold tracking-widest text-gray-400 mb-1">Subtotal from {{ $storeName }}</p>
                                        <p class="font-sans text-xl font-bold text-hubbub-black">Rp {{ number_format($storeTotal, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('checkout.index', ['store_id' => $storeId]) }}" class="bg-hubbub-black text-white font-sans font-bold uppercase text-[10px] px-8 py-3 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 tracking-widest w-full sm:w-auto text-center transform hover:-translate-y-1">
                                        Checkout Now
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Summary Column (Span 1) --}}
                    <div>
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                            <h3 class="font-sans text-lg font-bold uppercase text-hubbub-black mb-8 border-b border-gray-100 pb-4 tracking-widest">Cart Summary</h3>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="font-sans font-bold uppercase text-xs text-gray-400 tracking-wider">Total Items</span>
                                <span class="font-bold text-lg text-hubbub-black">{{ $carts->sum('quantity') }}</span>
                            </div>

                            <div class="flex justify-between items-end mb-8 pt-6 border-t border-gray-100">
                                <span class="font-sans text-sm font-bold uppercase text-gray-500 tracking-wider">Grand Total</span>
                                <span class="font-sans text-3xl font-bold text-hubbub-pink">
                                    @php
                                        $total = $carts->sum(function($item) {
                                            return $item->product->price * $item->quantity;
                                        });
                                    @endphp
                                    <span class="text-lg text-gray-400 font-normal">Rp</span> {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <p class="text-xs text-center text-gray-400 mb-8 font-sans leading-relaxed px-4">
                                <span class="block mb-1 text-hubbub-pink font-bold uppercase tracking-widest">Note</span>
                                Complete your purchase by checking out each store individually for the best shipping rates.
                            </p>
                            
                            <a href="{{ route('home') }}" class="block w-full text-center bg-gray-50 text-gray-500 font-sans font-bold uppercase text-[10px] py-4 rounded-full border border-gray-200 hover:bg-white hover:text-hubbub-pink hover:border-hubbub-pink transition-all tracking-widest hover:shadow-md">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20 max-w-2xl mx-auto">
                    <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-hubbub-pink opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="font-sans text-3xl font-bold text-hubbub-black mb-3">Your cart is empty</h2>
                    <p class="text-gray-400 mb-10 font-sans text-sm">Looks like you haven't added anything to your beauty haul yet.</p>
                    <a href="{{ route('home') }}" class="inline-block bg-hubbub-black text-white font-sans font-bold uppercase text-xs px-10 py-4 rounded-full hover:bg-hubbub-pink hover:shadow-lg hover:shadow-pink-200 transition-all tracking-widest transform hover:-translate-y-1">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
