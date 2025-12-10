<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500">Manajemen</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Masuk</h2>
        </div>
    </x-slot>
    <x-seller.navbar />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded">
                    <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Daftar Pesanan</h3>
                        <p class="text-xs text-gray-500">Pantau pesanan masuk dan perbarui status pengiriman.</p>
                    </div>
                    <span class="text-xs text-gray-500">/seller/orders</span>
                </div>

                <div class="px-6 py-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Pesanan</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Produk</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Pembayaran</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Pengiriman</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'shipped' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $paymentClasses = [
                                        'unpaid' => 'bg-red-50 text-red-700 border-red-200',
                                        'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    ];
                                @endphp
                                @forelse($transactions as $transaction)
                                    @php
                                        $statusClass = $statusClasses[$transaction->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                        $paymentClass = $paymentClasses[$transaction->payment_status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 align-top">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-mono text-gray-500">#{{ $transaction->code }}</span>
                                                    <span class="text-[11px] inline-flex items-center px-2 py-0.5 rounded-full border {{ $statusClass }}">
                                                        {{ $statusOptions[$transaction->status] ?? ucfirst($transaction->status) }}
                                                    </span>
                                                </div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $transaction->buyer?->user?->name ?? 'Pembeli' }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                                                <div class="text-sm text-gray-800">Total: Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <div class="space-y-2">
                                                @forelse($transaction->transactionDetails as $detail)
                                                    <div class="flex items-center justify-between gap-3">
                                                        <div class="text-gray-800">{{ $detail->product?->name ?? 'Produk' }}</div>
                                                        <div class="text-xs text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                                                    </div>
                                                @empty
                                                    <p class="text-xs text-gray-500">Tidak ada detail produk.</p>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <div class="space-y-2">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $paymentClass }}">
                                                    {{ $transaction->payment_status === 'paid' ? 'Sudah dibayar' : 'Belum dibayar' }}
                                                </span>
                                                <div class="text-xs text-gray-600">Pengiriman: {{ $transaction->shipping }} ({{ $transaction->shipping_type }})</div>
                                                <div class="text-xs text-gray-600">Ongkir: Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <div class="space-y-1 text-sm text-gray-800">
                                                <div class="font-medium">Resi</div>
                                                <div class="text-xs text-gray-600">{{ $transaction->tracking_number ?: 'Belum diisi' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <form action="{{ route('seller.orders.update', $transaction) }}" method="POST" class="space-y-3">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">Status pesanan</label>
                                                    <select name="status" class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        @foreach($statusOptions as $value => $label)
                                                            <option value="{{ $value }}" @selected($transaction->status === $value)>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-xs text-gray-600 mb-1">Nomor resi (opsional)</label>
                                                    <input type="text" name="tracking_number" value="{{ old('tracking_number', $transaction->tracking_number) }}" class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Isi nomor resi">
                                                </div>
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Simpan Perubahan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>