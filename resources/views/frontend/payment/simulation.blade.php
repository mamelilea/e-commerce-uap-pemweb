@extends('layouts.frontend')

@section('title', 'Payment')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
        <div class="w-16 h-16 bg-blue-100 text-k-blue rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Payment</h1>
        <p class="text-gray-500 mb-8">Enter Virtual Account Number to pay.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6 text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-xl mb-6 text-sm font-bold">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($transaction))
            <!-- Transaction Info -->
            <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-5 mb-6 border border-pink-100 text-left">
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-2">Transaction Details</p>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Order ID:</span>
                        <span class="text-sm font-bold text-gray-900">#{{ $transaction->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Amount:</span>
                        <span class="text-lg font-bold text-k-pink">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('payment.pay') }}" method="POST" class="text-left">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Virtual Account Number</label>
                <input type="text" name="va_number" value="{{ $transaction->va_number ?? '' }}" class="w-full rounded-xl border-gray-300 focus:ring-k-pink focus:border-k-pink py-3 px-4 font-mono text-lg placeholder-gray-300" placeholder="8888..." {{ isset($transaction) ? 'readonly' : '' }}>
                @if(isset($transaction))
                    <p class="text-xs text-gray-500 mt-2">VA Number has been auto-filled for your convenience</p>
                @endif
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-k-pink to-pink-500 text-white font-bold py-3 rounded-xl hover:from-pink-500 hover:to-pink-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200">
                Pay Now
            </button>
        </form>
        
        <div class="mt-8 pt-8 border-t border-gray-100">
            <a href="{{ route('history.index') }}" class="text-sm text-gray-500 hover:text-gray-900 font-medium">Back to My Orders</a>
        </div>
    </div>
</div>
@endsection
