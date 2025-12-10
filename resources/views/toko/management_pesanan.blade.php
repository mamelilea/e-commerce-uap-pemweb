<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('Manajemen Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-center text-2xl font-bold text-pink-400 mb-6">
                Daftar Pesanan Masuk
            </h3>

            <div class="bg-white shadow-md rounded-2xl p-8 border border-pink-100">

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pink-100 text-pink-700">
                            <th class="p-3 border">ID Pesanan</th>
                            <th class="p-3 border">Nama Pembeli</th>
                            <th class="p-3 border">Total</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-pink-50">
                                <td class="p-3">{{ $order->id }}</td>
                                <td class="p-3">{{ $order->buyer->name }}</td>
                                <td class="p-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>

                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-lg text-white
                                        @if($order->status == 'waiting') bg-gray-500
                                        @elseif($order->status == 'packed') bg-blue-500
                                        @elseif($order->status == 'shipped') bg-orange-500
                                        @elseif($order->status == 'completed') bg-green-600
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td class="p-3 space-x-2">
                                    <a href="{{ route('toko.orders.show', $order->id) }}"
                                        class="px-4 py-2 bg-pink-300 hover:bg-pink-400 text-white rounded-lg text-sm">
                                        Detail
                                    </a>

                                    <a href="{{ route('toko.orders.updateStatus', $order->id) }}"
                                        class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg text-sm">
                                        Update Status
                                    </a>

                                    <a href="{{ route('toko.orders.updateResi', $order->id) }}"
                                        class="px-4 py-2 bg-green-400 hover:bg-green-500 text-white rounded-lg text-sm">
                                        Input Resi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</x-app-layout>
