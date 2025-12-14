<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                <div class="p-6 bg-[#161616] border-b border-white/10">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead class="bg-[#0a0a0a]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Resi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#161616] divide-y divide-white/5">
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#EDEDEC]">
                                            #{{ $transaction->code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#EDEDEC]">
                                            {{ optional($transaction->buyer->user)->name ?? 'Guest' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#EDEDEC]">
                                            Item: {{ $transaction->transactionDetails->count() }}<br>
                                            <span class="font-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full w-max {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($transaction->payment_status) }}
                                                </span>
                                                @if($transaction->delivery_status !== 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full w-max {{ $transaction->delivery_status === 'shipped' ? 'bg-blue-100 text-blue-800' : ($transaction->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($transaction->delivery_status) }}
                                                    </span>
                                                @else
                                                     <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full w-max bg-yellow-100 text-yellow-800">
                                                        Menunggu Konfirmasi
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($transaction->tracking_number)
                                                <span class="text-green-600 font-bold">{{ $transaction->tracking_number }}</span>
                                            @else
                                                <span class="text-gray-400 italic">Belum ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('seller.orders.show', $transaction->id) }}" class="text-indigo-400 hover:text-indigo-300">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada pesanan masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
