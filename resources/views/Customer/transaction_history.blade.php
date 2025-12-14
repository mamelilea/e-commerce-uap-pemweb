<x-customer-layout>
    <style>


        :root{
            --bg: #FFFAFB; 
            --panel: #FFFFFF;
            --panel2: #FFF0F5; 
            --garis: #E6D0D8;
            --garis2: #D1B3BE;
            --teks: #2D2D2D; 
            --muted: #666666;
            --muted2: #888888;
            --putih: #FFFFFF;
            --hitam: #000000;
            --pink-accent: #FFB6C1;
            --pink-tua: #d26b6bff;
        }

        body {
            background-color: var(--bg);
            color: var(--teks);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }
        
        /* Shared Container for consistent alignment */
        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 250, 251, 0.95);
            border-bottom: 1px solid var(--garis);
            backdrop-filter: blur(10px);
        }

        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--teks);
            text-decoration: none;
        }
        .brand-logo {
            width: 42px;
            height: 42px;
            background: var(--hitam);
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-weight: 900;
            color: var(--putih);
            font-size: 16px;
        }
        .brand-name {
            font-weight: 800;
            font-size: 16px;
            line-height: 1.2;
        }

        .brand-tag {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid var(--garis2);
            color: var(--teks);
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s;
        }
        .nav-btn:hover {
            background: var(--teks);
            color: var(--putih);
            transform: translateY(-1px);
        }

        .nav-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .history-container {
            max-width: 850px;
            margin: 40px auto 60px;
            padding: 0 24px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 40px;
            color: var(--teks);
            letter-spacing: -0.5px;
            text-align: center;
        }

        .transaction-card {
            background: var(--panel);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid var(--garis);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .transaction-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 1px dashed var(--garis);
            margin-bottom: 16px;
        }

        .trx-meta {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .trx-code {
            font-family: monospace;
            font-weight: 700;
            color: var(--teks);
            background: var(--panel2);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 14px;
        }

        .trx-date {
            font-size: 13px;
            color: var(--muted);
        }

        .status-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .status-unpaid { background: #fee2e2; color: #991b1b; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }

        .card-body {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .product-preview {
            display: flex;
            gap: 8px;
        }

        .preview-img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--panel2);
            border: 1px solid var(--garis);
        }

        .trx-info {
            flex: 1;
        }

        .store-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .total-price {
            font-size: 18px;
            font-weight: 800;
            color: var(--teks);
        }

        .btn-detail {
            background: var(--hitam);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background: var(--pink-accent);
            color: var(--hitam);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--garis2);
        }

        @media (max-width: 600px) {
            .card-body {
                flex-direction: column;
                align-items: flex-start;
            }
            .btn-detail {
                width: 100%;
                text-align: center;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .status-badge {
                align-self: flex-start;
            }
        }
    </style>



    <div class="history-container">
        <a href="{{ route('customer.home') }}" style="text-decoration: none; color: var(--teks); display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; font-weight: 700;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h1 class="page-title">Riwayat Transaksi</h1>

        @if($transactions->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-receipt"></i></div>
                <h3>Belum ada transaksi</h3>
                <p>Yuk mulai belanja barang-barang lucu di Y2K!</p>
                <a href="{{ route('customer.home') }}" style="display:inline-block; margin-top:20px; color:var(--text-main); font-weight:700;">Mulai Belanja &rarr;</a>
            </div>
        @else
            @foreach($transactions as $trx)
                <div class="transaction-card">
                    <div class="card-header">
                        <div class="trx-meta">
                            <span class="trx-code">#{{ $trx->code }}</span>
                            <span class="trx-date">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @php
                            $statusInfo = match($trx->payment_status) {
                                'unpaid' => ['class' => 'status-unpaid', 'label' => 'Belum Bayar'],
                                'paid' => ['class' => 'status-paid', 'label' => 'Lunas'],
                                default => ['class' => 'status-pending', 'label' => ucfirst($trx->payment_status)],
                            };
                        @endphp
                        <span class="status-badge {{ $statusInfo['class'] }}">
                            {{ $statusInfo['label'] }}
                        </span>
                    </div>

                    <div class="card-body">
                        <!-- Product Previews (Limit 3) -->
                        <div class="product-preview">
                            @foreach($trx->transactionDetails->take(3) as $detail)
                                <img src="{{ asset('storage/' . ($detail->product->thumbnail->image ?? 'images/default-product.png')) }}" 
                                     alt="product" 
                                     class="preview-img"
                                     title="{{ $detail->product->name }}">
                            @endforeach
                            @if($trx->transactionDetails->count() > 3)
                                <div class="preview-img" style="display:grid; place-items:center; font-size:12px; font-weight:700; background:#eee;">
                                    +{{ $trx->transactionDetails->count() - 3 }}
                                </div>
                            @endif
                        </div>

                        <div class="trx-info">
                            <div class="store-name">
                                <i class="fa-solid fa-shop"></i> {{ $trx->store->name ?? 'Y2K Store' }}
                            </div>
                            <div class="total-price">
                                Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                            </div>
                            <div style="font-size:13px; color:var(--text-muted);">
                                {{ $trx->transactionDetails->sum('qty') }} Produk
                            </div>
                        </div>

                        <a href="{{ route('transaction.detail', $trx->id) }}" class="btn-detail">
                            Lihat Detail
                        </a>

                    </div>
                </div>
            @endforeach

            <div style="margin-top: 40px;">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</x-customer-layout>
