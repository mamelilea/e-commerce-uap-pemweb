@extends('layouts.frontend')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    @foreach($cartItems as $item)
                        <div class="flex gap-6 p-6 border-b border-gray-100 last:border-b-0">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 w-24 h-24 bg-gray-50 rounded-lg overflow-hidden">
                                @if($item->product->productImages->first())
                                    <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="https://placehold.co/200x200?text=No+Image" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('product.show', $item->product->slug) }}" class="block">
                                    <h3 class="text-lg font-bold text-gray-900 hover:text-k-pink transition-colors line-clamp-2">
                                        {{ $item->product->name }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500 mt-1">{{ $item->product->productCategory->name ?? 'Uncategorized' }}</p>
                                <p class="text-lg font-bold text-gray-900 mt-2">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center gap-4 mt-4">
                                    <!-- Quantity Controls -->
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg bg-white">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="decrease" class="px-3 py-2 text-gray-600 hover:text-gray-900 font-bold">-</button>
                                        <span class="px-4 text-gray-900 font-bold">{{ $item->quantity }}</span>
                                        <button type="submit" name="action" value="increase" class="px-3 py-2 text-gray-600 hover:text-gray-900 font-bold">+</button>
                                    </form>

                                    <!-- Remove Button -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-gray-500 hover:text-red-500 transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Item Total -->
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    @php
                        $subtotal = $cartItems->sum(function($item) {
                            return $item->product->price * $item->quantity;
                        });
                    @endphp

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="font-medium">Calculated at checkout</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="block w-full bg-k-pink text-white text-center py-3 rounded-lg font-bold hover:bg-pink-400 transition-colors">
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('home') }}" class="block w-full text-center text-gray-600 py-3 mt-3 hover:text-gray-900 transition-colors">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Your Cart is Empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-k-pink hover:bg-pink-400 transition-colors">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
