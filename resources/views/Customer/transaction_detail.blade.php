<x-customer-layout>
<style>
    :root {
        --bg: #FFFFFF; /* White background */
        --card-bg: #FFFFFF;
        --text-main: #1A1A1A;
        --text-muted: #666666;
        --accent-pink: #FFC0CB; /* Light pink */
        --accent-pink-text: #E06C75; 
        --border-color: #E6E4DF;
        --status-pending-bg: #F9F7F2; /* Subtle cream instead of yellow */
        --status-pending-text: #000000; /* Black icon */
        --btn-black: #000000;
        --btn-black-hover: #333333;

        /* Layout Variable Mappings (Light Theme) */
        --teks: #111827;      /* Black text */
        --panel: #FFFFFF;     /* White button bg */
        --panel2: #F9FAFB;    /* Hover bg */
        --garis: #E5E7EB;     /* Light grey border */
        --muted2: #6B7280;    /* Grey icons */
        --putih: #FFFFFF;
        --hitam: #000000;
    }

    body {
        background-color: var(--bg);
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .payment-container {
        max-width: 1120px;
        margin: 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 32px;
        align-items: start; /* Ensure sticky works by not stretching height */
    }

    /* Headers */
    .page-header {
        max-width: 1120px;
        margin: 0 auto;
        padding: 24px 20px 0;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-main);
    }
    
    .back-link {
        color: var(--text-main);
        text-decoration: none;
        font-size: 24px;
    }

    .order-id {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    /* Cards */
    .card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04); /* Softer, slightly larger shadow */
        border: 1px solid var(--border-color);
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-main);
    }

    /* Left Column - Status */
    .status-box {
        background-color: var(--btn-black); /* Black Background */
        border: 1px solid var(--btn-black);
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    .status-icon {
        width: 48px;
        height: 48px;
        background: #FFFFFF; /* White Circle */
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: var(--btn-black); /* Black Icon */
        font-size: 20px;
        margin-bottom: 16px;
    }

    .status-text {
        font-size: 18px;
        font-weight: 700;
        color: #FFFFFF; /* White Text */
        margin-bottom: 8px;
    }

    .status-desc {
        font-size: 14px;
        color: #E0E0E0; /* Light Grey Text */
        max-width: 80%;
    }

    /* Left Column - Instruction */
    .bank-card {
        background: #F8F9FA;
        border: 1px solid #E9ECEF;
        border-radius: 12px;
        padding: 24px; /* More padding */
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .bank-logo {
        width: 60px;
        height: 40px;
        background: white;
        border-radius: 6px;
        display: grid;
        place-items: center;
        font-weight: 900;
        color: var(--text-main); /* Black text */
        border: 1px solid #ddd;
        flex-shrink: 0;
    }

    .bank-details {
        flex: 1;
    }

    .bank-name {
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 4px;
        color: var(--text-main);
    }
    
    .manual-verif {
        font-size: 12px;
        color: var(--accent-pink-text); /* Use Pink for accent */
        margin-bottom: 16px;
        font-weight: 600;
    }

    .account-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 8px;
        color: var(--text-muted);
    }
    
    .account-number {
        font-family: monospace;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
    }

    /* Right Column - Summary */
    .right-col {
        position: sticky;
        top: 40px;
        height: fit-content;
    }

    .summary-item {
        display: flex;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
    }
    
    .summary-img {
        width: 70px; /* Key visual larger */
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .summary-info {
        flex: 1;
    }

    .summary-name {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--text-main);
        line-height: 1.4;
    }

    .summary-price {
        font-size: 13px;
        color: var(--text-muted);
    }

    .calc-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        font-weight: 700;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .total-price {
        color: var(--accent-pink-text); /* Pink total */
        font-size: 24px; /* Larger total */
    }
    
    .confirm-btn {
        display: block;
        width: 100%;
        background: var(--accent-pink); /* Pink Background */
        color: var(--text-main); /* Black Text for contrast */
        text-align: center;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 24px;
        text-decoration: none;
        transition: 0.2s;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    .confirm-btn:hover {
        background: var(--accent-pink-text); /* Darker Pink on hover */
        color: white; /* White text on darker pink */
    }

    /* Header Styles */
    header {
        position: sticky;
        top: 0;
        background: var(--bg);
        border-bottom: 1px solid var(--border-color);
        padding: 16px 20px;
        z-index: 50;
    }
    .header-bar {
        max-width: 1120px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--text-main);
        text-decoration: none;
    }
    .brand-logo {
        width: 42px;
        height: 42px;
        background: var(--btn-black);
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-weight: 900;
        color: #FFFFFF;
        font-size: 16px;
    }
    .brand-name {
        font-weight: 800;
        font-size: 16px;
        line-height: 1.2;
    }
    .brand-tag {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    @media (max-width: 900px) {
        .payment-container {
            grid-template-columns: 1fr;
        }
    }
    .store-mini {
        display: flex; 
        align-items: center; 
        gap: 8px; 
        margin-bottom: 8px;
    }
    .store-mini img { 
        width: 24px; 
        height: 24px; 
        border-radius: 50%; 
        object-fit: cover; 
    }
    .store-mini span { 
        font-size: 11px; 
        color: #aaa; 
        font-weight: 600; 
        text-transform: uppercase; 
    }
    
    /* Search Bar Override (Pink Border) - Matches Screenshot */
    header .search input {
        background: #FFFFFF !important;
        color: #111827 !important;
        border: 2px solid #FCE7F3 !important; /* Pink-ish border */
    }
    header .search input:focus {
        border-color: #EC4899 !important;
        box-shadow: 0 0 0 2px #FCE7F3 !important;
    }
    
    /* Profile Button Specific Override (Black Border not in default layout) */
    header .auth .btn-solid {
        border: 1.5px solid #111827 !important;
    }
    /* Retain Hover Effects as requested */
    header .auth .btn-outline:hover,
    header .auth .btn-solid:hover {
        background: #F9FAFB !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    header .auth .btn-outline:active,
    header .auth .btn-solid:active {
        transform: translateY(0);
        box-shadow: none;
        background: #F3F4F6 !important;
    }

    /* Upload Box Styles */
    .upload-box {
        border: 2px dashed #E0E0E0;
        border-radius: 16px;
        padding: 40px 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #FAFAFA;
        position: relative;
        overflow: hidden;
    }
    .upload-box:hover {
        border-color: var(--accent-pink-text);
        background: #FFF0F3;
    }
    .upload-box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .upload-icon-container {
        width: 64px;
        height: 64px;
        background: #FFFFFF;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .upload-text-main {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
    }
    .upload-text-sub {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* Status Badges */
    .status-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-badge.pending {
        background: #FFF8E1;
        color: #F57F17;
        border: 1px solid #FFE082;
    }
    .status-badge.success {
        background: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #A5D6A7;
        cursor: default;
    }
    .status-badge i {
        font-size: 18px;
    }    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="page-header">
    <a href="{{ route('customer.home') }}" style="text-decoration: none; color: var(--text-main); display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; font-weight: 700;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali
    </a>
    <div class="order-id">ID Pesanan: #{{ $transaction->code }}</div>
</div>

<div class="payment-container" x-data="{ scanned: false }" x-init="setTimeout(() => scanned = true, 10000)">
    <!-- Left Column -->
    <div class="left-col">
        <div class="card">
            <h3 class="card-title">Status Pembayaran</h3>
            <div class="status-box">
                @if($transaction->delivery_status == 'success')
                    <div class="status-icon" style="background:#4CAF50; color:white;">✓</div>
                    <div class="status-text">Pesanan Selesai</div>
                    <div class="status-desc">Terima kasih telah berbelanja di Y2K Accessories.</div>
                @elseif($transaction->delivery_status == 'shipped')
                    <div class="status-icon" style="background:#2196F3; color:white;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div class="status-text">Pesanan Sedang Dikirim</div>
                    <div class="status-desc">Pesanan Anda sedang dalam perjalanan.</div>
                    
                    <form action="{{ route('transaction.complete', $transaction->id) }}" method="POST" style="width: 100%; margin-top: 16px;">
                        @csrf
                        <button type="submit" class="confirm-btn" style="background: #2196F3; color: white; margin-top: 0;" onclick="return confirm('Apakah Anda yakin pesanan sudah diterima?')">
                            Pesanan Diterima
                        </button>
                    </form>
                @elseif($transaction->payment_status == 'paid')
                    <div class="status-icon" style="background:var(--btn-black); color:white;">✓</div>
                    <div class="status-text">Pembayaran Berhasil</div>
                    <div class="status-desc">Pesanan Anda sedang diproses oleh penjual.</div>
                @elseif($transaction->proof_of_payment)
                    <div class="status-icon" style="background:#FFC107; color:black;">!</div>
                    <div class="status-text">Menunggu Verifikasi</div>
                    <div class="status-desc">Admin sedang memverifikasi bukti pembayaran Anda.</div>
                @else
                    <div class="status-icon" style="font-weight:900; font-family:sans-serif;">!</div>
                    <div class="status-text">Pembayaran Diperlukan</div>
                    <div class="status-desc">Silakan selesaikan pembayaran Anda untuk memproses pesanan.</div>
                @endif
            </div>
        </div>

        @if($transaction->tracking_number)
            <div class="card">
                <h3 class="card-title">Informasi Pengiriman</h3>
                <div class="bank-card" style="align-items: center; gap: 16px;">
                    <div class="bank-logo" style="width: 48px; height: 48px; font-size: 20px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div class="bank-details">
                        <div class="bank-name">Nomor Resi</div>
                        <div class="account-number" style="font-size: 18px; margin: 4px 0; letter-spacing: 1px;">
                            {{ $transaction->tracking_number }}
                        </div>
                        <div class="account-row" style="margin-bottom: 0;">
                            <span>Kurir: {{ strtoupper(str_replace('_', ' ', $transaction->shipping_type)) }}</span>
                            <span style="font-weight: 700; color: var(--accent-pink-text);">{{ ucfirst($transaction->delivery_status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!$transaction->proof_of_payment)
        <div class="card">
            <h3 class="card-title">Instruksi Pembayaran</h3>
            
            <!-- QRIS Payment -->
            <div class="bank-card" style="flex-direction: column; align-items: center; text-align: center;">
                <div class="bank-logo" style="width: auto; height: 32px; padding: 0 12px; border: 1px solid var(--text-main); color: var(--text-main);">QRIS</div>
                <div class="bank-details" style="width: 100%; margin-top: 16px;">
                    <div class="bank-name">Scan QR Code</div>
                    <div class="manual-verif">NAMA MERCHANT: Y2K ACCESSORIES</div>
                    
                <div style="margin: 24px 0;">
                        <!-- Custom QR Code -->
                        <img src="{{ asset('images/QR CODE PAYMENT.png') }}" alt="QRIS Code" style="width: 350px; height: 350px; display: block; margin: 0 auto;">
                    </div>
                    

                    <div x-show="scanned" style="margin-top: 16px; color: #4CAF50; font-weight: 700;">
                        ✓ Scan Terkonfirmasi
                    </div>

                    <div style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-top: 24px;">
                        Scan QRIS di atas menggunakan<br>Gopay, OVO, Dana, ShopeePay, atau Mobile Banking.
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($transaction->delivery_status == 'success')
            <div class="card">
                <h3 class="card-title">Berikan Ulasan Produk</h3>
                <div class="flex flex-col gap-6">
                    @foreach($transaction->transactionDetails as $detail)
                        @php 
                            $review = $transaction->productReviews->where('product_id', $detail->product_id)->first(); 
                        @endphp
                        
                        <div class="review-item" style="border-bottom: 1px solid #eee; padding-bottom: 24px; margin-bottom: 24px;">
                            <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                                <img src="{{ asset('storage/' . ($detail->product->thumbnail->image ?? 'images/default-product.png')) }}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;" alt="product">
                                <div>
                                    <div style="font-weight: 700; margin-bottom: 4px;">{{ $detail->product->name }}</div>
                                    <div style="font-size: 14px; color: var(--text-muted);">{{ $detail->qty }}x Item</div>
                                </div>
                            </div>
                            
                            @if($review)
                                <div style="background: #f9f9f9; padding: 16px; border-radius: 8px;">
                                    <div style="color: #FFC107; margin-bottom: 8px; font-size: 18px;">
                                        @for($i=1; $i<=5; $i++)
                                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <p style="font-size: 14px; line-height: 1.5;">{{ $review->review }}</p>
                                </div>
                            @else
                                <form action="{{ route('transaction.review', $transaction->id) }}" method="POST" x-data="{ rating: 0, temp: 0 }">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $detail->product_id }}">
                                    <input type="hidden" name="rating" :value="rating">
                                    
                                    <div style="margin-bottom: 16px;">
                                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Rating Produk</label>
                                        <div style="display: flex; gap: 8px; cursor: pointer;">
                                            <template x-for="star in 5">
                                                <svg @click="rating = star" @mouseenter="temp = star" @mouseleave="temp = 0" 
                                                     :fill="(temp >= star || rating >= star) ? '#FFC107' : '#ddd'"
                                                     width="32" height="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="none"/>
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 16px;">
                                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Ulasan Anda</label>
                                        <textarea name="review" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none; font-family: inherit;" placeholder="Bagaimana kualitas produk ini?" required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="confirm-btn" style="width: auto; padding: 10px 24px; margin-top: 0; font-size: 14px;">Kirim Ulasan</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column: Summary -->
    <div class="right-col">
        <div class="card">
            <h3 class="card-title">Ringkasan Pesanan</h3>
            
            @foreach($transaction->transactionDetails as $detail)
            <div class="summary-item">
                <img src="{{ asset('storage/' . ($detail->product->thumbnail->image ?? 'images/default-product.png')) }}" class="summary-img" alt="product">
                <div class="summary-info">
                    <div class="store-mini">
                         <img src="{{ asset('images/wtc-logo.png') }}" alt="{{ $detail->product->store->name }}">
                        <span>{{ optional($detail->product->store)->name ?? 'Store' }}</span>
                    </div>
                    <div class="summary-name">{{ $detail->product->name }}</div>
                    <div class="summary-price">{{ $detail->qty }}x Rp{{ number_format($detail->product->price, 0, ',', '.') }}</div>
                </div>
                <div style="font-weight:600; font-size:14px;">
                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach

            <div class="calc-row">
                <span>Subtotal</span>
                <span>Rp{{ number_format($transaction->transactionDetails->sum('subtotal'), 0, ',', '.') }}</span>
            </div>
            <div class="calc-row">
                <span>Biaya Layanan</span>
                <span>Rp 2.000</span>
            </div>
            <div class="calc-row">
                <span>Pengiriman</span>
                <span>Rp{{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="calc-row">
                <span>Pajak (11%)</span>
                <span>Rp{{ number_format($transaction->tax, 0, ',', '.') }}</span>
            </div>

            <div class="total-row">
                <span>Total</span>
                <span class="total-price">Rp{{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>

            @if($transaction->payment_status == 'paid')
                <div class="status-badge success">
                    <span>✓</span> Pembayaran Lunas
                </div>
            @elseif($transaction->proof_of_payment)
                <div class="status-badge pending">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Menunggu Verifikasi
                </div>
                <p style="text-align:center; font-size:13px; color:var(--text-muted); margin-top:12px; line-height:1.5;">
                    Bukti pembayaran Anda telah diterima.<br>Mohon tunggu konfirmasi dari admin.
                </p>
            @else
                <div x-show="!scanned" style="text-align: center; padding: 40px 20px; border: 2px dashed #eee; border-radius: 16px; margin-top: 24px; color: var(--text-muted);">
                    <div style="margin-bottom: 16px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="animation: spin 2s linear infinite; color: var(--accent-pink-text);">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke-opacity="0.3"/>
                            <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <p style="font-weight: 600;">Menunggu Pembayaran...</p>
                    <p style="font-size: 13px; margin-top: 4px;">Sistem sedang mendeteksi scan QR Code anda.</p>
                </div>

                <form x-show="scanned" action="{{ route('transaction.upload_proof', $transaction->id) }}" method="POST" enctype="multipart/form-data" style="margin-top:24px;" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    @csrf
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:15px; font-weight:700; margin-bottom:12px; color:var(--text-main);">Bukti Pembayaran</label>
                        
                        <div class="upload-box" id="uploadArea">
                            <input type="file" id="proof" name="proof_of_payment" accept="image/*" required onchange="updateFileName(this)">
                            <div class="upload-icon-container">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#E06C75" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <div class="upload-text-main" id="uploadTextMain">Klik untuk Upload</div>
                            <div class="upload-text-sub" id="uploadTextSub">Format: JPG, PNG (Max 2MB)</div>
                        </div>
                    </div>
                    <button type="submit" class="confirm-btn">Kirim Bukti Pembayaran</button>
                </form>

                <script>
                    function updateFileName(input) {
                        const box = document.getElementById('uploadArea');
                        const textMain = document.getElementById('uploadTextMain');
                        const textSub = document.getElementById('uploadTextSub');
                        
                        if (input.files && input.files[0]) {
                            const fileName = input.files[0].name;
                            textMain.textContent = fileName;
                            textSub.textContent = "Klik untuk mengganti file";
                            box.style.borderColor = "var(--accent-pink-text)";
                            box.style.background = "#FFF0F3";
                        }
                    }
                </script>
            @endif
        </div>
    </div>
</div>
</x-customer-layout>