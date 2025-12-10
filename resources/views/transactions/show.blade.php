@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-primary-900 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>

        <h1 class="text-3xl font-bold mb-8">Order Details</h1>

        <!-- Order Status Card -->
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="font-mono font-bold text-xl">{{ $transaction->code }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $transaction->payment_status === 'shipped' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $transaction->payment_status === 'paid' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                    {{ ucfirst($transaction->payment_status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 mb-1">Order Date</p>
                    <p class="font-medium">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Store</p>
                    <p class="font-medium">{{ $transaction->store->name ?? 'XIV Shop' }}</p>
                </div>
                @if($transaction->tracking_number)
                    <div class="col-span-2">
                        <p class="text-gray-600 mb-1">Tracking Number</p>
                        <p class="font-mono font-medium">{{ $transaction->tracking_number }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card p-6 mb-6">
            <h2 class="font-semibold mb-3">Shipping Address</h2>
            <p class="text-gray-700">
                {{ $transaction->address }}<br>
                {{ $transaction->city }}, {{ $transaction->postal_code }}
            </p>
            <p class="text-sm text-gray-600 mt-2">
                Shipping: <span class="font-medium capitalize">{{ str_replace('_', ' ', $transaction->shipping_type) }}</span>
            </p>
        </div>

        <!-- Order Items -->
        <div class="card p-6 mb-6">
            <h2 class="font-semibold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($transaction->transactionDetails as $detail)
                    <div class="flex gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            @if($detail->product->productImages->count() > 0)
                                <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" 
                                     alt="{{ $detail->product->name }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold mb-1">{{ $detail->product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                Quantity: {{ $detail->qty }} × Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                            </p>
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-primary-900">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                                
                                @if(in_array($transaction->payment_status, ['paid', 'completed', 'shipped']))
                                    @php
                                        $hasReviewed = \App\Models\ProductReview::where('transaction_id', $transaction->id)
                                            ->where('product_id', $detail->product_id)
                                            ->exists();
                                    @endphp

                                    @if($hasReviewed)
                                        <span class="text-xs font-bold text-green-600 border border-green-600 px-2 py-1 rounded">Reviewed</span>
                                    @else
                                        <button onclick="openReviewModal({{ $detail->product_id }}, '{{ $detail->product->name }}')" 
                                                class="text-xs font-bold text-gray-900 border border-black px-3 py-1 rounded hover:bg-black hover:text-white transition-colors">
                                            Write Review
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card p-6">
            <h2 class="font-semibold mb-4">Order Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">
                        Rp {{ number_format($transaction->transactionDetails->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-200">
                    <span>Total</span>
                    <span class="text-primary-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Write Review</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="product_id" id="reviewProductId">
                
                <p id="reviewProductName" class="font-medium text-gray-900 mb-4"></p>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Rating</label>
                    <div class="flex flex-row-reverse justify-end gap-1">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer hidden" required />
                            <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 peer-hover:text-yellow-400 text-2xl">★</label>
                        @endfor
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Review</label>
                    <textarea name="review" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-black focus:border-black" placeholder="Share your thoughts..." required></textarea>
                </div>
                
                <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition-colors">
                    Submit Review
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openReviewModal(productId, productName) {
        document.getElementById('reviewProductId').value = productId;
        document.getElementById('reviewProductName').textContent = 'Reviewing: ' + productName;
        document.getElementById('reviewModal').classList.remove('hidden');
    }
    
    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }
</script>
@endsection
