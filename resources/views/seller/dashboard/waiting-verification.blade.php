@extends('layouts.seller.seller')

@section('title', 'Menunggu Verifikasi Toko')

@section('head')
<link rel="stylesheet" href="{{ asset('css/seller/waiting-verification.css') }}">
@endsection

@section('content')
<div class="waiting-wrapper">
    <div class="waiting-card">
        <div class="waiting-header-row">
            <div class="waiting-icon">⏳</div>
            <div>
                <div class="waiting-badge">
                    <span class="waiting-badge-dot"></span>
                    Menunggu Verifikasi Admin
                </div>
                <h2 class="waiting-title">Toko kamu sedang direview</h2>
            </div>
        </div>

        <p class="waiting-text">
            Terima kasih sudah mendaftar sebagai seller di <strong>Techly</strong>.
            Tim admin kami sedang meninjau data toko yang kamu kirim.
        </p>
        <ul class="waiting-list">
            <li>Proses verifikasi biasanya memakan waktu beberapa jam.</li>
            <li>Kamu akan mendapatkan notifikasi setelah toko disetujui.</li>
        </ul>
        <p class="waiting-text">
            Sambil menunggu, kamu masih bisa berbelanja sebagai pembeli di halaman utama.
        </p>

        <div class="waiting-footer">
            <span class="waiting-note">
                Jika verifikasi lebih dari 24 jam, silakan hubungi admin melalui halaman kontak.
            </span>

            <a href="{{ route('home') }}" class="waiting-btn">
                ⬅ Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
