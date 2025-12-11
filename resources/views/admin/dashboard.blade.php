@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(255, 107, 157, 0.2);
    }

    .stat-icon {
        font-size: 40px;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #ff6b9d;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .welcome-card {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fb3 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(255, 107, 157, 0.3);
    }

    .welcome-card h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .welcome-card p {
        font-size: 16px;
        opacity: 0.95;
    }

    .quick-actions {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .quick-actions h3 {
        color: #ff6b9d;
        margin-bottom: 20px;
        font-size: 20px;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
    }

    .action-icon {
        font-size: 24px;
    }
</style>

<div class="welcome-card">
    <h2>👋 Selamat Datang, {{ auth()->user()->name }}!</h2>
    <p>Ini adalah dashboard admin untuk mengelola e-commerce Anda</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Total Pengguna</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🏪</div>
        <div class="stat-value">{{ $totalStores }}</div>
        <div class="stat-label">Total Toko</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value">{{ $verifiedStores }}</div>
        <div class="stat-label">Toko Terverifikasi</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">{{ $pendingStores }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
    </div>
</div>

<div class="quick-actions">
    <h3>⚡ Aksi Cepat</h3>
    <div class="action-buttons">
        <a href="{{ route('admin.store.verification') }}" class="action-btn">
            <span class="action-icon">✅</span>
            <span>Verifikasi Toko</span>
        </a>
        <a href="{{ route('admin.users') }}" class="action-btn">
            <span class="action-icon">👥</span>
            <span>Kelola Pengguna</span>
        </a>
        <a href="{{ route('admin.stores') }}" class="action-btn">
            <span class="action-icon">🏪</span>
            <span>Kelola Toko</span>
        </a>
    </div>
</div>
@endsection