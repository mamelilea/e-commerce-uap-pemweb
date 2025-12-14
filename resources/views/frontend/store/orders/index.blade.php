@extends('layouts.frontend')

@section('title', 'Order Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
             <a href="{{ route('store.index') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900 font-sans">Incoming Orders</h1>
            <p class="text-gray-500 mt-1">Manage and track your customer orders.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($orders->isEmpty())
             <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No New Orders</h3>
                <p class="text-gray-500 mt-2">Wait for customers to discover your aesthetic products.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-mono text-sm font-bold text-gray-500">#{{ $order->id }}</span>
                                <span class="text-xs text-gray-400">• {{ $order->created_at->format('d M Y, H:i') }}</span>
                                 @php
                                    $statusColors = [
                                        'unpaid' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'shipped' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $color }}">
                                    {{ $order->payment_status }}
                                </span>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $order->user->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $order->address }}</p>
                            
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach($order->transactionDetails as $detail)
                                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-lg p-2 pr-4 shadow-sm">
                                        <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden">
                                            @if($detail->product->productImages->first())
                                                <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://placehold.co/100x100?text=IMG" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">{{ $detail->product->name }}</p>
                                            <p class="text-xs text-gray-500">x{{ $detail->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-4 min-w-[200px]">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">Total Payment</p>
                                <p class="text-xl font-bold text-k-pink">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('seller.orders.show', $order->id) }}" class="px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                                    View Details
                                </a>
                                
                                @if($order->payment_status == 'paid')
                                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="shipped">
                                        <button type="submit" class="px-4 py-2 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors">
                                            Mark as Shipped
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
