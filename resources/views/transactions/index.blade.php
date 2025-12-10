@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">My Orders</h1>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('transactions.index') }}" 
           class="px-6 py-2 rounded-full {{ !request('status') ? 'bg-primary-900 text-white' : 'bg-white text-primary-900 border border-gray-300' }} text-sm font-medium hover:opacity-80 transition-opacity">
            All Orders
        </a>
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" 
           class="px-6 py-2 rounded-full {{ request('status') === 'pending' ? 'bg-primary-900 text-white' : 'bg-white text-primary-900 border border-gray-300' }} text-sm font-medium hover:opacity-80 transition-opacity">
            Pending
        </a>
        <a href="{{ route('transactions.index', ['status' => 'paid']) }}" 
           class="px-6 py-2 rounded-full {{ request('status') === 'paid' ? 'bg-primary-900 text-white' : 'bg-white text-primary-900 border border-gray-300' }} text-sm font-medium hover:opacity-80 transition-opacity">
            Paid
        </a>
        <a href="{{ route('transactions.index', ['status' => 'shipped']) }}" 
           class="px-6 py-2 rounded-full {{ request('status') === 'shipped' ? 'bg-primary-900 text-white' : 'bg-white text-primary-900 border border-gray-300' }} text-sm font-medium hover:opacity-80 transition-opacity">
            Shipped
        </a>
        <a href="{{ route('transactions.index', ['status' => 'completed']) }}" 
           class="px-6 py-2 rounded-full {{ request('status') === 'completed' ? 'bg-primary-900 text-white' : 'bg-white text-primary-900 border border-gray-300' }} text-sm font-medium hover:opacity-80 transition-opacity">
            Completed
        </a>
    </div>

    @if($transactions->count() === 0)
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">No orders found</h2>
            <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Start Shopping
            </a>
        </div>
    @else
        <!-- Order List -->
        <div class="space-y-4">
            @foreach($transactions as $transaction)
                <div class="card p-6 hover:shadow-medium transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-mono font-semibold text-lg mb-1">{{ $transaction->code }}</p>
                            <p class="text-sm text-gray-600">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-4 py-1 rounded-full text-sm font-medium
                            {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $transaction->payment_status === 'shipped' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $transaction->payment_status === 'paid' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </div>

                    <!-- Store Info -->
                    <p class="text-sm text-gray-600 mb-3">
                        Store: <span class="font-medium">{{ $transaction->store->name ?? 'XIV Shop' }}</span>
                    </p>

                    <!-- Order Items Preview -->
                    <div class="flex items-center gap-3 mb-4">
                        @foreach($transaction->transactionDetails->take(3) as $detail)
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($detail->product->productImages->count() > 0)
                                    <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" 
                                         alt="{{ $detail->product->name }}"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        @endforeach
                        @if($transaction->transactionDetails->count() > 3)
                            <span class="text-sm text-gray-600">
                                +{{ $transaction->transactionDetails->count() - 3 }} more
                            </span>
                        @endif
                    </div>

                    <!-- Order Total & Action -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-xl font-bold text-primary-900">
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-secondary">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
