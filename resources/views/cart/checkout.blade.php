<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('cart.checkout.process') }}">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg mb-4">Shipping Information (One address for all orders)</h3>
                        

                         <div class="mb-4">
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                        </div>


                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" required />
                            </div>
                            <div>
                                <x-input-label for="postal_code" :value="__('Postal Code')" />
                                <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg mb-4">Order Summary</h3>
                        
                        <div class="divide-y">
                            @php $totalProductPrice = 0; $storeCount = 0; @endphp
                            @foreach($groupedItems as $storeId => $items)
                                @php 
                                    $store = $items->first()->product->store;
                                    $storeCount++;
                                @endphp
                                <div class="py-4">
                                    <h4 class="font-bold text-gray-700 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $store->name }}
                                    </h4>
                                    @foreach($items as $item)
                                        @php $totalProductPrice += $item->product->price * $item->quantity; @endphp
                                        <div class="flex justify-between items-center ml-6 mb-2">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gray-200 rounded overflow-hidden mr-3">
                                                    @if($item->product->productImages->count() > 0)
                                                        <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium">{{ $item->product->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <span class="text-sm font-semibold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach

                                    <input type="hidden" name="shipping[{{ $storeId }}]" class="store-shipping-input" value="JNE (Rp 15.000)">
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <div class="flex justify-between items-center mb-2">
                                 <span class="text-gray-600">Subtotal (Products)</span>
                                 <span class="font-semibold" id="total-product-price" data-value="{{ $totalProductPrice }}">Rp {{ number_format($totalProductPrice, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="global_shipping" :value="__('Shipping Service (Applied to all ' . $storeCount . ' stores)')" />
                                <select id="global_shipping" 
                                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="JNE (Rp 15.000)" data-cost="15000">JNE ((Rp 15.000) / store)</option>
                                    <option value="J&T (Rp 14.000)" data-cost="14000">J&T ((Rp 14.000) / store)</option>
                                    <option value="Sicepat (Rp 13.000)" data-cost="13000">Sicepat ((Rp 13.000) / store)</option>
                                </select>
                            </div>

                            <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                                <span>Total Shipping Cost ({{ $storeCount }} stores)</span>
                                <span id="total-shipping-cost">Rp 0</span>
                            </div>

                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-dashed">
                                 <span class="text-xl font-bold text-gray-800">Total Payment</span>
                                 <span class="text-2xl font-bold text-indigo-600" id="grand-total-display">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mb-12">
                     <x-primary-button class="text-lg py-3 px-8">
                        {{ __('Place Order') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const globalShippingSelect = document.getElementById('global_shipping');
            const storeShippingInputs = document.querySelectorAll('.store-shipping-input');
            const totalProductPrice = parseInt(document.getElementById('total-product-price').dataset.value);
            const storeCount = {{ $storeCount }};
            
            function updateTotals() {
                const selectedOption = globalShippingSelect.options[globalShippingSelect.selectedIndex];
                const costPerStore = parseInt(selectedOption.dataset.cost || 0);
                const combinedShippingCost = costPerStore * storeCount;
                const shippingValue = selectedOption.value; // e.g. "JNE (Rp 15.000)"
                
                // Update hidden inputs for backend
                storeShippingInputs.forEach(input => {
                    input.value = shippingValue;
                });

                // Update Display
                document.getElementById('total-shipping-cost').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(combinedShippingCost);
                
                const grandTotal = totalProductPrice + combinedShippingCost;
                document.getElementById('grand-total-display').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
            }

            // Event Listener
            globalShippingSelect.addEventListener('change', updateTotals);

            // Initial Calculate
            updateTotals();
        });
    </script>
</x-app-layout>

