@extends('layouts.frontend')

@section('title', 'Balance History')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('seller.financials.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Financials
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Balance History</h1>
        <p class="text-gray-500 mt-1">Track all changes to your store balance</p>
    </div>

    <!-- Current Balance Card -->
    <div class="bg-gradient-to-br from-k-pink to-pink-500 rounded-2xl p-8 text-white shadow-lg mb-8">
        <p class="text-pink-100 font-medium mb-2">Current Balance</p>
        <h2 class="text-5xl font-bold">Rp {{ number_format($store->storeBalance->balance ?? 0, 0, ',', '.') }}</h2>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($histories->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Balance History</h3>
                <p class="text-sm">Your balance transactions will appear here</p>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date & Time</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Reference</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($histories as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($history->type == 'credit')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border-2 border-green-200">
                                    + Credit
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full border-2 border-red-200">
                                    - Debit
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="font-medium">{{ ucfirst($history->reference_type) }}</div>
                            @if($history->reference_id)
                                <div class="text-xs text-gray-500">#{{ $history->reference_id }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold {{ $history->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $history->type == 'credit' ? '+' : '-' }} Rp {{ number_format($history->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $history->remarks ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
