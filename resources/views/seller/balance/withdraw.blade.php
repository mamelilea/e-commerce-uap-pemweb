<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <a href="{{ route('seller.balance.index') }}" class="text-gray-400 hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <span class="text-[#EDEDEC]">{{ __('Penarikan Dana') }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
             @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Withdrawal Form -->
                <div class="md:col-span-1 bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                    <div class="p-6 bg-[#161616] border-b border-white/10">
                        <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Ajukan Penarikan</h3>
                        
                        <div class="mb-6 p-4 bg-indigo-500/10 border border-indigo-500/20 rounded-md">
                            <p class="text-sm text-indigo-300">Saldo Tersedia</p>
                            <p class="text-2xl font-black text-indigo-400">Rp {{ number_format($balance->balance, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('seller.balance.processWithdraw') }}" method="POST">
                            @csrf
                            
                            <!-- Hidden Bank Details (To ensure consistency with what is shown) -->
                            <input type="hidden" name="bank_name" value="{{ $store->bank_name }}">
                            <input type="hidden" name="bank_account_number" value="{{ $store->bank_account_number }}">
                            <input type="hidden" name="bank_account_name" value="{{ $store->bank_account_name }}">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nominal Penarikan</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                          <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="amount" min="10000" max="{{ $balance->balance }}" class="focus:ring-indigo-500 focus:border-indigo-500 bg-[#0a0a0a] text-white block w-full pl-10 sm:text-sm border-white/10 rounded-md" placeholder="0">
                                    </div>
                                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-400 mt-1">Minimal Rp 10.000</p>
                                </div>

                                <div class="border-t border-white/10 pt-4">
                                    <h4 class="text-sm font-bold text-[#EDEDEC] mb-2">Tujuan Transfer</h4>
                                    @if($store->bank_name && $store->bank_account_number)
                                        <div class="text-sm text-gray-400">
                                            <p class="font-semibold text-white">{{ $store->bank_name }}</p>
                                            <p>{{ $store->bank_account_number }}</p>
                                            <p class="uppercase">{{ $store->bank_account_name }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Ubah rekening di halaman <a href="{{ route('seller.balance.index') }}" class="text-indigo-400 hover:underline">Saldo Toko</a>.</p>
                                    @else
                                        <div class="text-sm text-red-400">
                                            Anda belum mengatur rekening bank.
                                        </div>
                                        <a href="{{ route('seller.balance.index') }}" class="block mt-2 text-center text-sm text-indigo-400 border border-indigo-400 rounded px-2 py-1 hover:bg-white/5">Atur Rekening Sekarang</a>
                                    @endif
                                </div>

                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50" {{ (!$store->bank_name || $balance->balance < 10000) ? 'disabled' : '' }}>
                                    Ajukan Penarikan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Withdrawal History -->
                <div class="md:col-span-2 bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                    <div class="p-6 bg-[#161616]">
                        <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Riwayat Penarikan</h3>
                         <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm whitespace-nowrap">
                                <thead class="uppercase tracking-wider border-b-2 border-white/10 bg-[#0a0a0a]">
                                    <tr>
                                        <th class="px-6 py-3 font-bold text-gray-400">Tanggal</th>
                                        <th class="px-6 py-3 font-bold text-gray-400">Nominal</th>
                                        <th class="px-6 py-3 font-bold text-gray-400">Bank Tujuan</th>
                                        <th class="px-6 py-3 font-bold text-gray-400">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($withdrawals as $withdrawal)
                                        <tr class="border-b border-white/5 hover:bg-white/5 text-[#EDEDEC]">
                                            <td class="px-6 py-4">{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                                            <td class="px-6 py-4 font-bold">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                {{ $withdrawal->bank_name }} - {{ $withdrawal->bank_account_number }}<br>
                                                <span class="text-xs text-gray-500 uppercase">{{ $withdrawal->bank_account_name }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                 @if($withdrawal->status == 'pending')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Menunggu</span>
                                                @elseif($withdrawal->status == 'approved')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Disetujui</span>
                                                @elseif($withdrawal->status == 'rejected')
                                                     <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">Ditolak</span>
                                                @else
                                                     <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold">{{ ucfirst($withdrawal->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada riwayat penarikan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $withdrawals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
