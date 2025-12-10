<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('Saldo Toko') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-8 rounded-xl shadow-md">

                <h3 class="text-2xl font-bold text-pink-400 mb-6">
                    Saldo Toko: {{ $store->name }}
                </h3>

                <p class="text-lg text-gray-700 mb-4">
                    Total Saldo Saat Ini:
                </p>

                <div class="bg-pink-100 text-pink-700 p-5 rounded-lg text-3xl font-bold mb-10">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </div>

                <h4 class="text-xl font-semibold mb-4">Riwayat Transaksi:</h4>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-pink-100 text-pink-700">
                            <th class="p-3 border">Kode</th>
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Total</th>
                            <th class="p-3 border">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr class="border-b">
                                <td class="p-3">{{ $trx->code }}</td>
                                <td class="p-3">{{ $trx->created_at->format('d M Y') }}</td>
                                <td class="p-3">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-lg text-white bg-green-600">
                                        {{ ucfirst($trx->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    Belum ada transaksi masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>
