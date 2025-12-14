@extends('layouts.frontend')

@section('title', 'Financials')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <a href="{{ route('store.index') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Financials & Withdrawals</h1>
        <p class="text-gray-500 mt-1">Manage your earnings, withdrawals, and bank account.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Balance & Withdrawal Card -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Balance -->
            <div class="bg-gradient-to-br from-k-pink to-pink-500 rounded-2xl p-8 text-white shadow-lg">
                <p class="text-pink-100 font-medium mb-2">Available Balance</p>
                <h2 class="text-4xl font-bold mb-4">Rp {{ number_format($store->storeBalance->balance ?? 0, 0, ',', '.') }}</h2>
                <a href="{{ route('seller.financials.balance') }}" class="inline-flex items-center text-sm text-white hover:text-pink-100">
                    View Balance History
                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <!-- Bank Account Management -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Bank Account</h3>
                <form action="{{ route('seller.financials.bank') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Bank Name</label>
                        <select name="bank_name" class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink text-sm" required>
                            <option value="">Select Bank</option>
                            <option value="BCA" {{ $store->bank_name == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="Mandiri" {{ $store->bank_name == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="BNI" {{ $store->bank_name == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="BRI" {{ $store->bank_name == 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="CIMB Niaga" {{ $store->bank_name == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $store->bank_account_number) }}" class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink text-sm" placeholder="1234567890" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Account Holder</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $store->bank_account_name) }}" class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink text-sm" placeholder="Account Holder Name" required>
                    </div>
                    <button type="submit" class="w-full py-2 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition-colors text-sm">
                        {{ $store->bank_account_number ? 'Update' : 'Save' }} Bank Account
                    </button>
                </form>
            </div>

            <!-- Withdrawal Form -->
            @if($store->bank_account_number)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Request Withdrawal</h3>
                <form action="{{ route('seller.financials.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Amount</label>
                        <input type="number" name="amount" max="{{ $store->storeBalance->balance ?? 0 }}" min="10000" class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" placeholder="Min 10,000" required>
                        <p class="text-xs text-gray-500 mt-1">Minimum withdrawal: Rp 10,000</p>
                    </div>
                    <input type="hidden" name="bank_name" value="{{ $store->bank_name }}">
                    <input type="hidden" name="bank_account_number" value="{{ $store->bank_account_number }}">
                    <input type="hidden" name="bank_account_name" value="{{ $store->bank_account_name }}">
                    
                    <div class="bg-gray-50 p-3 rounded-lg text-xs">
                        <p class="text-gray-600">Withdraw to:</p>
                        <p class="font-bold text-gray-900">{{ $store->bank_name }} - {{ $store->bank_account_number }}</p>
                        <p class="text-gray-600">{{ $store->bank_account_name }}</p>
                    </div>

                    <button type="submit" class="w-full py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 shadow-md transition-all">
                        Request Withdrawal
                    </button>
                </form>
            </div>
            @else
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">Please save your bank account information first before requesting a withdrawal.</p>
            </div>
            @endif
        </div>

        <!-- Withdrawal History -->
        <div class="lg:col-span-2">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Withdrawal History</h3>
             <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if($withdrawals->isEmpty())
                     <div class="p-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="font-semibold text-gray-900 mb-1">No Withdrawal History</p>
                        <p class="text-sm">Your withdrawal requests will appear here.</p>
                    </div>
                @else
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Bank Account</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($withdrawals as $withdrawal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $withdrawal->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div>{{ $withdrawal->bank_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $withdrawal->bank_account_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $withdrawal->bank_account_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                        ];
                                        $color = $statusColors[$withdrawal->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border-2 {{ $color }}">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif
@endsection
