<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/3 order-md-2">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-semibold mb-3">Order Summary</h3>
                            <div class="flex gap-3 mb-3">
                                <div class="w-16 h-16 bg-gray-200 rounded"></div>
                                <div>
                                    <h4 class="font-medium">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-500">1 x Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Shipping</span>
                                    <span id="shipping-cost-display">Rp 0</span>
                                </div>
                                <div class="flex justify-between font-bold border-t pt-2 mt-2">
                                    <span>Total</span>
                                    <span id="total-display">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-2/3 order-md-1">
                        <h3 class="font-semibold text-lg mb-4">Shipping Details</h3>
                        <form method="POST" action="{{ route('checkout.store', $product->slug) }}">
                            @csrf
                            
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

                            <div class="mb-4">
                                <x-input-label for="shipping" :value="__('Shipping Service')" />
                                <select id="shipping" name="shipping" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="JNE (Rp 15.000)" data-cost="15000">JNE (Rp 15.000)</option>
                                    <option value="J&T (Rp 14.000)" data-cost="14000">J&T (Rp 14.000)</option>
                                    <option value="Sicepat (Rp 13.000)" data-cost="13000">Sicepat (Rp 13.000)</option>
                                </select>
                            </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const shippingSelect = document.getElementById('shipping');
                                const shippingDisplay = document.getElementById('shipping-cost-display');
                                const totalDisplay = document.getElementById('total-display');
                                const productPrice = {{ $product->price }};

                                function formatRupiah(number) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
                                }

                                function calculateTotal() {
                                    const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
                                    const shippingCost = parseInt(selectedOption.dataset.cost || 0);
                                    
                                    const total = productPrice + shippingCost;

                                    if(shippingDisplay) shippingDisplay.textContent = formatRupiah(shippingCost);
                                    if(totalDisplay) totalDisplay.textContent = formatRupiah(total);
                                }

                                shippingSelect.addEventListener('change', calculateTotal);
                                
                                calculateTotal();
                            });
                        </script>

                            <div class="mt-6">
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Place Order') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
