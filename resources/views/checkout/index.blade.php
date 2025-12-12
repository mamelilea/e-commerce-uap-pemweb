<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-header text-4xl font-bold uppercase text-hubbub-black tracking-tighter mb-8">Secure Checkout</h1>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                @if($storeId)
                    <input type="hidden" name="store_id" value="{{ $storeId }}">
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    {{-- Left Column: Shipping & Details --}}
                    <div class="space-y-8">
                        {{-- Shipping Address --}}
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Shipping Information
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="address" class="block font-sans font-bold uppercase text-xs text-gray-400 tracking-wider mb-2">Full Address</label>
                                    <textarea name="address" id="address" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 font-sans text-sm focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300 resize-none" placeholder="Street, Number, Unit..." required></textarea>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label for="city" class="block font-sans font-bold uppercase text-xs text-gray-400 tracking-wider mb-2">City</label>
                                        <input type="text" name="city" id="city" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 font-sans text-sm focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" required>
                                    </div>
                                    <div>
                                        <label for="postal_code" class="block font-sans font-bold uppercase text-xs text-gray-400 tracking-wider mb-2">Postal Code</label>
                                        <input type="text" name="postal_code" id="postal_code" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 font-sans text-sm focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" required>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="shipping_type" class="block font-sans font-bold uppercase text-xs text-gray-400 tracking-wider mb-2">Shipping Type</label>
                                    <div class="relative">
                                        <select name="shipping_type" id="shipping_type" class="w-full appearance-none bg-gray-50 border border-gray-100 rounded-2xl p-4 font-sans text-sm focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300 cursor-pointer">
                                            <option value="REG">Regular (Rp 20.000) - 3-5 Days</option>
                                            <option value="YES">Next Day (Rp 35.000) - 1 Day</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                             <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Payment Method
                             </h3>
                             <div class="space-y-4">
                                 <label class="group flex items-center p-5 border border-gray-100 rounded-2xl cursor-pointer hover:border-hubbub-pink/50 hover:bg-pink-50/30 transition-all duration-300 has-[:checked]:border-hubbub-pink has-[:checked]:bg-pink-50/50 has-[:checked]:shadow-md">
                                     <input type="radio" class="form-radio text-hubbub-pink focus:ring-hubbub-pink h-5 w-5 bg-gray-100 border-gray-300" name="payment_method" value="wallet" checked>
                                     <div class="ml-4 flex-1">
                                         <span class="block font-sans font-bold uppercase text-sm tracking-wide group-hover:text-hubbub-pink transition-colors">My Wallet</span>
                                         <span class="block text-xs text-gray-400 font-sans mt-1">Current Balance: <span class="text-hubbub-black font-bold">Rp {{ number_format(Auth::user()->balance->balance ?? 0, 0, ',', '.') }}</span></span>
                                     </div>
                                 </label>
                                 
                                 <label class="group flex items-center p-5 border border-gray-100 rounded-2xl cursor-pointer hover:border-hubbub-pink/50 hover:bg-pink-50/30 transition-all duration-300 has-[:checked]:border-hubbub-pink has-[:checked]:bg-pink-50/50 has-[:checked]:shadow-md">
                                     <input type="radio" class="form-radio text-hubbub-pink focus:ring-hubbub-pink h-5 w-5 bg-gray-100 border-gray-300" name="payment_method" value="va">
                                     <div class="ml-4 flex-1">
                                         <span class="block font-sans font-bold uppercase text-sm tracking-wide group-hover:text-hubbub-pink transition-colors">Bank Transfer</span>
                                         <span class="block text-xs text-gray-400 font-sans mt-1">Virtual Account (BCA, Mandiri, BNI)</span>
                                     </div>
                                 </label>
                              </div>
                        </div>
                    </div>

                    {{-- Right Column: Order Summary --}}
                    <div>
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                            <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 tracking-widest border-b border-gray-100 pb-4">Order Summary</h3>
                            
                            <div class="space-y-6 mb-8 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($carts as $item)
                                    <div class="flex gap-4 items-center group">
                                         <div class="w-16 h-16 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                             @if($item->product->productImages->first())
                                                <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                            @endif
                                         </div>
                                        <div class="flex-1">
                                            <p class="font-sans font-bold text-hubbub-black text-sm leading-tight mb-1 group-hover:text-hubbub-pink transition-colors">{{ $item->product->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item->product->store->name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-xs text-gray-400 mb-1">x{{ $item->quantity }}</p>
                                            <p class="font-bold text-sm text-hubbub-pink">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 pt-6 space-y-3">
                                <div class="flex justify-between font-sans text-gray-500 text-sm">
                                    <span>Subtotal</span>
                                    <span class="font-bold text-hubbub-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-sans text-gray-500 text-sm">
                                    <span>Tax (11%)</span>
                                    <span class="font-bold text-hubbub-black">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-sans text-gray-500 text-sm">
                                    <span>Shipping (Est.)</span>
                                    <span class="font-bold text-hubbub-black">Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-end font-sans pt-6 border-t border-gray-100 mt-4">
                                    <span class="uppercase font-bold text-sm tracking-widest text-hubbub-black">Total</span>
                                    <span class="text-3xl font-bold text-hubbub-pink">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold uppercase text-xs tracking-widest py-4 mt-8 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-1">
                                Place Order
                            </button>
                            
                            <p class="text-[10px] text-center text-gray-400 mt-6 font-sans">
                                By placing this order, you agree to our <a href="#" class="text-hubbub-pink hover:underline">Terms of Service</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
