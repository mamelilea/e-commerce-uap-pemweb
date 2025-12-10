<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-400 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-pink-100">

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-2xl font-bold text-pink-400 mb-6">Detail Pesanan #{{ $order->id }}</h3>

                {{-- Informasi Pembeli & Total --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Nama Pembeli:</p>
                        <p class="font-semibold">{{ $order->buyer->name ?? $order->buyer_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Pembayaran:</p>
                        <p class="font-semibold text-pink-500">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Status Pesanan:</p>
                        <span class="px-3 py-1 rounded-full text-sm
                            @if($order->status == 'pending') bg-yellow-200 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-200 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-200 text-purple-800
                            @elseif($order->status == 'completed') bg-green-200 text-green-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-600">Nomor Resi:</p>
                        <p class="font-semibold">{{ $order->resi_number ?? '-' }}</p>
                    </div>
                </div>

                <hr class="my-6 border-pink-200">

                {{-- Produk Pesanan --}}
                <h4 class="text-lg font-semibold mb-2">Produk</h4>
                <table class="min-w-full text-left border-collapse mb-6">
                    <thead class="bg-pink-100 text-pink-700">
                        <tr>
                            <th class="px-6 py-2">Produk</th>
                            <th class="px-6 py-2">Qty</th>
                            <th class="px-6 py-2">Harga</th>
                            <th class="px-6 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->transactionDetails as $detail)
                            <tr class="border-b">
                                <td class="px-6 py-2">{{ $detail->product->name ?? 'Produk' }}</td>
                                <td class="px-6 py-2">{{ $detail->qty }}</td>
                                <td class="px-6 py-2">Rp {{ number_format($detail->price ?? $detail->product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-2">Rp {{ number_format($detail->subtotal ?? ($detail->qty * ($detail->price ?? $detail->product->price)), 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Update Status --}}
                <form action="{{ route('toko.orders.updateStatus', $order->id) }}" method="POST" class="mb-6">
                    @csrf
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Ubah Status Pesanan</label>
                    <select name="status" id="status" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-pink-300 focus:border-pink-300">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="mt-3 bg-pink-300 hover:bg-pink-400 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                        Simpan Perubahan
                    </button>
                </form>

                {{-- Update Nomor Resi --}}
                <form action="{{ route('toko.orders.updateResi', $order->id) }}" method="POST">
                    @csrf
                    <label for="resi_number" class="block text-gray-700 font-semibold mb-2">Nomor Resi Pengiriman</label>
                    <input type="text" name="resi_number" id="resi_number" value="{{ $order->resi_number }}"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-pink-300 focus:border-pink-300" placeholder="Masukkan nomor resi">
                    <button type="submit" class="mt-3 bg-pink-300 hover:bg-pink-400 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                        Perbarui Resi
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
