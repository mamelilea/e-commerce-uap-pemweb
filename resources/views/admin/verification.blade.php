<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Verifikasi Toko') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#EDEDEC]">Daftar Toko Menunggu Verifikasi</h3>
                    @if($pendingStoresList->count() > 0)
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full border border-red-500/20 text-xs font-bold">{{ $pendingStoresList->count() }} Pending</span>
                    @endif
                </div>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($pendingStoresList->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>Tidak ada toko yang perlu diverifikasi.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-white/5">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-200 uppercase bg-[#0f0f0f]">
                                <tr>
                                    <th class="px-6 py-4 font-bold tracking-wider">Nama Toko</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Pemilik</th>
                                    <th class="px-6 py-4 font-bold tracking-wider">Domain</th>
                                    <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 bg-[#161616]">
                                @foreach($pendingStoresList as $store)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-4 font-medium text-white">{{ $store->name }}</td>
                                    <td class="px-6 py-4">{{ $store->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $store->domain }}</td>
                                    <td class="px-6 py-4 flex justify-end gap-3">
                                        <form action="{{ route('admin.store.verify', $store->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-white text-black text-xs font-bold rounded-lg hover:bg-gray-200 transition-all hover:scale-105 shadow-sm shadow-white/10">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.store.verify', $store->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-red-500/10 text-red-500 border border-red-500/50 text-xs font-bold rounded-lg hover:bg-red-500/20 transition-all hover:scale-105">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak
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
