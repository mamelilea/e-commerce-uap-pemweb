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

        body {
            background: var(--bg);
            color: var(--teks);
        }

        /* Fix Logo Visibility on Light Theme */
        .brand-logo {
            background: var(--hitam) !important;
            color: var(--putih) !important;
        }

        .cart-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .cart-header {
            margin-bottom: 30px;
        }
        .cart-title {
            font-size: 32px;
            font-weight: 900;
            color: var(--teks);
        }
        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border: 1px solid var(--garis);
            border-radius: 20px;
            margin-bottom: 16px;
            background: var(--panel);
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .cart-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            background: var(--panel2);
        }
        .cart-info {
            flex: 1;
        }
        .cart-name {
            font-weight: 800;
            font-size: 18px;
            color: var(--teks);
            margin-bottom: 4px;
            text-decoration: none;
            display: block;
        }
        .cart-price {
            font-weight: 700;
            color: var(--pink_tua);
        }
        .cart-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .btn-delete {
            background: #ffe5e5;
            color: #d32f2f;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 12px;
            text-transform: uppercase;
        }
        .btn-checkout {
            display: block;
            width: 100%;
            background: var(--hitam);
            color: var(--putih);
            text-align: center;
            padding: 18px;
            border-radius: 16px;
            font-weight: 900;
            text-decoration: none;
            margin-top: 30px;
            font-size: 16px;
            transition: 0.2s;
        }
        .btn-checkout:hover {
            opacity: 0.9;
        }
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }
    </style>

    <div class="cart-container">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('customer.home') }}" style="text-decoration: none; color: var(--teks); font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="cart-header">
            <h1 class="cart-title">Keranjang Belanja</h1>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-weight: 700;">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            @foreach($cartItems as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . ($item->product->thumbnail->image ?? ($item->product->images->first()->image ?? 'images/default-product.png'))) }}" class="cart-img">
                    <div class="cart-info">
                        <a href="{{ route('customer.product.show', $item->product->id) }}" class="cart-name">{{ $item->product->name }}</a>
                        <div class="cart-price">Rp {{ number_format($item->product->price, 0, ',', '.') }} x {{ $item->quantity }}</div>
                    </div>
                    <div class="cart-actions">
                        <a href="{{ route('transaction.show', $item->product->id) }}?quantity={{ $item->quantity }}" style="font-weight: 700; color: var(--hitam); text-decoration: none; font-size: 14px; border: 1px solid var(--garis); padding: 8px 16px; border-radius: 8px;">Beli</a>
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Note: Bulk checkout is complex with multi-store logic, so we keep single-item checkout flow for now via 'Beli' button, or we can add a simple info text -->
            <div style="margin-top: 20px; text-align: center; color: var(--muted2); font-size: 13px;">
                * Klik tombol "Beli" pada produk untuk melanjutkan ke pembayaran.
            </div>

        @else
            <div class="empty-cart">
                <div style="font-size: 48px; margin-bottom: 16px;">🛒</div>
                <h3 style="font-weight: 800; color: var(--teks); margin-bottom: 8px;">Keranjang Kosong</h3>
                <p>Belum ada produk yang ditambahkan.</p>
                <a href="{{ route('customer.home') }}" style="display: inline-block; margin-top: 20px; color: var(--pink-tua); font-weight: 700; text-decoration: none;">Mulai Belanja &rarr;</a>
            </div>
        @endif
    </div>
</x-customer-layout>
