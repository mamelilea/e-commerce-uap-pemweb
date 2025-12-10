<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil | Techly</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <style>
        .success-wrapper {
            max-width: 600px;
            margin: 80px auto;
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        .icon-success {
            width: 80px;
            height: 80px;
            background: #d1fae5;
            color: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
        .success-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .success-desc {
            color: #666;
            margin-bottom: 30px;
        }
        .order-details {
            text-align: left;
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
            font-weight: 600;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 10px;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-width: 180px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #4A6CF7 0%, #3b56c7 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(74, 108, 247, 0.4);
        }
        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-gradient:hover::before {
            left: 100%;
        }
        .btn-outline {
            background: #fff;
            color: #4A6CF7;
            border: 2px solid #4A6CF7;
        }
        .btn-outline:hover {
            background: #f8f9ff;
            border-color: #3b56c7;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.15);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <!-- NAVBAR -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('uploads/weblogo.png') }}" alt="Techly" class="logo-img" />
                </a>
                <nav class="nav-menu">
                    <a href="{{ route('home') }}#products" class="nav-link">Produk</a>
                    <a href="{{ route('home') }}#categories" class="nav-link">Kategori</a>
                    <a href="{{ route('home') }}#about" class="nav-link">Tentang</a>
                    
                    @auth
                        <a href="{{ route('history.index') }}" class="nav-link">Riwayat</a>
                        <a href="{{ route('profile.edit') }}" class="nav-link">Akun</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link nav-login">Login</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- ================= BREADCRUMB ================= -->
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}" class="breadcrumb-item">Beranda</a>
            <span class="breadcrumb-separator">&gt;</span>
            <span class="breadcrumb-item">Checkout</span>
            <span class="breadcrumb-separator">&gt;</span>
            <span class="breadcrumb-item active">Sukses</span>
        </div>
    </div>

    <div class="container">
        <div class="success-wrapper">
            <div class="icon-success">✓</div>
            <h2 class="success-title">Pembayaran Berhasil!</h2>
            <p class="success-desc">Terima kasih, pesanan Anda telah kami terima dan akan segera diproses.</p>

            <div class="order-details">
                <div class="detail-row">
                    <span>Transaction Code</span>
                    <span>#{{ $transaction->code }}</span>
                </div>
                <div class="detail-row">
                    <span>Nama Produk</span>
                    <span>{{ $transaction->transactionDetails->first()->product->name ?? 'Produk' }}</span>
                </div>
                <div class="detail-row">
                    <span>Metode Pengiriman</span>
                    <span style="text-transform: capitalize;">{{ $transaction->shipping_type }}</span>
                </div>
                <div class="detail-row">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-top: 5px;">
                <a href="{{ route('home') }}" class="btn-home btn-outline">
                    <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                @auth
                    <a href="{{ route('history.index') }}" class="btn-home btn-gradient">
                        <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Riwayat
                    </a>
                @endauth
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>
