@extends('layouts.seller.seller')

@section('title', 'Dashboard Seller')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/seller/register-store.css') }}">
@endsection

@section('content')
    <div class="register-wrapper">
        <div class="register-right" style="flex:1; max-width:600px; margin:auto;">
            <div class="store-card">
                <h2 class="store-title">Dashboard Toko {{ $store->name }}</h2>
                <p>Selamat, toko kamu sudah terverifikasi! Nanti di sini kita isi ringkasan pesanan, produk, saldo, dll.</p>
            </div>
        </div>
    </div>
@endsection
