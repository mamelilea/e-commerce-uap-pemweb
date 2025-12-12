<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-sans text-4xl font-bold uppercase text-hubbub-black tracking-tight mb-8">Purchase History</h1>

            @if(session('success'))
                <div class="mb-8 p-4 bg-white text-hubbub-pink font-sans font-bold uppercase text-sm rounded-xl border border-pink-100 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($transactions->count() > 0)
                <div class="space-y-8">
                    @foreach($transactions as $trx)
                        <div class="bg-white p-0 rounded-3xl shadow-sm border border-gray-100 hover:shadow-[0px_10px_30px_rgba(234,92,136,0.1)] transition-all duration-300 overflow-hidden group">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-8 bg-pink-50/30 border-b border-gray-100 gap-6">
                                <div>
                                    <div class="flex items-center gap-4 mb-2">
                                        <span class="font-sans text-lg font-bold text-hubbub-black uppercase tracking-wide">#{{ $trx->code }}</span>
                                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full border {{ $trx->payment_status == 'paid' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-pink-50 text-hubbub-pink border-pink-100' }}">
                                            {{ $trx->payment_status }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 font-sans uppercase tracking-wider flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $trx->created_at->format('d M Y • H:i') }}
                                    </p>
                                </div>
                                <div class="text-left md:text-right">
                                    <p class="text-[10px] text-gray-400 uppercase font-sans font-bold tracking-widest mb-1">Total Amount</p>
                                    <p class="font-sans text-3xl font-bold text-hubbub-pink">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="p-8 space-y-6">
                                @foreach($trx->details as $detail)
                                    <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center group/item hover:bg-gray-50/50 p-2 rounded-2xl transition-colors">
                                        <div class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                                            @if($detail->product->productImages->first())
                                                <img class="w-full h-full object-cover transform group-hover/item:scale-110 transition-transform duration-500" src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" alt="">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-300 font-sans uppercase font-bold tracking-widest">No IMG</div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-sans text-base font-bold text-hubbub-black leading-tight mb-2 group-hover/item:text-hubbub-pink transition-colors">
                                                <a href="{{ route('product.details', $detail->product->slug) }}">{{ $detail->product->name }}</a>
                                            </h4>
                                            <p class="text-xs text-gray-400 font-sans font-bold uppercase tracking-wider">{{ $detail->qty }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="font-bold font-sans text-hubbub-black text-lg">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-gray-50 p-6 flex flex-col sm:flex-row justify-between items-center gap-6 border-t border-gray-100">
                                <div class="text-sm font-sans w-full sm:w-auto">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="p-2 bg-white rounded-full shadow-sm text-hubbub-pink">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                        </div>
                                        <div>
                                            <span class="block uppercase text-[10px] font-bold text-gray-400 tracking-widest">Shipping</span>
                                            <p class="font-bold text-hubbub-black text-xs">{{ $trx->shipping_type }} <span class="text-gray-400 font-normal">(Rp {{ number_format($trx->shipping_cost, 0, ',', '.') }})</span></p>
                                        </div>
                                    </div>
                                    @if($trx->tracking_number)
                                        <div class="flex items-center gap-3 mt-3 pl-1">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Tracking ID: <span class="font-mono text-hubbub-black bg-white px-2 py-1 rounded border border-gray-200 ml-1">{{ $trx->tracking_number }}</span></p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <a href="#" class="flex-1 sm:flex-none text-center px-6 py-3 rounded-full border border-gray-200 text-gray-500 font-sans font-bold uppercase text-[10px] tracking-widest hover:border-hubbub-pink hover:text-hubbub-pink transition-all">
                                        Invoice
                                    </a>
                                    @if($trx->payment_status == 'unpaid')
                                         <a href="{{ route('payment.index') }}" class="flex-1 sm:flex-none text-center bg-hubbub-black text-white font-sans font-bold uppercase text-[10px] px-8 py-3 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 tracking-widest transform hover:-translate-y-1">
                                            Pay Now
                                         </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-20 text-center border border-gray-100 shadow-sm rounded-[40px] max-w-2xl mx-auto">
                    <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-hubbub-pink opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h2 class="font-sans text-3xl font-bold uppercase text-hubbub-black mb-3 tracking-tight">No History Yet</h2>
                    <p class="text-gray-400 mb-10 font-sans text-sm">Start your collection today and track your orders here.</p>
                    <a href="{{ route('home') }}" class="inline-block bg-hubbub-black text-white font-sans font-bold uppercase text-xs px-10 py-4 rounded-full hover:bg-hubbub-pink hover:shadow-lg hover:shadow-pink-200 transition-all tracking-widest transform hover:-translate-y-1">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
