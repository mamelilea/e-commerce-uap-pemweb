<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Keuangan</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saldo Toko</h2>
        </div>
    </x-slot>

    <x-seller.navbar />
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-100 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm">Riwayat Saldo</h3>
                                <p class="text-xs text-gray-500">Catatan perubahan saldo toko Anda.</p>
                            </div>
                            <span class="text-xs text-gray-500">/seller/balance</span>
                        </div>

                        <div class="px-6 py-5">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Tipe</th>
                                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Keterangan</th>
                                            <th class="px-4 py-3 text-right font-semibold text-gray-700">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($histories as $history)
                                            @php
                                                $isIncome = $history->type === 'income';
                                                $amountClass = $isIncome
                                                    ? 'text-emerald-700 bg-emerald-50 border-emerald-200'
                                                    : 'text-rose-700 bg-rose-50 border-rose-200';
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 align-top text-sm text-gray-700">{{ $history->created_at->format('d M Y, H:i') }}</td>
                                                <td class="px-4 py-3 align-top">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $amountClass }}">
                                                        {{ $history->type === 'income' ? 'Pemasukan' : 'Penarikan' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 align-top text-sm text-gray-800">
                                                    <div class="font-medium">{{ $history->remarks }}</div>
                                                    <div class="text-xs text-gray-500">Ref: {{ $history->reference_type }} ({{ $history->reference_id }})</div>
                                                </td>
                                                <td class="px-4 py-3 align-top text-right font-semibold text-gray-900">
                                                    {{ $isIncome ? '+' : '-' }} Rp {{ number_format($history->amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada riwayat saldo.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $histories->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">Saldo Saat Ini</h3>
                            <p class="text-xs text-gray-500">Total dana tersedia di akun toko Anda.</p>
                        </div>
                        <div class="px-6 py-6 space-y-3">
                            <div class="text-sm text-gray-500">Saldo</div>
                            <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($balance->balance, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500">Diperbarui pada {{ $balance->updated_at?->format('d M Y, H:i') ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>