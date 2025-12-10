@extends('layouts.seller')

@section('title', 'Balance')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold" style="color: #252B42;">Balance</h1>
        <p class="text-gray-600">Manage your earnings and transaction history</p>
    </div>

    {{-- Balance Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Available Balance --}}
        <div class="bg-gradient-to-br from-success-500 to-success-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-success-100 text-sm font-medium">Available Balance</span>
                <svg class="w-8 h-8 text-success-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold mb-1">Rp {{ number_format($storeBalance->balance ?? 0, 0, ',', '.') }}</p>
            <a href="{{ route('seller.withdrawals.index') }}" class="text-success-100 text-sm hover:text-white font-medium">
                Withdraw →
            </a>
        </div>

        {{-- Pending Balance --}}
        <div class="bg-gradient-to-br from-warning-500 to-warning-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-warning-100 text-sm font-medium">Pending Balance</span>
                <svg class="w-8 h-8 text-warning-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold mb-1">Rp {{ number_format($pendingBalance, 0, ',', '.') }}</p>
            <p class="text-warning-100 text-sm">From processing orders</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-primary-100 text-sm font-medium">Total Revenue</span>
                <svg class="w-8 h-8 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-primary-100 text-sm">All time earnings</p>
        </div>
    </div>

    {{-- Transaction History --}}
    @if($transactions->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold" style="color: #252B42;">Transaction History</h2>
            <p class="text-sm text-gray-500">Completed orders that have been added to your balance</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('seller.orders.show', $transaction->id) }}" class="text-primary-500 font-medium hover:underline">
                                #{{ $transaction->order_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $transaction->buyer->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $transaction->buyer->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $transaction->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $transaction->transactionDetails->count() }} items
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-bold text-success-600">+ Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-6 border-t border-gray-200">
            {{ $transactions->links() }}
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">No transactions yet</h3>
        <p class="text-gray-500">Complete orders will appear here</p>
    </div>
    @endif
</div>
@endsection
