@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Riwayat Transaksi</h2>

    @foreach($transactions as $t)
    <div class="card mb-3">
        <div class="card-body">
            <h5>Pesanan #{{ $t['id'] }}</h5>
            <p>Produk: {{ $t['product'] }}</p>
            <p>Tanggal: {{ $t['date'] }}</p>
            <p>Total: Rp {{ number_format($t['total'], 0, ',', '.') }}</p>
        </div>
    </div>
    @endforeach

</div>
@endsection