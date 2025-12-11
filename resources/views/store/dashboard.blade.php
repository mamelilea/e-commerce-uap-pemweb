@extends('store.layouts.app')

@section('title', 'Dashboard Toko')

@section('content')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff8fb3 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(255, 107, 157, 0.3);
    }

    .welcome-banner h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .welcome-banner p {
        font-size: 16px;
        opacity: 0.95;
    }

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

    .store-info-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .store-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #fce4ec;
    }

    .store-logo {
        width: 80px;
        height: 80px;
        border-radius: 15px;
        object-fit: cover;
        border: 3px solid #fce4ec;
    }

    .store-details h2 {
        color: #ff6b9d;
        font-size: 24px;
        margin-bottom: 5px;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: #d4edda;
        color: #155724;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-label {
        color: #666;
        font-size: 13px;
        font-weight: 600;
    }

    .info-value {
        color: #333;
        font-size: 14px;
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

    .action-grid {
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

    @media (max-width: 768px) {
        .store-header {
            flex-direction: column;
            text-align: center;
        }

        .welcome-banner h1 {
            font-size: 22px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="welcome-banner">
    <h1>👋 Selamat Datang, {{ $store->name }}!</h1>
    <p>Kelola toko Anda dengan mudah dari dashboard ini</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-label">Total Produk</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value">{{ $stats['total_transactions'] }}</div>
        <div class="stat-label">Total Transaksi</div>
    </div>

   
</div>

<div class="store-info-card">
    <div class="store-header">
        <img src="{{ asset('storage/' . $store->logo) }}" 
             alt="{{ $store->name }}" 
             class="store-logo">
        <div class="store-details">
            <h2>{{ $store->name }}</h2>
            <span class="verified-badge">
                ✓ Toko Terverifikasi
            </span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">📍 Kota</span>
            <span class="info-value">{{ $store->city }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">📞 Telepon</span>
            <span class="info-value">{{ $store->phone }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">📮 Kode Pos</span>
            <span class="info-value">{{ $store->postal_code }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">📅 Bergabung</span>
            <span class="info-value">{{ $store->created_at->format('d F Y') }}</span>
        </div>
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #fce4ec;">
        <div class="info-item">
            <span class="info-label">📝 Tentang Toko</span>
            <span class="info-value" style="margin-top: 8px;">{{ $store->about }}</span>
        </div>
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #fce4ec;">
        <div class="info-item">
            <span class="info-label">🏠 Alamat Lengkap</span>
            <span class="info-value" style="margin-top: 8px;">{{ $store->address }}</span>
        </div>
    </div>
</div>

<div class="quick-actions">
    <h3>⚡ Aksi Cepat</h3>
    <div class="action-grid">
        <a href="#" class="action-btn">
            <span class="action-icon">➕</span>
            <span>Tambah Produk</span>
        </a>
        <a href="#" class="action-btn">
            <span class="action-icon">📦</span>
            <span>Lihat Pesanan</span>
        </a>
        <a href="{{ route('store.edit') }}" class="action-btn">
            <span class="action-icon">⚙️</span>
            <span>Pengaturan Toko</span>
        </a>
        <a href="#" class="action-btn">
            <span class="action-icon">📊</span>
            <span>Laporan Penjualan</span>
        </a>
    </div>
</div>
@endsection