@extends('layouts.frontend')

@section('title', 'Top Up Wallet')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <a href="{{ route('wallet.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Wallet
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Top Up Wallet</h1>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Current Balance -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
        <p class="text-sm text-gray-600 mb-2">Current Balance</p>
        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($userBalance->balance, 0, ',', '.') }}</p>
    </div>

    <!-- Top Up Form -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Select Amount</h2>

        <form action="{{ route('wallet.process') }}" method="POST" id="topupForm">
            @csrf

            <!-- Predefined Amounts -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <button type="button" onclick="selectAmount(50000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 50.000
                </button>
                <button type="button" onclick="selectAmount(100000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 100.000
                </button>
                <button type="button" onclick="selectAmount(200000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 200.000
                </button>
                <button type="button" onclick="selectAmount(500000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 500.000
                </button>
                <button type="button" onclick="selectAmount(1000000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 1.000.000
                </button>
                <button type="button" onclick="selectAmount(2000000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg hover:border-k-pink hover:bg-pink-50 transition-all text-center font-bold">
                    Rp 2.000.000
                </button>
            </div>

            <!-- Custom Amount -->
            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Or enter custom amount</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           min="10000" 
                           max="10000000"
                           step="1000"
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-k-pink focus:border-k-pink"
                           placeholder="Enter amount"
                           required>
                </div>
                @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">Minimum: Rp 10.000 | Maximum: Rp 10.000.000</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-400 transition-colors shadow-lg hover:shadow-xl">
                Top Up Now
            </button>
        </form>
    </div>
</div>

<script>
function selectAmount(amount) {
    document.getElementById('amount').value = amount;
    
    // Update button styles
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-k-pink', 'bg-pink-50');
        btn.classList.add('border-gray-200');
    });
    event.target.classList.remove('border-gray-200');
    event.target.classList.add('border-k-pink', 'bg-pink-50');
}
</script>
@endsection
