@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Left: Shipping Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Address -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                Street Address *
                            </label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                required
                                class="input-field"
                                value="{{ old('address') }}"
                                placeholder="Enter your street address">
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                                    City *
                                </label>
                                <input 
                                    type="text" 
                                    id="city" 
                                    name="city" 
                                    required
                                    class="input-field"
                                    value="{{ old('city') }}"
                                    placeholder="City">
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Postal Code *
                                </label>
                                <input 
                                    type="text" 
                                    id="postal_code" 
                                    name="postal_code" 
                                    required
                                    class="input-field"
                                    value="{{ old('postal_code') }}"
                                    placeholder="12345">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Method</h2>
                    
                    <div class="space-y-3" x-data="{ shipping: 'regular', cost: 10000 }">
                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors"
                               :class="shipping === 'regular' ? 'border-primary-900 bg-primary-50' : 'border-gray-200 hover:border-gray-300'">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="shipping_type" 
                                    value="regular" 
                                    class="mr-3"
                                    x-model="shipping"
                                    @change="cost = 10000"
                                    required>
                                <div>
                                    <p class="font-medium">Regular Shipping</p>
                                    <p class="text-sm text-gray-600">5-7 business days</p>
                                </div>
                            </div>
                            <span class="font-semibold">Rp 10.000</span>
                        </label>

                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors"
                               :class="shipping === 'express' ? 'border-primary-900 bg-primary-50' : 'border-gray-200 hover:border-gray-300'">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="shipping_type" 
                                    value="express" 
                                    class="mr-3"
                                    x-model="shipping"
                                    @change="cost = 25000"
                                    required>
                                <div>
                                    <p class="font-medium">Express Shipping</p>
                                    <p class="text-sm text-gray-600">2-3 business days</p>
                                </div>
                            </div>
                            <span class="font-semibold">Rp 25.000</span>
                        </label>

                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors"
                               :class="shipping === 'same_day' ? 'border-primary-900 bg-primary-50' : 'border-gray-200 hover:border-gray-300'">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="shipping_type" 
                                    value="same_day" 
                                    class="mr-3"
                                    x-model="shipping"
                                    @change="cost = 50000"
                                    required>
                                <div>
                                    <p class="font-medium">Same Day Delivery</p>
                                    <p class="text-sm text-gray-600">Today (if ordered before 12pm)</p>
                                </div>
                            </div>
                            <span class="font-semibold">Rp 50.000</span>
                        </label>

                        @error('shipping_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors hover:border-gray-400"
                               onclick="this.querySelector('input').checked = true">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="cod" 
                                    class="mr-3"
                                    checked
                                    required>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="font-medium text-gray-900">Cash on Delivery (COD)</p>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Pay when you receive the product</p>
                                </div>
                            </div>
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">Recommended</span>
                        </label>

                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors hover:border-gray-400"
                               onclick="this.querySelector('input').checked = true">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="bank_transfer" 
                                    class="mr-3"
                                    required>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <p class="font-medium text-gray-900">Bank Transfer</p>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Transfer to our bank account</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors hover:border-gray-400"
                               onclick="this.querySelector('input').checked = true">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="e_wallet" 
                                    class="mr-3"
                                    required>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="font-medium text-gray-900">E-Wallet</p>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">GoPay, OVO, DANA, ShopeePay</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer transition-colors hover:border-gray-400"
                               onclick="this.querySelector('input').checked = true">
                            <div class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="credit_card" 
                                    class="mr-3"
                                    required>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <p class="font-medium text-gray-900">Credit/Debit Card</p>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Visa, Mastercard, JCB</p>
                                </div>
                            </div>
                        </label>

                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24" x-data="{ shippingCost: 10000 }">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                        @foreach($filteredCart as $item)
                            <div class="flex gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}"
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    <p class="text-sm font-semibold">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-3 border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium" x-text="'Rp ' + shippingCost.toLocaleString('id-ID')">Rp 10.000</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (11%)</span>
                            <span class="font-medium">Rp {{ number_format($subtotal * 0.11, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-primary-900" x-text="'Rp ' + ({{ $subtotal }} + shippingCost + {{ $subtotal * 0.11 }}).toLocaleString('id-ID')">
                                    Rp {{ number_format($subtotal + 10000 + ($subtotal * 0.11), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="w-full btn-primary mt-6">
                        Place Order
                    </button>

                    <script>
                        // Update shipping cost when radio changes
                        document.querySelectorAll('input[name="shipping_type"]').forEach(radio => {
                            radio.addEventListener('change', (e) => {
                                const costs = {
                                    'regular': 10000,
                                    'express': 25000,
                                    'same_day': 50000
                                };
                                Alpine.store('shippingCost', costs[e.target.value]);
                            });
                        });
                    </script>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
