@extends('layouts.seller.seller')

@section('head')
<link rel="stylesheet" href="{{ asset('css/seller/dashboard.css') }}">
@endsection

@section('content')

<div class="dash-welcome">
    <h1>Dashboard Seller</h1>
    <p>Halo {{ Auth::user()->name }}, selamat datang di dashboard seller!</p>
</div>

<div class="dash-cards">

    <div class="dash-card">
        <h3>Toko Anda</h3>
        <p>{{ $store->name }}</p>
    </div>

    <div class="dash-card">
        <h3>Total Produk</h3>
        <p>{{ $productCount }}</p>
    </div>

</div>

@endsection
