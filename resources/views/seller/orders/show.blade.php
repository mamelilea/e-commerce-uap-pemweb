@extends('layouts.seller')

@section('title', 'Order Details')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" style="color: #252B42;">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('seller.orders.index') }}" class="btn-outline">
            ← Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Items --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold" style="color: #252B42;">Order Items</h2>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($order->transactionDetails as $detail)
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        @if($detail->product->productImages->count() > 0)
                            <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" alt="{{ $detail->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $detail->product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                            @if($detail->note)
                                <p class="text-xs text-gray-500 mt-1">Note: {{ $detail->note }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Shipping Address</h2>
                <div class="text-sm text-gray-600">
                    <p class="font-bold text-gray-900">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_phone }}</p>
                    <p class="mt-2">{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Order Summary --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Order Summary</h2>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-bold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-gray-200 flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-lg text-primary-500">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="text-sm">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-medium">Transfer Bank</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 py-1 text-xs font-bold rounded-full
                                {{ $order->payment_status === 'completed' ? 'bg-success-100 text-success-700' : '' }}
                                {{ $order->payment_status === 'paid' ? 'bg-warning-100 text-warning-700' : '' }}
                                {{ $order->payment_status === 'processed' ? 'bg-primary-100 text-primary-700' : '' }}
                                {{ $order->payment_status === 'shipped' ? 'bg-secondary-100 text-secondary-700' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Update Status</h2>
                
                <form action="{{ route('seller.orders.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="payment_status" class="block text-sm font-bold text-gray-700 mb-2">Order Status</label>
                        <select id="payment_status" name="payment_status" class="input-field">
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processed" {{ $order->payment_status == 'processed' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->payment_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Add Tracking Number --}}
            @if($order->payment_status === 'shipped' || $order->payment_status === 'completed')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Tracking Number</h2>
                
                @if($order->tracking_number)
                    <div class="bg-success-50 border border-success-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-success-700 mb-1">Current Tracking Number:</p>
                        <p class="font-bold text-success-900">{{ $order->tracking_number }}</p>
                    </div>
                @endif

                <form action="{{ route('seller.orders.tracking', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <input 
                            type="text" 
                            name="tracking_number" 
                            value="{{ old('tracking_number', $order->tracking_number) }}"
                            class="input-field"
                            placeholder="Enter tracking number"
                            required>
                    </div>
                    
                    <button type="submit" class="btn-secondary w-full">
                        {{ $order->tracking_number ? 'Update' : 'Add' }} Tracking
                    </button>
                </form>
            </div>
            @endif

            {{-- Customer Info --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Customer</h2>
                <div class="text-sm">
                    <p class="font-bold text-gray-900">{{ $order->buyer->user->name }}</p>
                    <p class="text-gray-600">{{ $order->buyer->user->email }}</p>
                    <p class="text-gray-600 mt-2">{{ $order->buyer->phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
