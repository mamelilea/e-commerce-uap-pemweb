<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Techly</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>
<body>

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

                    <a href="{{ route('product.detail', $product->slug) }}" class="nav-link cart-link" style="background: #00d4ff; color: white; padding: 8px 16px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                        <span class="cart-icon">🛒</span> Keranjang
                        <span class="cart-count">({{ $qty }})</span>
                    </a>

                    @auth
                        <a href="{{ route('history.index') }}" class="nav-link">Riwayat</a>
                        <!-- NAV PROFILE -->
                        <div class="nav-profile" id="navProfile" style="margin-left: 15px; cursor: pointer; position: relative;">
                            <img src="{{ asset('img/user-icon.svg') }}" alt="Profile" class="profile-icon" style="width: 32px; height: 32px;" />
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link nav-login" style="margin-left: 15px;">
                            Login
                        </a>
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
            <span class="breadcrumb-item active">Checkout</span>
        </div>
    </div>

    <section class="checkout container">
        <h2 class="checkout-title">Checkout Pesanan</h2>

        <div class="checkout-wrapper">

            <!-- FORM KIRI -->
            <div class="checkout-card checkout-left">

                <h3>Informasi Pengiriman</h3>

                @if ($errors->any())
                    <div class="alert-error">
                        <p><strong>Harap isi semua field yang wajib.</strong></p>
                    </div>
                @endif

                <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="{{ $qty }}">

                    <div class="form-group">
                        <label>Nama Lengkap <span>*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required>
                    </div>

                    <div class="form-group">
                        <label>No. Telepon <span>*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap <span>*</span></label>
                        <textarea name="alamat" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Kota <span>*</span></label>
                        <input type="text" name="kota" value="{{ old('kota') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Kode Pos <span>*</span></label>
                        <input type="text" name="kodepos" value="{{ old('kodepos') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Metode Pengiriman</label>
                        <select name="pengiriman" id="pengiriman" required>
                            <option value="reguler" data-cost="15000">Reguler (Rp 15.000)</option>
                            <option value="express" data-cost="25000">Express (Rp 25.000)</option>
                            <option value="same-day" data-cost="35000">Same Day (Rp 35.000)</option>
                        </select>
                    </div>

                    <h3>Metode Pembayaran</h3>

                    <label class="payment-method">
                        <input type="radio" name="payment" value="bank" required>
                        <div>
                            <strong>Transfer Bank</strong>
                            <p>BRI, BCA, Mandiri, BNI</p>
                        </div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment" value="kartu">
                        <div>
                            <strong>Kartu Kredit/Debit</strong>
                            <p>Visa, Mastercard</p>
                        </div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment" value="ewallet">
                        <div>
                            <strong>Dompet Digital</strong>
                            <p>GoPay, OVO, DANA</p>
                        </div>
                    </label>

                    <label class="payment-method">
                        <input type="radio" name="payment" value="cod">
                        <div>
                            <strong>Cash on Delivery (COD)</strong>
                        </div>
                    </label>

                    <div class="security-box" style="display: flex; align-items: center; justify-content: center; gap: 10px; background: #e6fffa; border: 1px solid #b2f5ea; color: #2c7a7b; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span style="font-weight: 500; font-size: 14px;">Pembayaran Aman • Data Anda Terenkripsi</span>
                    </div>

                    <button type="submit" class="btn-pay">Bayar Sekarang</button>

                    <p class="policy-links">
                        Dengan melanjutkan, Anda menyetujui
                        <a href="/kebijakan-pengembalian">Kebijakan Pengembalian</a>
                        dan
                        <a href="/syarat-ketentuan">Syarat & Ketentuan</a>.
                    </p>
                </form>
            </div>

            <!-- RINGKASAN KANAN -->
            <div class="checkout-card checkout-right">

                <h3>Ringkasan Pesanan</h3>

                <div class="product-summary">
                    <img src="{{ asset($product->productImages->first()->image ?? 'img/products/default-product.png') }}" alt="Produk">
                    <div class="product-info">
                        <h4>{{ $product->name }}</h4>
                        <div style="font-size: 14px; color: #666; margin-bottom: 5px;">Jumlah: <strong>{{ $qty }}</strong></div>
                        <p class="price-text">Rp {{ number_format($product->price * $qty,0,',','.') }}</p>
                    </div>
                </div>

                <div class="total-section">
                    <div class="total-line">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($product->price * $qty,0,',','.') }}</span>
                    </div>
                    <div class="total-line">
                        <span>Ongkir</span>
                        <span id="ongkir">Rp 15.000</span>
                    </div>
                    <div class="total-line">
                        <strong>Total</strong>
                        <strong id="total">Rp {{ number_format(($product->price * $qty) + 15000,0,',','.') }}</strong>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('components.footer')

    <script>
        const pengiriman = document.getElementById("pengiriman");
        const ongkirText = document.getElementById("ongkir");
        const totalText = document.getElementById("total");
        const subtotal = {{ $product->price * $qty }};

        pengiriman.addEventListener("change", () => {
            const cost = parseInt(pengiriman.selectedOptions[0].dataset.cost);
            ongkirText.textContent = "Rp " + cost.toLocaleString();
            totalText.textContent = "Rp " + (subtotal + cost).toLocaleString();
        });
    </script>

</body>
</html>
