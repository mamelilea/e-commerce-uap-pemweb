@extends('layouts.admin.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="admin-title">Dashboard Admin</h1>

    <div class="admin-dashboard-row">

        {{-- KIRI — WELCOME TEXT --}}
        <div class="admin-welcome-card">
            <h2>Selamat Datang, {{ auth()->user()->name }}</h2>
            <p>Kelola toko, pengguna, dan sistem e-commerce dari panel admin ini.</p>
        </div>

        {{-- KANAN — GAMBAR ILUSTRASI --}}
        <div class="admin-dashboard-illustration">
            <img src="{{ asset('img/element-web/admin-dashboard-pic.svg') }}" alt="Admin Illustration">
        </div>

    </div>
@endsection
