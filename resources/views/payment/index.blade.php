<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 border border-gray-100 shadow-sm">
                
                <h1 class="font-header text-3xl font-bold uppercase text-hubbub-black text-center mb-8 tracking-wide">
                    Payment Gateway
                </h1>

                @if(empty($details))
                    {{-- Step 1: Input VA --}}
                    <div>
                        <p class="font-sans text-gray-600 text-center mb-6">Enter your Virtual Account Number to proceed.</p>
                        
                        <form action="{{ route('payment.check') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block font-header font-bold uppercase text-xs mb-2 text-hubbub-black">Virtual Account Number</label>
                                <input type="text" name="va_number" value="{{ session('va_number') }}" class="w-full border-2 border-gray-200 p-4 font-sans focus:border-hubbub-black focus:ring-0 placeholder-gray-400" placeholder="e.g. TRX-12345678" required>
                            </div>
                            
                            <button type="submit" class="w-full bg-hubbub-black text-white font-header font-bold uppercase py-4 hover:bg-hubbub-pink transition-colors tracking-widest">
                                Check Payment
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Step 2: Confirm Payment --}}
                    <div>
                        <div class="text-center mb-8">
                            <p class="font-header text-lg uppercase text-gray-400 mb-1">Payment Confirmation</p>
                            <h2 class="font-header text-4xl font-bold text-hubbub-pink">
                                Rp {{ number_format($type == 'topup' ? $details->amount : $details->grand_total, 0, ',', '.') }}
                            </h2>
                        </div>
                        
                        <div class="bg-gray-50 p-6 border-l-4 border-hubbub-black mb-8 space-y-3">
                            <div class="flex justify-between">
                                <span class="font-header font-bold uppercase text-xs text-gray-500">Transaction Type</span>
                                <span class="font-header font-bold uppercase text-hubbub-black">{{ ucfirst($type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-header font-bold uppercase text-xs text-gray-500">VA Code</span>
                                <span class="font-sans font-bold text-hubbub-black">{{ $type == 'topup' ? $details->va_number : $details->code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-header font-bold uppercase text-xs text-gray-500">Status</span>
                                <span class="font-header font-bold uppercase {{ ($type == 'topup' ? $details->status : $details->payment_status) == 'paid' ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $type == 'topup' ? $details->status : $details->payment_status }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('payment.pay') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            <input type="hidden" name="va_number" value="{{ $type == 'topup' ? $details->va_number : $details->code }}">
                            
                            <div>
                                <label class="block font-header font-bold uppercase text-xs mb-2 text-hubbub-black">Simulate Payment Amount</label>
                                <input type="number" name="amount" class="w-full border-2 border-gray-200 p-4 font-sans bg-gray-50 text-gray-500 focus:outline-none cursor-not-allowed" value="{{ $type == 'topup' ? $details->amount : $details->grand_total }}" readonly>
                                <p class="text-xs text-gray-400 mt-2 font-sans italic">* Simulation Mode: Amount is auto-filled.</p>
                            </div>

                            <button type="submit" class="w-full bg-hubbub-pink text-white font-header font-bold uppercase py-4 hover:bg-hubbub-black transition-colors tracking-widest shadow-lg">
                                Confirm & Pay Now
                            </button>
                        </form>
                        
                        <div class="mt-6 text-center">
                            <a href="{{ route('payment.index') }}" class="font-header font-bold uppercase text-xs text-gray-400 hover:text-hubbub-black transition-colors border-b border-gray-300 hover:border-hubbub-black pb-1">Cancel / Check Another Code</a>
                        </div>
                    </div>
                @endif

            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-hubbub-black transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="block text-xs font-header font-bold uppercase mt-2">Back to Home</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
