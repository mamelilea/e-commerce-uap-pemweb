<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                
                <div class="border-b border-gray-100 pb-6 mb-6">
                    <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black tracking-tight">Order History</h3>
                </div>

                @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Date</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Transaction Code</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Buyer</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Total</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Status</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Tracking Number</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($transactions as $trx)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-5 text-sm italic text-gray-500 font-sans">
                                            {{ $trx->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-5 text-sm font-sans font-bold text-hubbub-black uppercase tracking-wide">
                                            {{ $trx->code }}
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <div class="font-bold text-gray-900 font-sans">{{ $trx->buyer->name }}</div>
                                            <span class="text-[10px] text-gray-500 font-sans uppercase font-bold tracking-wide">{{ $trx->city }}</span>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <span class="text-hubbub-pink font-sans font-bold">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <span class="inline-block px-3 py-1 text-[10px] font-sans font-bold uppercase leading-tight {{ $trx->payment_status == 'paid' ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} rounded-full">
                                                {{ ucfirst($trx->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            @if($trx->payment_status == 'paid')
                                                <form action="{{ route('seller.orders.update', $trx->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="tracking_number" value="{{ $trx->tracking_number }}" class="text-xs bg-gray-50 border border-gray-200 text-gray-800 rounded-lg p-2 w-32 focus:border-hubbub-pink focus:ring-hubbub-pink transition-colors font-sans" placeholder="INPUT RESI...">
                                            @else
                                                <span class="text-gray-400 font-sans font-bold uppercase text-[10px] tracking-wide">Waiting Payment</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            @if($trx->payment_status == 'paid')
                                                    <button type="submit" class="text-gray-500 hover:text-hubbub-pink font-sans font-bold uppercase text-[10px] transition-colors tracking-wider">Update</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <p class="font-sans text-xl font-bold uppercase text-gray-400 mb-2">No orders received yet.</p>
                        <p class="text-gray-400 text-sm font-sans">Promote your store to get more sales!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
