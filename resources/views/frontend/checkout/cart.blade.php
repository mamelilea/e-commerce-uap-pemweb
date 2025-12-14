@extends('layouts.frontend')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 font-sans">Checkout</h1>
        <div class="w-24 h-1 bg-k-pink mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Checkout Form (Left) -->
        <div class="lg:col-span-7">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-k-blue text-white flex items-center justify-center text-sm">1</span>
                        Shipping Address
                    </h2>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" value="{{ auth()->user()->address ?? '' }}" placeholder="Street address, P.O. Box..." required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" name="postal_code" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink">
                        </div>
                        
                        <div class="sm:col-span-2">
                             <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink">
                        </div>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-k-blue text-white flex items-center justify-center text-sm">2</span>
                        Shipping Method
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-k-pink transition-colors">
                            <input type="radio" name="shipping_type" value="regular" checked class="h-4 w-4 text-k-pink focus:ring-k-pink border-gray-300">
                            <div class="ml-4 flex-1">
                                <span class="block text-sm font-bold text-gray-900">Regular Shipping</span>
                                <span class="block text-xs text-gray-500">Estimates 3-5 days</span>
                            </div>
                            <span class="font-bold text-gray-900">Rp 15.000</span>
                        </div>
                        <div class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-k-pink transition-colors">
                            <input type="radio" name="shipping_type" value="express" class="h-4 w-4 text-k-pink focus:ring-k-pink border-gray-300">
                            <div class="ml-4 flex-1">
                                <span class="block text-sm font-bold text-gray-900">Express Shipping</span>
                                <span class="block text-xs text-gray-500">Estimates 1-2 days</span>
                            </div>
                            <span class="font-bold text-gray-900">Rp 30.000</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                         <span class="w-8 h-8 rounded-full bg-k-blue text-white flex items-center justify-center text-sm">3</span>
                        Payment Method
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="wallet" class="peer sr-only" checked>
                            <div class="p-4 border rounded-xl peer-checked:border-k-pink peer-checked:bg-pink-50 hover:bg-gray-50 transition-all text-center">
                                <div class="font-bold text-gray-900">My Wallet</div>
                                <div class="text-xs text-gray-500 mt-1">Rp {{ number_format(auth()->user()->balance->balance ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="va" class="peer sr-only">
                            <div class="p-4 border rounded-xl peer-checked:border-k-pink peer-checked:bg-pink-50 hover:bg-gray-50 transition-all text-center">
                                <div class="font-bold text-gray-900">Virtual Account</div>
                                <div class="text-xs text-gray-500 mt-1">Bank Transfer</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Hidden field to indicate cart checkout -->
                <input type="hidden" name="from_cart" value="1">
                
                <button type="submit" class="w-full bg-k-pink text-white font-bold py-4 rounded-xl shadow-md hover:bg-pink-400 transition-colors text-lg">
                    Place Order
                </button>
            </form>
        </div>

        <!-- Order Summary (Right) -->
        <div class="lg:col-span-5">
            <div class="bg-gray-50 rounded-2xl p-8 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                
                @php
                    $subtotal = $cartItems->sum(function($item) {
                        return $item->product->price * $item->quantity;
                    });
                @endphp

                <!-- Cart Items -->
                <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                    @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                                 @if($item->product->productImages->first())
                                    <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                 @else
                                    <img src="https://placehold.co/100x100?text=No+Image" class="w-full h-full object-cover">
                                 @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $item->product->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $item->product->store->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping</span>
                        <span class="font-medium text-gray-900">Rp 15.000</span>
                    </div>
                    <div class="flex justify-between text-sm">
                         <span class="text-gray-500">Service Fee</span>
                        <span class="font-medium text-gray-900">Rp 1.000</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="text-lg font-bold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-k-gray">Rp {{ number_format($subtotal + 16000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
