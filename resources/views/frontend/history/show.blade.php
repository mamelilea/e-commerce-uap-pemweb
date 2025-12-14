@extends('layouts.frontend')

@section('title', 'Order #'. $transaction->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('history.index') }}" class="flex items-center text-gray-500 hover:text-gray-900 mb-8">
        <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to Orders
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Order #{{ $transaction->id }}</h1>
                <p class="text-sm text-gray-500 mt-1">Placed on {{ $transaction->created_at->format('d F Y, H:i') }}</p>
            </div>
             @php
                $statusColors = [
                    'unpaid' => 'bg-yellow-100 text-yellow-800',
                    'paid' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
                $color = $statusColors[$transaction->payment_status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase {{ $color }}">
                {{ $transaction->payment_status }}
            </span>
        </div>

        <div class="p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Payment Info</h2>
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="font-medium text-gray-900 uppercase">{{ $transaction->payment_method }}</p>
                </div>
                @if($transaction->payment_method == 'va' && $transaction->va_number)
                <div>
                    <p class="text-sm text-gray-500">Virtual Account</p>
                    <p class="font-mono text-lg font-bold text-k-pink">{{ $transaction->va_number }}</p>
                </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500">Shipping Address</p>
                    <p class="font-medium text-gray-900">{{ $transaction->address }}</p>
                </div>
            </div>

            <h2 class="text-lg font-bold text-gray-900 mb-6">Order Items</h2>
            <div class="space-y-4 mb-8">
                 {{-- Since we didn't implement TransactionDetail creating yet in Checkout (it was commented out), this might be empty. 
                      I will assume for now we might have just stored 'total_amount' and 'store_id' in a real app, 
                      but for this demo I'll show a placeholder if details empty, OR 
                      Update CheckoutController to actually create the TransactionDetail --}}
                 
                 @if($transaction->transactionDetails && $transaction->transactionDetails->count() > 0)
                    @foreach($transaction->transactionDetails as $detail)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                     @if($detail->product->productImages->first())
                                        <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                     @else
                                        <img src="https://placehold.co/100x100" class="w-full h-full object-cover">
                                     @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $detail->product->name ?? 'Product Item' }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $detail->qty }}</p>
                                </div>
                            </div>
                            <div class="font-medium text-gray-900">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                 @else
                    <div class="p-4 bg-yellow-50 text-yellow-700 rounded-lg text-sm">
                        Item details not available (Demo Mode: Checkout Controller didn't save details yet).
                    </div>
                 @endif
            </div>

            <div class="flex justify-between items-start mt-8 pt-6 border-t border-gray-100">
                <div>
                     @if($transaction->payment_status == 'shipped')
                        <form action="{{ route('history.complete', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-transform transform hover:-translate-y-1 shadow-lg">
                                Mark as Received
                            </button>
                            <p class="text-xs text-gray-500 mt-2 max-w-xs">Click this only if you have received your package. This will release funds to the seller.</p>
                        </form>
                    @endif
                </div>

                <div class="w-full sm:w-1/3 space-y-3">
                     <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-gray-900 pt-4 border-t border-gray-100">
                        <span>Total Paid</span>
                        <span class="text-k-pink">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
