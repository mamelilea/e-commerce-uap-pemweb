<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi | Techly</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landingpage/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            min-height: 100vh;
        }

        .main-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 100px 20px 80px;
        }

        .page-header {
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease-out;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #1e293b 0%, #4A6CF7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 15px;
            color: #64748b;
        }

        /* Transaction Card Styles */
        .history-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .history-card:nth-child(1) { animation-delay: 0.1s; }
        .history-card:nth-child(2) { animation-delay: 0.2s; }
        .history-card:nth-child(3) { animation-delay: 0.3s; }

        .history-card:hover {
            box-shadow: 0 12px 28px rgba(74, 108, 247, 0.12);
            transform: translateY(-4px);
            border-color: #4A6CF7;
        }

        .history-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px 28px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .transaction-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .transaction-code {
            font-weight: 700;
            font-size: 16px;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .transaction-code::before {
            content: '📋';
            font-size: 18px;
        }

        .history-date {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .history-date::before {
            content: '🕐';
            font-size: 14px;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 700;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-unpaid { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }

        .status-unpaid::before {
            background: #dc2626;
        }

        .status-paid { 
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #16a34a;
        }

        .status-paid::before {
            background: #16a34a;
        }

        .status-shipped { 
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0284c7;
        }

        .status-shipped::before {
            background: #0284c7;
        }

        /* History Body */
        .history-body {
            padding: 28px;
        }

        .history-item {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 2px dashed #e5e7eb;
            transition: all 0.3s;
        }

        .history-item:hover {
            padding-left: 10px;
        }

        .history-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .item-image-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .item-image {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #f1f5f9;
            transition: all 0.3s;
        }

        .history-item:hover .item-image {
            border-color: #4A6CF7;
            transform: scale(1.05);
        }

        .item-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .item-info h4 {
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            line-height: 1.4;
        }

        .item-details {
            font-size: 14px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .item-price {
            font-size: 16px;
            font-weight: 700;
            color: #4A6CF7;
            margin-top: 4px;
        }

        /* History Footer */
        .history-footer {
            padding: 24px 28px;
            background: linear-gradient(135deg, #fafbfc 0%, #f8fafc 100%);
            border-top: 2px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .total-section {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .total-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .total-price {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, #4A6CF7 0%, #3b56c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .shipping-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #475569;
            background: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .shipping-info::before {
            content: '🚚';
            font-size: 16px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 16px;
            animation: fadeIn 0.6s ease-out;
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #334155;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .btn-shop {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #4A6CF7 0%, #3b56c7 100%);
            color: white;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
        }

        .btn-shop:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(74, 108, 247, 0.4);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 26px;
            }

            .history-item {
                flex-direction: column;
                gap: 15px;
            }

            .item-image {
                width: 100%;
                height: 200px;
            }

            .history-footer {
                flex-direction: column;
                text-align: center;
            }

            .total-price {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header class="main-header" style="background:white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('uploads/weblogo.png') }}" alt="Techly" class="logo-img" />
                </a>
                <nav class="nav-menu">
                    <a href="{{ route('home') }}#products" class="nav-link">Produk</a>
                    <a href="{{ route('home') }}#categories" class="nav-link">Kategori</a>
                    <a href="{{ route('home') }}#about" class="nav-link">Tentang</a>
                    <a href="{{ route('history.index') }}" class="nav-link active">Riwayat</a>
                    <a href="{{ route('profile.edit') }}" class="nav-link">Akun</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Riwayat Transaksi</h1>
            <p class="page-subtitle">Lihat semua pembelian dan detail transaksi Anda</p>
        </div>

        @if($transactions->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <h3>Belum ada transaksi</h3>
                <p>Yuk mulai belanja produk teknologi impianmu!</p>
                <a href="{{ route('home') }}" class="btn-shop">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Belanja Sekarang
                </a>
            </div>
        @else
            @foreach($transactions as $transaction)
                <div class="history-card">
                    <div class="history-header">
                        <div class="transaction-info">
                            <span class="transaction-code">#{{ $transaction->code }}</span>
                            <span class="history-date">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <span class="status-badge status-{{ $transaction->payment_status }}">
                            @if($transaction->payment_status == 'paid')
                                Lunas
                            @elseif($transaction->payment_status == 'unpaid')
                                Belum Dibayar
                            @elseif($transaction->payment_status == 'shipped')
                                Dikirim
                            @else
                                {{ ucfirst($transaction->payment_status) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="history-body">
                        @foreach($transaction->transactionDetails as $detail)
                            <div class="history-item">
                                <div class="item-image-wrapper">
                                    <img src="{{ asset($detail->product->productImages->first()->image ?? 'img/products/default-product.png') }}" 
                                         class="item-image" 
                                         alt="{{ $detail->product->name }}">
                                </div>
                                <div class="item-info">
                                    <h4>{{ $detail->product->name }}</h4>
                                    <div class="item-details">
                                        <span>Jumlah: {{ $detail->qty }} pcs</span>
                                        <span>•</span>
                                        <span>@ Rp {{ number_format($detail->price ?? $detail->product->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="item-price">
                                        Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="history-footer">
                        <div class="total-section">
                            <span class="total-label">Total Pembayaran</span>
                            <div class="total-price">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                        </div>
                        <div class="shipping-info" style="text-transform: capitalize;">
                            {{ $transaction->shipping_type ?? 'Reguler' }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @include('components.footer')

</body>
</html>
