@extends('store.layouts.app')

@section('title', 'Menunggu Verifikasi')

@section('content')
<style>
    .pending-card {
        background: white;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 5px 20px rgba(255, 107, 157, 0.15);
        max-width: 700px;
        margin: 50px auto;
        text-align: center;
    }

    .pending-icon {
        font-size: 100px;
        margin-bottom: 30px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .pending-card h1 {
        color: #ff6b9d;
        font-size: 32px;
        margin-bottom: 15px;
    }

    .pending-card p {
        color: #666;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .store-info-box {
        background: linear-gradient(135deg, #fff5f8, #fce4ec);
        border-radius: 15px;
        padding: 25px;
        margin-top: 30px;
        text-align: left;
    }

    .store-info-box h3 {
        color: #ff6b9d;
        margin-bottom: 20px;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 107, 157, 0.2);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-weight: 600;
        font-size: 14px;
    }

    .info-value {
        color: #333;
        font-size: 14px;
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        background: #fff3cd;
        color: #856404;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .timeline {
        margin-top: 40px;
        text-align: left;
    }

    .timeline h3 {
        color: #ff6b9d;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .timeline-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .timeline-content h4 {
        color: #333;
        margin-bottom: 5px;
        font-size: 15px;
    }

    .timeline-content p {
        color: #666;
        font-size: 13px;
        margin: 0;
    }

    .action-buttons {
        margin-top: 30px;
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #ff6b9d;
        border: 2px solid #ff6b9d;
    }

    .btn-secondary:hover {
        background: #ff6b9d;
        color: white;
    }

    @media (max-width: 768px) {
        .pending-card {
            padding: 30px 20px;
        }

        .pending-card h1 {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="pending-card">
    <div class="pending-icon">⏳</div>
    
    <h1>Toko Sedang Diverifikasi</h1>
    <p>Terima kasih telah mendaftarkan toko Anda! Saat ini toko Anda sedang dalam proses verifikasi oleh tim admin kami.</p>
    
    <span class="status-badge">⏳ Menunggu Verifikasi</span>

    <div class="store-info-box">
        <h3>📋 Informasi Toko Anda</h3>
        
        <div class="info-row">
            <span class="info-label">Nama Toko</span>
            <span class="info-value">{{ $store->name }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Kota</span>
            <span class="info-value">{{ $store->city }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Nomor Telepon</span>
            <span class="info-value">{{ $store->phone }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Tanggal Pendaftaran</span>
            <span class="info-value">{{ $store->created_at->format('d F Y, H:i') }}</span>
        </div>
    </div>

    <div class="timeline">
        <h3>📅 Proses Verifikasi</h3>
        
        <div class="timeline-item">
            <div class="timeline-icon">✓</div>
            <div class="timeline-content">
                <h4>Pendaftaran Berhasil</h4>
                <p>Toko Anda telah terdaftar di sistem kami</p>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon">🔍</div>
            <div class="timeline-content">
                <h4>Sedang Diverifikasi</h4>
                <p>Tim admin sedang meninjau informasi toko Anda</p>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon" style="background: #ddd; color: #666;">⏳</div>
            <div class="timeline-content">
                <h4>Menunggu Persetujuan</h4>
                <p>Proses verifikasi biasanya memakan waktu 1-3 hari kerja</p>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('store.edit') }}" class="btn btn-secondary">
            ✏️ Edit Informasi Toko
        </a>
        <button onclick="window.location.reload()" class="btn btn-primary">
            🔄 Refresh Status
        </button>
    </div>

    <p style="margin-top: 30px; font-size: 14px; color: #999;">
        💡 Tip: Anda akan menerima notifikasi email setelah toko Anda diverifikasi
    </p>
</div>
@endsection