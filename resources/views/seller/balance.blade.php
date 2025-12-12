<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Store Balance') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Balance Card --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit text-center">
                    <h3 class="text-gray-400 font-sans font-bold uppercase text-[10px] mb-4 tracking-widest">Current Balance</h3>
                    <div class="text-4xl font-sans font-bold text-hubbub-black mb-8 tracking-tight">
                        Rp {{ number_format($balance->balance, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('seller.withdrawals') }}" class="block w-full bg-hubbub-pink text-white font-sans font-bold uppercase py-4 rounded-full hover:bg-pink-600 transition-all shadow-lg shadow-pink-200 transform hover:-translate-y-0.5 text-xs tracking-wider">
                        Request Withdrawal
                    </a>
                </div>

                {{-- History --}}
                <div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="border-b border-gray-100 pb-6 mb-2">
                        <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black tracking-tight">Balance History</h3>
                    </div>
                    
                    @if($history->count() > 0)
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-50">
                                @foreach($history as $record)
                                    <li class="py-5 hover:bg-gray-50 transition-colors rounded-xl px-4 -mx-4 group">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $record->type == 'credit' ? 'bg-green-50 text-green-500' : 'bg-pink-50 text-hubbub-pink' }}">
                                                    @if($record->type == 'credit')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold font-sans uppercase text-xs text-gray-800 truncate group-hover:text-hubbub-pink transition-colors">
                                                    {{ $record->description }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 font-sans mt-0.5">
                                                    {{ $record->created_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center font-sans font-bold text-sm {{ $record->type == 'credit' ? 'text-green-500' : 'text-hubbub-pink' }}">
                                                {{ $record->type == 'credit' ? '+' : '-' }} Rp {{ number_format($record->amount, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="p-16 text-center">
                            <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="font-sans text-xl font-bold uppercase text-gray-400 mb-2">No balance history yet.</p>
                            <p class="text-gray-400 text-sm font-sans">Money flow will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
