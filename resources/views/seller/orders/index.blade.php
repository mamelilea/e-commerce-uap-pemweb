@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-bold mb-4">Daftar Pesanan</h2>

<table class="table-auto w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-3">ID</th>
            <th class="p-3">Pembeli</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td class="p-3 text-center">{{ $order->id }}</td>
            <td class="p-3">{{ $order->buyer->name }}</td>
            <td class="p-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            <td class="p-3">{{ $order->status }}</td>
            <td class="p-3 text-center">
                <a href="{{ route('seller.orders.show', $order->id) }}" 
                   class="bg-blue-600 text-white px-3 py-1 rounded">
                    Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection





