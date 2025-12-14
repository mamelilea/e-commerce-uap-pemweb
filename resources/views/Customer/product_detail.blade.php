<x-customer-layout>

<style>
    /* Menggunakan variabel warna dari Homepage (Light Theme) */
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
        --pink_tua: #d26b6bff;
    }

    /* Style Header agar sama persis dengan Homepage */
    header {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 250, 251, 0.95);
        border-bottom: 1px solid var(--garis);
        backdrop-filter: blur(10px);
    }

    body {
        margin: 0;
        background: var(--bg);
        color: var(--teks);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    main.container {
        margin-top: 32px;
    }

    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 48px;
        align-items: start;
        background-color: var(--panel);
        padding: 30px;
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
        border: 1px solid var(--garis);
        color: var(--teks);
    }
    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 20px;
        }
    }

    .product-photo {
        border-radius: 24px;
        overflow: hidden;
        background: var(--panel2);
        border: 1px solid var(--garis);
    }
    .product-photo img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .product-photo img:hover {
        transform: scale(1.05);
    }

    .product-body {
        padding: 0 12px;
    }
    
    /* Store Info Styles */
    .store-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--garis);
    }
    .store-logo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        background: var(--panel2);
        border: 1px solid var(--garis);
    }
    .store-name-box {
        display: flex;
        flex-direction: column;
    }
    .store-label {
        font-size: 11px;
        text-transform: uppercase;
        color: var(--muted2);
        letter-spacing: 0.5px;
        font-weight: 700;
    }
    .store-name {
        font-weight: 800;
        font-size: 16px;
        color: var(--teks);
    }

    .product-category {
        font-size: 14px;
        color: var(--muted2);
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 8px;
    }
    .product-name {
        font-size: 32px;
        font-weight: 900;
        margin-bottom: 12px;
        color: var(--teks);
    }
    .product-price {
        font-size: 24px;
        font-weight: 800;
        color: var(--teks);
        margin-bottom: 20px;
    }
    .product-description {
        font-size: 16px;
        line-height: 1.6;
        color: var(--muted);
        margin-bottom: 30px;
    }

    .qty-wrapper {
        margin-bottom: 24px;
    }
    .qty-row {
        display: flex; 
        gap: 16px; 
        align-items: center; 
        margin-bottom: 16px;
    }
    .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid var(--garis2);
        padding: 4px;
        border-radius: 12px;
        background: var(--panel);
    }
    .qty-btn {
        background: transparent;
        border: none;
        color: var(--teks);
        width: 32px;
        height: 32px;
        font-weight: 700;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: 0.2s;
    }
    .qty-btn:hover {
        color: var(--pink_tua);
        background: var(--panel2);
        border-radius: 8px;
    }
    .qty-input {
        background: transparent;
        border: none;
        color: var(--teks);
        width: 40px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .qty-stock {
        color: var(--muted2);
        font-size: 14px;
    }

    .action-row {
        display: flex;
        gap: 12px;
    }
    .btn-add-cart {
        width: 100%;
        padding: 16px 0;
        border-radius: 16px;
        border: 1px solid var(--teks);
        background: transparent;
        color: var(--teks);
        font-weight: 900;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-add-cart:hover {
        background: var(--teks);
        color: var(--putih);
    }

    .btn-full {
        display: inline-block;
        width: 100%;
        background-color: var(--teks);
        color: var(--putih);
        font-weight: 900;
        padding: 16px 0;
        border-radius: 16px;
        border: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-full:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .product-reviews {
        margin-top: 40px;
        border-top: 1px solid var(--garis);
        padding-top: 24px;
    }
    .product-reviews h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--teks);
        margin-bottom: 16px;
    }
    .review {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--garis);
        color: var(--muted);
    }
    .review strong {
        color: var(--teks);
        font-weight: 700;
    }
    .review-date {
        font-size: 14px;
        color: var(--muted2);
    }
    .review p {
        margin: 8px 0 0;
        line-height: 1.4;
    }

    /* Force Logo Contrast on Light Theme */
    .brand-logo {
        background: #000000 !important;
        color: #FFFFFF !important;
    }
</style>

<main class="container">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('customer.home') }}" style="text-decoration: none; color: var(--teks); font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="product-detail">
        <div class="product-photo">
            @if($product->thumbnail && $product->thumbnail->image)
            <img src="{{ asset('storage/' . $product->thumbnail->image) }}" alt="{{ $product->name }}">
            @else
            <img src="{{ asset('images/default-product.png') }}" alt="Default product image">
            @endif
        </div>
        <div class="product-body">
            
            <!-- Store Info -->
            <div class="store-info">
                 @if(optional($product->store)->logo)
                    <img src="{{ $product->store->logo == 'wtc-logo.png' ? asset('images/' . $product->store->logo) : asset($product->store->logo) }}" alt="{{ $product->store->name }}" class="store-logo">
                @else
                    <div class="store-logo" style="display:grid; place-items:center; font-weight:bold; color:var(--muted);">
                        {{ substr(optional($product->store)->name ?? 'S', 0, 1) }}
                    </div>
                @endif
                <div class="store-name-box">
                    <span class="store-label">Dijual Oleh</span>
                    <span class="store-name">{{ optional($product->store)->name ?? 'Store' }}</span>
                </div>
            </div>

            <div class="product-category">
                {{ optional($product->category)->name ?? 'Uncategorized' }}
            </div>
            <h1 class="product-name">{{ $product->name }}</h1>
            <div class="product-price">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
            <div class="product-description">
                {{ $product->description }}
            </div>

            <!-- Quantity & Actions -->
            <div class="qty-wrapper">
                <div class="qty-row">
                    <div class="qty-control">
                        <button type="button" id="btn-minus" class="qty-btn">-</button>
                        <input type="number" id="qty-input" class="qty-input" name="quantity" value="1" min="1">
                        <button type="button" id="btn-plus" class="qty-btn">+</button>
                    </div>
                    <span class="qty-stock">Stok Tersedia: {{ $product->stock }}</span>
                </div>

                @if(auth()->check() && auth()->user()->store)
                    <div class="w-full p-4 bg-gray-100 text-gray-500 text-center rounded-xl font-bold border border-gray-200">
                        Anda login sebagai Seller. Halaman ini hanya untuk preview tampilan.
                    </div>
                @else
                    <div class="action-row">
                        <form action="{{ route('cart.store') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="qty-form-input" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart">MASUKKAN KERANJANG</button>
                        </form>
                        
                        <a href="#" onclick="event.preventDefault(); document.getElementById('checkout-form').submit();" class="btn-full" style="flex: 1;">CHECKOUT</a>
                        
                        <form id="checkout-form" action="{{ route('transaction.show', $product->id) }}" method="GET" style="display: none;">
                            <input type="hidden" id="qty-checkout-input" name="quantity" value="1">
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="product-reviews">
            <h2>Ulasan Produk ({{ $product->productReviews->count() }})</h2>

            @forelse ($product->productReviews as $review)
                <div class="review">
                    <strong>{{ $review->transaction->buyer->user->name ?? 'Anonymous' }}</strong> 
                    <span class="review-date"> - {{ $review->created_at->format('d M Y') }}</span>
                    <div style="color: #FFC107; font-size: 14px; margin: 4px 0;">
                        @for($i=1; $i<=5; $i++)
                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <p>{{ $review->review }}</p>
                </div>
            @empty
                <p>Belum ada ulasan untuk produk ini.</p>
            @endforelse
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const qtyInput = document.getElementById('qty-input');
        const qtyFormInput = document.getElementById('qty-form-input');
        const qtyCheckoutInput = document.getElementById('qty-checkout-input');
        const maxStock = {{ $product->stock }};

        function updateHiddenInputs(val) {
            if (qtyFormInput) qtyFormInput.value = val;
            if (qtyCheckoutInput) qtyCheckoutInput.value = val;
        }

        btnMinus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            if(val > 1) {
                val = val - 1;
                qtyInput.value = val;
                updateHiddenInputs(val);
            }
        });

        btnPlus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            if(val < maxStock) {
                val = val + 1;
                qtyInput.value = val;
                updateHiddenInputs(val);
            }
        });

        qtyInput.addEventListener('change', function() {
            let val = parseInt(this.value) || 1;
            if (val < 1) val = 1;
            if (val > maxStock) val = maxStock;
            this.value = val;
            updateHiddenInputs(val);
        });
    });
</script>
</x-customer-layout>
