<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans font-bold text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('Manage Withdrawals') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                
                @if($withdrawals->count() > 0)
                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Date</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Store</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Amount</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Bank Details</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="text-hubbub-black font-sans font-bold text-sm">{{ $withdrawal->created_at->format('d M Y') }}</p>
                                            <p class="text-gray-400 text-[10px] font-sans font-bold uppercase tracking-wider">{{ $withdrawal->created_at->format('H:i') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-hubbub-black font-sans">{{ $withdrawal->store->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-hubbub-pink font-sans">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-hubbub-black font-sans text-sm">{{ $withdrawal->bank_name }}</p>
                                            <p class="text-gray-400 font-sans text-[10px] uppercase tracking-wide">{{ $withdrawal->bank_account_number }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($withdrawal->status === 'approved')
                                                <span class="inline-flex px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                                    Paid
                                                </span>
                                            @elseif($withdrawal->status === 'rejected')
                                                <span class="inline-flex px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="inline-flex px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($withdrawal->status === 'pending')
                                                <div class="flex items-center gap-2">
                                                    <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="group inline-flex items-center px-3 py-1 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-green-200">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Reject and Refund?');">
                                                        @csrf
                                                        <button type="submit" class="group inline-flex items-center px-3 py-1 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-red-200">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-[10px] font-bold uppercase tracking-widest font-sans">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-5 py-5 border-t border-gray-100">
                            {{ $withdrawals->links() }}
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm3-6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <p class="font-sans text-xl font-bold uppercase text-gray-400 mb-2">No Withdrawal Requests</p>
                        <p class="text-gray-400 text-sm font-sans">Clean slate for now.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
