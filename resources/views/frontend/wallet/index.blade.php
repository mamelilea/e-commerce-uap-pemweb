@extends('layouts.frontend')

@section('title', 'My Wallet')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Wallet</h1>
        <a href="{{ route('wallet.topup') }}" class="px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-400 transition-colors">
            Top Up Wallet
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Balance Card -->
    <div class="bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl p-8 text-white mb-8 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm font-medium mb-2">Available Balance</p>
                <h2 class="text-4xl font-bold">Rp {{ number_format($userBalance->balance, 0, ',', '.') }}</h2>
            </div>
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Transaction History</h3>

        @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $transaction->type == 'topup' ? 'bg-green-100' : 'bg-red-100' }}">
                                @if($transaction->type == 'topup')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $transaction->description }}</p>
                                <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold {{ $transaction->type == 'topup' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type == 'topup' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500">Balance: Rp {{ number_format($transaction->balance_after, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No transactions yet</h3>
                <p class="text-gray-500 mb-4">Start by topping up your wallet!</p>
                <a href="{{ route('wallet.topup') }}" class="inline-block px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-400 transition-colors">
                    Top Up Now
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
