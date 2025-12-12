<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-sm border border-gray-100 hover:shadow-[0px_10px_30px_rgba(234,92,136,0.1)] transition-all duration-300">
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="w-9 h-9 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h2 class="font-sans text-3xl font-bold uppercase text-hubbub-black tracking-tight mb-3">Top Up Wallet</h2>
                    <p class="text-gray-400 font-sans leading-relaxed text-sm px-6">Add funds to your secure wallet for seamless, instant checkout experiences.</p>
                </div>

                <form action="{{ route('wallet.topup.process') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label for="amount" class="block font-sans font-bold uppercase text-[10px] tracking-widest mb-3 text-gray-400 ml-1">Topup Amount (IDR)</label>
                        <div class="relative group">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-lg group-focus-within:text-hubbub-pink transition-colors z-10">Rp</span>
                            <input type="number" name="amount" id="amount" min="10000" step="1000" class="w-full pl-14 bg-gray-50 border border-gray-100 rounded-2xl py-5 pr-6 font-sans font-bold text-2xl text-hubbub-black placeholder-gray-300 focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all duration-300 shadow-inner" placeholder="0" required>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-3 font-sans text-right uppercase font-bold tracking-widest flex items-center justify-end gap-1">
                            <svg class="w-3 h-3 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Minimum top up amount is Rp 10.000
                        </p>
                    </div>
                    
                    <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold uppercase py-5 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-1 tracking-widest text-xs">
                        Generate Payment Code
                    </button>

                    <div class="text-center pt-2">
                        <a href="{{ route('history') }}" class="text-[10px] text-gray-400 hover:text-hubbub-pink font-bold uppercase tracking-widest transition-colors flex items-center justify-center gap-2 group">
                            View Transaction History
                            <svg class="w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
