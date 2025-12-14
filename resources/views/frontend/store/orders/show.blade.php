@extends('layouts.frontend')

@section('title', 'Order Details')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Button -->
    <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Orders
    </a>

    <!-- Order Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order #{{ $order->id }}</h1>
                <p class="text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            @php
                $statusColors = [
                    'unpaid' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'paid' => 'bg-green-100 text-green-800 border-green-200',
                    'shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                ];
                $color = $statusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
            @endphp
            <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase border-2 {{ $color }}">
                {{ $order->payment_status }}
            </span>
        </div>

        <!-- Customer Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Customer</h3>
                <p class="text-lg font-bold text-gray-900">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Shipping Address</h3>
                <p class="text-gray-900">{{ $order->address }}</p>
                <p class="text-gray-600">{{ $order->city }}, {{ $order->postal_code }}</p>
            </div>
        </div>

        <!-- Products -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Order Items</h3>
            <div class="space-y-3">
                @foreach($order->transactionDetails as $detail)
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-white rounded-lg overflow-hidden border border-gray-200">
                        @if($detail->product->productImages->first())
                            <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">{{ $detail->product->name }}</h4>
                        <p class="text-sm text-gray-500">Quantity: {{ $detail->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Price</p>
                        <p class="font-bold text-gray-900">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Subtotal</p>
                        <p class="font-bold text-k-pink">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="flex justify-end">
            <div class="w-full md:w-1/2 space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Shipping Cost</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Tax</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t border-gray-200">
                    <span>Total</span>
                    <span class="text-k-pink">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tracking Information -->
    @if($order->payment_status === 'paid' || $order->payment_status === 'shipped' || $order->payment_status === 'completed')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping & Tracking Information</h2>
        
        @if($order->tracking_number)
            <!-- Display Tracking Info -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 mb-2">Tracking Number</h3>
                        <p class="text-2xl font-mono font-bold text-blue-700 mb-3">{{ $order->tracking_number }}</p>
                        @if($order->shipping_info)
                            <div class="mt-4 pt-4 border-t border-blue-200">
                                <h4 class="font-semibold text-blue-900 mb-2">Shipping Details</h4>
                                <p class="text-blue-800 whitespace-pre-line">{{ $order->shipping_info }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($order->payment_status === 'paid' || ($order->payment_status === 'shipped' && !$order->tracking_number))
            <!-- Tracking Form -->
            <form action="{{ route('seller.orders.tracking', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Tracking Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20 transition-colors @error('tracking_number') border-red-500 @enderror"
                           placeholder="Enter tracking number (e.g., JNE123456789)" required>
                    @error('tracking_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Shipping Information (Optional)
                    </label>
                    <textarea name="shipping_info" rows="4" 
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20 transition-colors @error('shipping_info') border-red-500 @enderror"
                              placeholder="Add shipping details, courier name, estimated delivery, etc.">{{ old('shipping_info', $order->shipping_info) }}</textarea>
                    @error('shipping_info')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors shadow-md hover:shadow-lg">
                    {{ $order->tracking_number ? 'Update Tracking Information' : 'Add Tracking & Mark as Shipped' }}
                </button>
            </form>
        @endif
    </div>
    @endif
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
    {{ session('success') }}
</div>
@endif
@endsection
