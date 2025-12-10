@extends('layouts.seller.seller')

@section('title', 'Registrasi Toko')

@section('head')
<link rel="stylesheet" href="{{ asset('css/seller/register-store.css') }}">
@endsection

@section('content')

<div class="register-wrapper">

    {{-- KIRI: Ilustrasi --}}
    <div class="register-left">
        <img src="{{ asset('img/element-web/shop-regist-store.svg') }}"
             alt="Ilustrasi Registrasi Toko"
             class="register-illustration">
    </div>

    {{-- KANAN: Judul + Form --}}
    <div class="register-right">
        <h2 class="store-title">Registrasi Toko</h2>

        <div class="store-card">
            <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data" class="store-form">
                @csrf
                <div class="form-group">
                    <label>Nama Toko</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi Toko</label>
                    <textarea name="about" required></textarea>
                </div>
                <div class="form-group">
                    <label>No Telepon / WhatsApp</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="form-group">
                    <label>Kota</label>
                    <input type="text" name="city" required>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="postal_code" required>
                </div>
                <div class="form-group">
                    <label>Logo Toko (opsional)</label>
                    <input type="file" name="logo" accept="image/*">
                </div>
                <button type="submit" class="btn-submit">Daftarkan Toko</button>
            </form>
        </div>
    </div>
</div>
@endsection
