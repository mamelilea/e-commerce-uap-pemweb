<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-500">
            Penarikan Saldo Toko
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-lg">

            {{-- Saldo Toko --}}
            <p class="text-lg font-semibold mb-2">Total Saldo Saat Ini:</p>

            <div class="bg-pink-100 p-6 rounded-xl mb-10">
                <p class="text-3xl font-bold text-pink-700">
                    Rp {{ number_format($balance->balance, 0, ',', '.') }}
                </p>
            </div>

            {{-- Form Penarikan --}}
            <h3 class="text-xl font-bold text-pink-600 mb-4">Ajukan Penarikan Saldo</h3>

            <form action="{{ route('toko.withdraw.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="font-semibold">Jumlah Penarikan</label>
                    <input type="number" name="amount" min="10000" class="w-full p-3 border rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="font-semibold">Nama Pemilik Rekening</label>
                    <input type="text" name="bank_account_name" class="w-full p-3 border rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="font-semibold">Nomor Rekening</label>
                    <input type="text" name="bank_account_number" class="w-full p-3 border rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="font-semibold">Nama Bank</label>
                    <input type="text" name="bank_name" class="w-full p-3 border rounded-lg mt-1" required>
                </div>

                <button class="px-6 py-3 bg-pink-300 text-white rounded-lg shadow hover:bg-pink-400 mt-4">
                    Ajukan Penarikan 💸
                </button>
            </form>

            {{-- Riwayat Penarikan --}}
            <h3 class="text-xl font-bold mt-10 mb-4 text-pink-600">Riwayat Penarikan</h3>

            <table class="w-full border rounded-lg overflow-hidden">
                <thead class="bg-pink-100 text-pink-700 font-semibold">
                    <tr>
                        <th class="p-3 border">Jumlah</th>
                        <th class="p-3 border">Bank</th>
                        <th class="p-3 border">Rekening</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdrawals as $wd)
                        <tr class="hover:bg-pink-50">
                            <td class="p-3 border">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                            <td class="p-3 border">{{ $wd->bank_name }}</td>
                            <td class="p-3 border">{{ $wd->bank_account_number }}</td>
                            <td class="p-3 border">{{ ucfirst($wd->status) }}</td>
                            <td class="p-3 border">{{ $wd->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-5 text-center text-gray-500">
                                Belum ada penarikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
