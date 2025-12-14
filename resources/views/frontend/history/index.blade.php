@extends('layouts.frontend')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">My Orders</h1>
            <p class="text-gray-600">Track and manage your order history</p>
        </div>

        @if($transactions->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl p-16 text-center shadow-lg border border-gray-200">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-k-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Orders Yet</h3>
                    <p class="text-gray-500 mb-8">Start shopping to see your orders here. Discover amazing products from our sellers!</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-k-pink to-pink-500 text-white rounded-xl font-bold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-5">
                @foreach($transactions as $transaction)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700">Order ID:</span>
                                        <span class="font-mono text-sm font-bold text-gray-900 bg-white px-3 py-1 rounded-lg border border-gray-200">#{{ $transaction->id }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    @php
                                        $statusConfig = [
                                            'unpaid' => [
                                                'bg' => 'bg-gradient-to-r from-yellow-100 to-yellow-200',
                                                'text' => 'text-yellow-800',
                                                'border' => 'border-yellow-300',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                            ],
                                            'paid' => [
                                                'bg' => 'bg-gradient-to-r from-green-100 to-green-200',
                                                'text' => 'text-green-800',
                                                'border' => 'border-green-300',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                            ],
                                            'cancelled' => [
                                                'bg' => 'bg-gradient-to-r from-red-100 to-red-200',
                                                'text' => 'text-red-800',
                                                'border' => 'border-red-300',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                            ],
                                        ];
                                        $config = $statusConfig[$transaction->payment_status] ?? [
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-800',
                                            'border' => 'border-gray-300',
                                            'icon' => ''
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold uppercase {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $config['icon'] !!}
                                        </svg>
                                        {{ $transaction->payment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Content -->
                        <div class="p-6">
                            <!-- Store Info -->
                            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-k-blue to-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                        {{ substr($transaction->store->name, 0, 1) }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Seller</p>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $transaction->store->name }}</h3>
                                </div>
                            </div>

                            <!-- Payment Summary -->
                            <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-5 border border-pink-100">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium mb-1">Total Payment</p>
                                        <p class="text-3xl font-bold bg-gradient-to-r from-k-pink to-purple-600 bg-clip-text text-transparent">
                                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                                        <svg class="w-8 h-8 text-k-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                                @if($transaction->payment_status == 'unpaid' && $transaction->payment_method == 'va')
                                    <a href="{{ route('payment.simulation') }}?transaction_id={{ $transaction->id }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-k-pink to-pink-500 text-white rounded-xl font-bold text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        Pay Now
                                    </a>
                                @endif
                                <a href="{{ route('history.show', $transaction->id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-gray-800 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
