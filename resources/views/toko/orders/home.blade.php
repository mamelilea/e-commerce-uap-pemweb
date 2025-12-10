<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Judul --}}
            <h3 class="text-center text-2xl font-bold text-pink-400 mb-6">
                Daftar Pesanan Masuk
            </h3>

            {{-- Filter Status --}}
            <div class="mb-6 flex justify-center gap-3">
                @foreach(['pending','processing','shipped','completed'] as $s)
                    <a href="{{ route('toko.orders.home', ['status' => $s]) }}"
                       class="px-4 py-2 rounded-lg bg-white shadow text-gray-700 hover:bg-pink-100 {{ request('status') == $s ? 'bg-pink-100 text-pink-700' : '' }}">
                        {{ ucfirst($s) }}
                    </a>
                @endforeach
            </div>

            {{-- Tabel Pesanan --}}
            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <table class="min-w-full text-left border-collapse">
                    <thead class="bg-pink-100 text-pink-700">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-sm">ID</th>
                            <th class="px-6 py-3 font-semibold text-sm">Pembeli</th>
                            <th class="px-6 py-3 font-semibold text-sm">Total</th>
                            <th class="px-6 py-3 font-semibold text-sm">Status</th>
                            <th class="px-6 py-3 font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b hover:bg-pink-50">
                                <td class="px-6 py-4">{{ $order->id }}</td>
                                <td class="px-6 py-4">{{ $order->buyer->name ?? $order->buyer_name }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-yellow-200 text-yellow-800',
                                            'processing' => 'bg-blue-200 text-blue-800',
                                            'shipped' => 'bg-purple-200 text-purple-800',
                                            'completed' => 'bg-green-200 text-green-800',
                                            default => 'bg-gray-200 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('toko.orders.show', $order->id) }}"
                                       class="px-4 py-2 bg-pink-300 text-white rounded-lg hover:bg-pink-400">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
