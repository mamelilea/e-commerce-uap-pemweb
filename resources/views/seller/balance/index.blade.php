<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Saldo Toko') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Balance Card -->
                <div class="md:col-span-1 bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                    <div class="p-6 bg-[#161616] border-b border-white/10">
                        <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Total Saldo</h3>
                        <div class="text-3xl font-black text-indigo-400 mb-4">
                            Rp {{ number_format($balance->balance, 0, ',', '.') }}
                        </div>
                        <p class="text-sm text-gray-400 mb-6">
                            Saldo ini dapat ditarik ke rekening bank Anda.
                        </p>
                        <a href="{{ route('seller.balance.withdraw') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tarik Dana
                        </a>
                    </div>
                </div>

                <!-- Bank Settings -->
                <div class="md:col-span-2 bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                    <div class="p-6 bg-[#161616] border-b border-white/10">
                        <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Pengaturan Rekening Bank</h3>
                        <form action="{{ route('seller.balance.updateBank') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Bank</label>
                                    <input type="text" name="bank_name" value="{{ old('bank_name', $store->bank_name) }}" class="w-full rounded-md border-white/10 bg-[#0a0a0a] text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: BCA, Mandiri">
                                    @error('bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nomor Rekening</label>
                                    <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $store->bank_account_number) }}" class="w-full rounded-md border-white/10 bg-[#0a0a0a] text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nomor Rekening">
                                    @error('bank_account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Pemilik Rekening</label>
                                    <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $store->bank_account_name) }}" class="w-full rounded-md border-white/10 bg-[#0a0a0a] text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nama sesuai di buku tabungan">
                                    @error('bank_account_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Simpan Rekening
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="bg-[#161616] overflow-hidden shadow-sm sm:rounded-lg border border-white/10">
                <div class="p-6 bg-[#161616] border-b border-white/10">
                    <h3 class="text-lg font-bold text-[#EDEDEC] mb-4">Riwayat Perubahan Saldo</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="uppercase tracking-wider border-b-2 border-white/10 bg-[#0a0a0a]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-gray-400 font-bold">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-gray-400 font-bold">Tipe</th>
                                    <th scope="col" class="px-6 py-3 text-gray-400 font-bold">Nominal</th>
                                    <th scope="col" class="px-6 py-3 text-gray-400 font-bold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $item)
                                    <tr class="border-b border-white/5 hover:bg-white/5">
                                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->type == 'income')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Pemasukan</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">Penarikan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-bold {{ $item->type == 'income' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $item->type == 'income' ? '+' : '-' }} Rp {{ number_format($item->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-400">{{ $item->remarks }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada riwayat saldo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-seller-layout>
