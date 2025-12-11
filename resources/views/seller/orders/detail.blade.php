@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h2>

<div class="bg-white shadow rounded p-5 mb-6">
    <h3 class="font-bold text-lg mb-2">Informasi Pembeli</h3>
    <p>Nama: {{ $order->buyer->name }}</p>
    <p>Email: {{ $order->buyer->email }}</p>
    <p>Alamat: {{ $order->address }}</p>
</div>

<div class="bg-white shadow rounded p-5 mb-6">
    <h3 class="font-bold text-lg mb-2">Produk</h3>
    <table class="table-auto w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Produk</th>
                <th class="p-2 text-center">Qty</th>
                <th class="p-2 text-right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $item)
            <tr>
                <td class="p-2">{{ $item->product->name }}</td>
                <td class="p-2 text-center">{{ $item->quantity }}</td>
                <td class="p-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white shadow rounded p-5 mb-6">
    <h3 class="font-bold text-lg mb-2">Update Status Pesanan</h3>
    <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST">
        @csrf
        <select name="status" class="border p-2 rounded">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <button class="bg-blue-600 text-white px-3 py-2 rounded">Update</button>
    </form>
</div>

<div class="bg-white shadow rounded p-5 mb-6">
    <h3 class="font-bold text-lg mb-2">Update Nomor Resi</h3>
    <form action="{{ route('seller.orders.update-resi', $order->id) }}" method="POST">
        @csrf
        <input type="text" name="shipping_code" value="{{ $order->shipping_code }}"
               class="border p-2 rounded w-64" placeholder="Masukkan nomor resi">

        <button class="bg-green-600 text-white px-3 py-2 rounded">Simpan</button>
    </form>
</div>

@endsection







