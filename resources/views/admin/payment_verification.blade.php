<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Verifikasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10 relative overflow-hidden group hover:shadow-[0_0_40px_rgba(99,102,241,0.1)] transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#EDEDEC]">Daftar Pembayaran Menunggu Verifikasi</h3>
                    @if($transactions->count() > 0)
                        <span class="px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-full border border-yellow-500/20 text-xs font-bold">{{ $transactions->count() }} Pending</span>
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

                @if($transactions->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p>Tidak ada pembayaran yang perlu diverifikasi.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-white/5">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-200 uppercase bg-[#0f0f0f]">
                                <tr>
                                    <th class="px-6 py-4 font-bold tracking-wider">No. Pesanan</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Pembeli</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Toko</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-right">Total</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-center">Bukti</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 bg-[#161616]">
                                @foreach($transactions as $transaction)
                                <tr class="hover:bg-white/5 transition-all duration-300 group/row relative">
                                    <td class="absolute inset-y-0 left-0 w-1 bg-indigo-500 scale-y-0 group-hover/row:scale-y-100 transition-transform origin-bottom duration-300"></td>
                                    <td class="px-6 py-4 font-medium text-white">{{ $transaction->code }}</td>
                                    <td class="px-6 py-4">
                                        {{ $transaction->buyer->user->name ?? 'Guest' }}
                                        <div class="text-xs text-gray-600">{{ $transaction->created_at->format('d M H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $transaction->store->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right font-mono text-white">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($transaction->proof_of_payment)
                                            <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/10 text-blue-400 rounded-lg border border-blue-500/20 text-xs hover:bg-blue-500 hover:text-white transition-all duration-300 hover:scale-105 shadow-sm hover:shadow-blue-500/30">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex justify-end gap-3">
                                        <form action="{{ route('admin.payment.verify', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi pembayaran ini? Dana akan diteruskan ke penjual.');">
                                            @csrf
                                            <input type="hidden" name="action" value="valid">
                                            <button type="submit" class="group/btn relative overflow-hidden flex items-center gap-1 px-4 py-1.5 bg-white text-black text-xs font-bold rounded-lg hover:bg-gray-100 transition-all hover:scale-105 shadow-[0_0_10px_rgba(255,255,255,0.1)] hover:shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-gray-200 to-transparent translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                                                <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="relative z-10">Valid</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.payment.verify', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pembayaran ini? Pembeli harus upload ulang.');">
                                            @csrf
                                            <input type="hidden" name="action" value="invalid">
                                            <button type="submit" class="group/btn relative overflow-hidden flex items-center gap-1 px-4 py-1.5 bg-red-500/10 text-red-500 border border-red-500/50 text-xs font-bold rounded-lg hover:bg-red-500 hover:text-white transition-all hover:scale-105 shadow-sm hover:shadow-red-500/30">
                                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-400/20 to-red-500/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                                                <svg class="w-3.5 h-3.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span class="relative z-10">Invalid</span>
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
