<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                Pesanan Saya
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Lihat riwayat pembelianmu di KiloMeter.
            </p>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6">
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($transactions->isEmpty())
            <p class="text-sm text-slate-500">
                Kamu belum memiliki pesanan.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <th class="py-2 pr-4 text-left">Kode</th>
                            <th class="py-2 px-4 text-left">Toko</th>
                            <th class="py-2 px-4 text-left">Tanggal</th>
                            <th class="py-2 px-4 text-left">Total</th>
                            <th class="py-2 px-4 text-left">Status Pembayaran</th>
                            <th class="py-2 pl-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="py-2 pr-4 font-mono text-xs text-slate-800">
                                    {{ $transaction->code }}
                                </td>
                                <td class="py-2 px-4 text-slate-800">
                                    {{ $transaction->store->name ?? '-' }}
                                </td>
                                <td class="py-2 px-4 text-slate-600">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="py-2 px-4">
                                    <x-currency :value="$transaction->grand_total" class="font-semibold text-slate-900" />
                                </td>
                                <td class="py-2 px-4">
                                    @if ($transaction->payment_status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700">
                                            Belum dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 pl-4 text-right">
                                    <a href="{{ route('orders.show', $transaction) }}"
                                       class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
