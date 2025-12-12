<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Withdrawals') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Request Form --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black mb-6 tracking-tight">Request Withdrawal</h3>
                    <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="amount" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" min="10000" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="0">
                            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wide">Min. Rp 10.000</p>
                        </div>

                        <div class="mb-6">
                            <label for="bank_name" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="e.g. BCA">
                        </div>

                        <div class="mb-8">
                            <label for="account_number" class="block text-gray-700 text-xs font-sans font-bold uppercase mb-2">Account Number</label>
                            <input type="text" name="account_number" id="account_number" class="w-full bg-gray-50 border border-gray-200 p-4 rounded-xl focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white transition-all font-sans font-bold text-gray-800 placeholder-gray-400" required placeholder="e.g. 1234567890">
                        </div>

                        <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold uppercase py-4 rounded-full border border-transparent hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-0.5 tracking-wider text-xs">
                            Submit Request
                        </button>
                    </form>
                </div>

                {{-- History --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="border-b border-gray-100 pb-6 mb-6">
                         <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black tracking-tight">Withdrawal History</h3>
                    </div>
                   
                    @if($withdrawals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Date</th>
                                        <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Amount</th>
                                        <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($withdrawals as $w)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-5 py-5 text-sm italic text-gray-500 font-sans">
                                                {{ $w->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-5 py-5 text-sm">
                                                <div class="font-bold text-hubbub-black font-sans">Rp {{ number_format($w->amount, 0, ',', '.') }}</div>
                                                <span class="text-[10px] text-gray-400 font-sans font-bold uppercase tracking-wide">{{ $w->bank_name }}</span>
                                            </td>
                                            <td class="px-5 py-5 text-sm">
                                                <span class="inline-block px-3 py-1 text-[10px] font-sans font-bold uppercase leading-tight {{ $w->status == 'approved' ? 'text-green-600 bg-green-50' : ($w->status == 'rejected' ? 'text-red-600 bg-red-50' : 'text-yellow-600 bg-yellow-50') }} rounded-full">
                                                    {{ ucfirst($w->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center text-gray-400 font-sans font-bold uppercase text-xs">No withdrawal requests found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
