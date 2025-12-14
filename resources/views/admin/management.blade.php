<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Manajemen Sistem') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Information Card -->
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white/5 rounded-xl text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#EDEDEC]">Informasi Sistem</h3>
                        <p class="text-gray-500 text-sm mt-1">Halaman ini menampilkan seluruh data pengguna dan toko yang terdaftar di sistem. Hubungi developer jika terdapat anomali data.</p>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10">
                <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Daftar Pengguna</h3>
                <div class="overflow-x-auto rounded-lg border border-white/5">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-gray-200 uppercase bg-[#0f0f0f]">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-wider">Nama</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Email</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Role</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 bg-[#161616]">
                            @foreach($users as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-medium text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 bg-purple-500/10 text-purple-400 rounded text-xs font-bold uppercase border border-purple-500/20">Admin</span>
                                    @elseif($user->role === 'seller')
                                        <span class="px-2 py-1 bg-white/10 text-white rounded text-xs font-bold uppercase border border-white/20">Seller</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-500/10 text-gray-400 rounded text-xs font-bold uppercase border border-gray-500/20">Buyer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Stores List -->
            <div class="bg-[#161616] rounded-2xl p-6 shadow-sm border border-white/10">
                <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Daftar Toko</h3>
                <div class="overflow-x-auto rounded-lg border border-white/5">
                     <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-gray-200 uppercase bg-[#0f0f0f]">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-wider">Nama Toko</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Pemilik</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Domain</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                                <th class="px-6 py-4 font-bold tracking-wider text-center">Produk</th>
                            </tr>
                        </thead>
                         <tbody class="divide-y divide-white/5 bg-[#161616]">
                            @foreach($stores as $store)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-medium text-white">{{ $store->name }}</td>
                                <td class="px-6 py-4">{{ $store->user->name }}</td>
                                <td class="px-6 py-4 font-mono text-xs">{{ $store->domain }}</td>
                                <td class="px-6 py-4">
                                     @if($store->is_verified)
                                        <span class="inline-flex items-center gap-1 text-green-400 text-xs font-bold px-2 py-1 bg-green-500/10 rounded border border-green-500/20">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-yellow-400 text-xs font-bold px-2 py-1 bg-yellow-500/10 rounded border border-yellow-500/20">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">{{ $store->products ? $store->products->count() : 0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
