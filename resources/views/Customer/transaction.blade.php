<x-customer-layout>
<style>
    :root{
        --bg: #FDFBF7;
        --panel: #FFFFFF;
        --panel2: #F3F1ED;
        --garis: #E6E4DF;
        --garis2: #D1D1D1;
        --teks: #1A1A1A;
        --muted: #666666;
        --putih: #FFFFFF;
        --hitam: #000000;
        --pink: #f0bbbbff;
        --pink-tua: #d26b6bff;
        --pink-light: #ffafc4ff;
    }
    * { box-sizing: border-box; }
    body, html {
        margin: 0;
        background: var(--bg);
        color: var(--teks);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        min-height: 100vh;
    }
    header {
        position: sticky;
        top: 0;
        background: var(--bg);
        border-bottom: 1px solid var(--garis);
        padding: 12px 20px;
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
        color: var(--teks);
        text-decoration: none;
    }
    .brand-logo {
        width: 38px;
        height: 38px;
        background: var(--hitam);
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-weight: 900;
        color: var(--putih);
        font-size: 18px;
    }
    
    main.container {
        max-width: 1120px;
        margin: 40px auto;
        padding: 0 20px;
    }

    h1.page-title {
        font-size: 32px;
        font-weight: 900;
        margin-bottom: 30px;
        color: var(--hitam);
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 30px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background: var(--hitam);
        border-radius: 20px;
        padding: 30px;
        color: var(--putih);
        margin-bottom: 30px;
        border: 1px solid #222;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        border-bottom: 1px solid #333;
        padding-bottom: 16px;
    }
    .step-number {
        background: var(--putih);
        color: var(--hitam);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 14px;
    }
    .card-title {
        font-size: 18px;
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #ccc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    input, textarea, select {
        width: 100%;
        padding: 14px 16px;
        border-radius: 12px;
        background: #111;
        border: 1px solid #333;
        color: var(--putih);
        font-size: 15px;
        font-family: inherit;
        outline: none;
        transition: all 0.2s;
        color-scheme: dark;
    }
    input:focus, textarea:focus, select:focus {
        border-color: var(--putih);
        background: #000;
    }
    
    /* Fix Autofill Background & Text Color */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 1000px #111 inset !important;
        -webkit-text-fill-color: white !important;
        caret-color: white !important;
        color-scheme: dark;
        transition: background-color 5000s ease-in-out 0s;
    }
    textarea { min-height: 100px; resize: vertical; }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .order-item {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #111;
        border-radius: 16px;
        border: 1px solid #333;
    }
    .order-img {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        background: #222;
    }
    .order-info {
        flex: 1;
    }
    .order-name {
        font-weight: 800;
        font-size: 16px;
        margin-bottom: 4px;
        color: var(--putih);
    }
    .order-price {
        font-weight: 700;
        color: var(--pink);
        font-size: 14px;
    }

    .summary-card {
        position: sticky;
        top: 100px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        color: #ccc;
    }
    .summary-row.total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #333;
        font-weight: 900;
        font-size: 20px;
        color: var(--pink);
    }
    
    .process-btn {
        width: 100%;
        background: var(--pink);
        color: var(--hitam);
        padding: 18px;
        border-radius: 14px;
        border: none;
        font-weight: 900;
        font-size: 16px;
        cursor: pointer;
        margin-top: 24px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.2s;
    }
    .process-btn:hover {
        background: var(--pink-tua);
        transform: translateY(-2px);
    }

    .text-danger { color: #ff6b6b; font-size: 12px; margin-top: 4px; display: block; }
    .flash-success {
        background: #22c55e;
        color: white;
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .qty-control {
        display: flex; 
        align-items: center; 
        gap: 10px; 
        margin-top: 8px;
    }
    .qty-btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid #333;
        background: #222;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: monospace;
        transition: 0.2s;
    }
    .qty-btn:hover {
        background: #333;
        color: var(--pink);
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
        font-size: 12px; 
        color: #aaa; 
        font-weight: 600; 
        text-transform: uppercase; 
    }
</style>

<div class="header-bar" style="display:none;"></div>

<main class="container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('customer.product.show', $product->id) }}" style="text-decoration: none; color: var(--teks); font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>

    <h1 class="page-title">Checkout</h1>

    @if(session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('transaction.process') }}" method="POST" class="checkout-layout">
        @csrf
        <input type="hidden" name="store_id" value="{{ $product->store_id }}">
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <input type="hidden" name="quantity" value="{{ request('quantity', 1) }}">

        <div class="left-column">

            <div class="card">
                <div class="card-header">
                    <div class="step-number">1</div>
                    <h2 class="card-title">Alamat Pengiriman</h2>
                </div>
                
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="fullname" placeholder="Masukkan nama lengkap Anda" value="{{ old('fullname') }}" required>
                    @error('fullname') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap *</label>
                    <textarea name="address" placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Kota *</label>
                        <input type="text" name="city" placeholder="Kota" value="{{ old('city') }}" required>
                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Kode Pos *</label>
                        <input type="text" name="postal_code" placeholder="Kode Pos" value="{{ old('postal_code') }}" required>
                        @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                 <div class="form-group">
                    <label>Jenis Pengiriman *</label>
                    <select name="shipping_type" required>
                        <option value="" disabled selected>Pilih pengiriman</option>
                        <option value="reguler">Reguler (Rp 10.000)</option>
                        <option value="express">Express (Rp 25.000)</option>
                        <option value="same_day">Same Day (Rp 50.000)</option>
                    </select>

                     @error('shipping_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="card">
                 <div class="card-header">
                    <div class="step-number">2</div>
                    <h2 class="card-title">Detail Pesanan</h2>
                </div>

                <div class="order-item">
                    <img src="{{ asset('storage/' . ($product->thumbnail->image ?? ($product->images->first()->image ?? 'images/default-product.png'))) }}" alt="{{ $product->name }}" class="order-img">
                    <div class="order-info">
                        <div class="store-mini">
                                <img src="{{ asset('images/wtc-logo.png') }}" alt="{{ $product->store->name }}">
                            <span>{{ optional($product->store)->name ?? 'Store' }}</span>
                        </div>
                        <div class="order-name">{{ $product->name }}</div>
                        <div class="order-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="qty-control">
                            <button type="button" class="qty-btn" id="qty-minus">-</button>
                            <span id="qty-display" style="font-weight:700;">{{ request('quantity', 1) }}</span>
                            <button type="button" class="qty-btn" id="qty-plus">+</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="right-column">
            <div class="card summary-card">
                 <div class="card-header" style="border:none; padding:0; margin-bottom:20px;">
                    <h2 class="card-title">Ringkasan Pesanan</h2>
                </div>
                
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <span id="subtotal-display">Rp {{ number_format($product->price * request('quantity', 1), 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Biaya Layanan</span>
                    <span>Rp 2.000</span>
                </div>
                <div class="summary-row">
                    <span>Pengiriman</span>
                    <span id="shipping-display">-</span> 
                </div>
                <div class="summary-row">
                    <span>Pajak (11%)</span>
                    <span id="tax-display">Rp 0</span>
                </div>

                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span id="total-price">Rp {{ number_format(($product->price * request('quantity', 1)) + 2000, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="process-btn">Buat Pesanan</button>
            </div>
        </div>
    </form>
</main>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingSelect = document.querySelector('select[name="shipping_type"]');
        const shippingDisplay = document.getElementById('shipping-display');
        const totalDisplay = document.getElementById('total-price');
        const subtotalDisplay = document.getElementById('subtotal-display');
        const qtyInput = document.querySelector('input[name="quantity"]');
        const qtyDisplay = document.getElementById('qty-display');
        const btnMinus = document.getElementById('qty-minus');
        const btnPlus = document.getElementById('qty-plus');
        const productPrice = {{ $product->price }};
        const serviceFee = 2000;
        const maxStock = {{ $product->stock }};
        let currentQty = parseInt(qtyInput.value) || 1;
        let currentShippingCost = 0;
        const shippingCosts = {
            'reguler': 10000,
            'express': 25000,
            'same_day': 50000
        };

        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        const taxDisplay = document.getElementById('tax-display');

        function updateTotals() {
            const subtotal = productPrice * currentQty;
            const tax = subtotal * 0.11;
            const grandTotal = subtotal + serviceFee + currentShippingCost + tax;
            qtyDisplay.textContent = currentQty;
            qtyInput.value = currentQty;
            subtotalDisplay.textContent = formatRupiah(subtotal);
            taxDisplay.textContent = formatRupiah(tax);
            totalDisplay.textContent = formatRupiah(grandTotal);
        }

        shippingSelect.addEventListener('change', function() {
            const selectedType = this.value;
            currentShippingCost = shippingCosts[selectedType] || 0;
            
            if (currentShippingCost > 0) {
                shippingDisplay.textContent = formatRupiah(currentShippingCost);
            } else {
                shippingDisplay.textContent = '-';
            }
            
            updateTotals();
        });

        btnMinus.addEventListener('click', function() {
            if (currentQty > 1) {
                currentQty--;
                updateTotals();
            }
        });

        btnPlus.addEventListener('click', function() {
            if (currentQty < maxStock) {
                currentQty++;
                updateTotals();
            }
        });
    });
</script>

</x-customer-layout>