@extends('seller.layouts.layout')

@section('content')

    <h1 class="text-3xl font-bold text-pink-700 mb-6">Dashboard Seller</h1>
    <p>Selamat datang di dashboard toko Anda!</p>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Box Jumlah Produk -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold">Jumlah Produk</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <!-- Box Pesanan Masuk -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold">Pesanan Masuk</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <!-- Box Saldo -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold">Saldo Toko</h2>
        <p class="text-3xl font-bold mt-2">Rp 0</p>
    </div>

</div>

@endsection

