@extends('layouts.seller')

@section('title', 'Withdrawals')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold" style="color: #252B42;">Withdrawals</h1>
        <p class="text-gray-600">Request withdrawal and manage bank account</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Withdrawal History --}}
            @if($withdrawals->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold" style="color: #252B42;">Withdrawal History</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($withdrawals as $withdrawal)
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-bold text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full
                                        {{ $withdrawal->status === 'approved' ? 'bg-success-100 text-success-700' : '' }}
                                        {{ $withdrawal->status === 'pending' ? 'bg-warning-100 text-warning-700' : '' }}
                                        {{ $withdrawal->status === 'rejected' ? 'bg-danger-100 text-danger-700' : '' }}">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><span class="font-medium">Bank:</span> {{ $withdrawal->bank_name }}</p>
                                    <p><span class="font-medium">Account:</span> {{ $withdrawal->bank_account_number }} - {{ $withdrawal->bank_account_name }}</p>
                                    <p><span class="font-medium">Requested:</span> {{ $withdrawal->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-6 border-t border-gray-200">
                    {{ $withdrawals->links() }}
                </div>
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-700 mb-2">No withdrawal requests yet</h3>
                <p class="text-gray-500">Request your first withdrawal using the form</p>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Available Balance --}}
            <div class="bg-gradient-to-br from-success-500 to-success-600 text-white rounded-lg shadow-lg p-6">
                <p class="text-success-100 text-sm font-medium mb-2">Available for Withdrawal</p>
                <p class="text-3xl font-extrabold">Rp {{ number_format($storeBalance->balance ?? 0, 0, ',', '.') }}</p>
            </div>

            {{-- Request Withdrawal --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Request Withdrawal</h2>
                
                <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-bold text-gray-700 mb-2">
                            Amount <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="amount" 
                            name="amount" 
                            value="{{ old('amount') }}"
                            class="input-field @error('amount') border-danger-500 @enderror"
                            placeholder="Minimum Rp 50,000"
                            min="50000"
                            max="{{ $storeBalance->balance ?? 0 }}"
                            required>
                        @error('amount')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Min: Rp 50,000 | Max: Rp {{ number_format($storeBalance->balance ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="bank_name" class="block text-sm font-bold text-gray-700 mb-2">
                            Bank Name <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="bank_name" 
                            name="bank_name" 
                            value="{{ old('bank_name', $storeBalance->bank_name ?? '') }}"
                            class="input-field @error('bank_name') border-danger-500 @enderror"
                            placeholder="e.g., BCA, Mandiri, BNI"
                            required>
                        @error('bank_name')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bank_account_name" class="block text-sm font-bold text-gray-700 mb-2">
                            Account Name <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="bank_account_name" 
                            name="bank_account_name" 
                            value="{{ old('bank_account_name', $storeBalance->bank_account_name ?? '') }}"
                            class="input-field @error('bank_account_name') border-danger-500 @enderror"
                            placeholder="Your account name"
                            required>
                        @error('bank_account_name')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="bank_account_number" class="block text-sm font-bold text-gray-700 mb-2">
                            Account Number <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="bank_account_number" 
                            name="bank_account_number" 
                            value="{{ old('bank_account_number', $storeBalance->bank_account_number ?? '') }}"
                            class="input-field @error('bank_account_number') border-danger-500 @enderror"
                            placeholder="Account number"
                            required>
                        @error('bank_account_number')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full" {{ ($storeBalance->balance ?? 0) < 50000 ? 'disabled' : '' }}>
                        Request Withdrawal
                    </button>

                    @if(($storeBalance->balance ?? 0) < 50000)
                        <p class="text-xs text-danger-500 mt-2 text-center">Minimum balance not reached</p>
                    @endif
                </form>
            </div>

            {{-- Info Box --}}
            <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                <h3 class="font-bold text-primary-800 mb-2 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Withdrawal Info
                </h3>
                <ul class="text-xs text-primary-700 space-y-1">
                    <li>• Minimum withdrawal: Rp 50,000</li>
                    <li>• Processing time: 1-3 business days</li>
                    <li>• Balance deducted immediately</li>
                    <li>• Admin approval required</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
