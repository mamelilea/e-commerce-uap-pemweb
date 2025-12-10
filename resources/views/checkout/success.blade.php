@extends('layouts.customer')

@section('title', 'Order Successful')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Icon -->
        <div class="text-center mb-8 animate-scale-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for your purchase.</p>
        </div>

        <!-- Order Details Card -->
        <div class="card p-8 mb-6">
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Order Number</span>
                    <span class="font-mono font-semibold text-lg">{{ $transaction->code }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Order Date</span>
                    <span class="font-medium">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Shipping Address</h3>
                <p class="text-gray-600">
                    {{ $transaction->address }}<br>
                    {{ $transaction->city }}, {{ $transaction->postal_code }}
                </p>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold mb-3">Order Items</h3>
                <div class="space-y-3">
                    @foreach($transaction->transactionDetails as $detail)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                @if($detail->product->productImages->count() > 0)
                                    <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" 
                                         alt="{{ $detail->product->name }}"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ $detail->product->name }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $detail->qty }}</p>
                                <p class="text-sm font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t border-gray-200 pt-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping ({{ ucfirst($transaction->shipping_type) }})</span>
                        <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t">
                        <span>Total</span>
                        <span class="text-primary-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                    </svg>
                    <p class="text-sm font-medium text-yellow-800">
                        Payment Status: <span class="capitalize">{{ $transaction->payment_status }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('transactions.index') }}" class="flex-1 btn-primary text-center">
                View My Orders
            </a>
            <a href="{{ route('home') }}" class="flex-1 btn-secondary text-center">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
