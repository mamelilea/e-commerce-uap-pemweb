<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            {{ __('Verifikasi Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10 relative overflow-hidden group hover:shadow-[0_0_40px_rgba(34,197,94,0.1)] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#EDEDEC]">Daftar Penarikan Menunggu Persetujuan</h3>
                    @if($withdrawals->count() > 0)
                        <span class="px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-full border border-yellow-500/20 text-xs font-bold">{{ $withdrawals->count() }} Pending</span>
                    @endif
                </div>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if($withdrawals->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>Tidak ada permintaan penarikan yang perlu diproses.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-white/5">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-200 uppercase bg-[#0f0f0f]">
                                <tr>
                                    <th class="px-6 py-4 font-bold tracking-wider">Waktu Request</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Toko</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Info Rekening</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-right">Jumlah (IDR)</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 bg-[#161616]">
                                @foreach($withdrawals as $withdrawal)
                                <tr class="hover:bg-white/5 transition-all duration-300 group/row relative">
                                    <td class="absolute inset-y-0 left-0 w-1 bg-green-500 scale-y-0 group-hover/row:scale-y-100 transition-transform origin-bottom duration-300"></td>
                                    <td class="px-6 py-4 font-medium text-white">
                                        {{ $withdrawal->created_at->format('d M Y H:i') }}
                                        <div class="text-xs text-gray-600">{{ $withdrawal->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $withdrawal->storeBalance->store->name ?? 'Unknown Store' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-300">{{ $withdrawal->bank_name }}</div>
                                        <div class="text-xs">{{ $withdrawal->bank_account_number }}</div>
                                        <div class="text-xs italic">{{ $withdrawal->bank_account_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-xl font-bold text-white tracking-tight">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 flex justify-end gap-3">
                                        <form action="{{ route('admin.withdrawal.verify', $withdrawal->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui penarikan ini? Pastikan Anda SUDAH mentransfer dananya.');">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="group/btn relative overflow-hidden flex items-center gap-1 px-4 py-1.5 bg-green-500/10 text-green-500 border border-green-500/50 text-xs font-bold rounded-lg hover:bg-green-500 hover:text-white transition-all hover:scale-105 shadow-sm hover:shadow-green-500/30">
                                                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-400/20 to-green-500/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                                                <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="relative z-10">Telah Ditransfer</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.withdrawal.verify', $withdrawal->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak penarikan ini? Saldo akan dikembalikan ke toko.');">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="group/btn relative overflow-hidden flex items-center gap-1 px-4 py-1.5 bg-red-500/10 text-red-500 border border-red-500/50 text-xs font-bold rounded-lg hover:bg-red-500 hover:text-white transition-all hover:scale-105 shadow-sm hover:shadow-red-500/30">
                                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-400/20 to-red-500/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                                                <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span class="relative z-10">Tolak</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
