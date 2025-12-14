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
        --muted2: #888888;
        --putih: #FFFFFF;
        --hitam: #000000;
    }

    *{ box-sizing: border-box; }
    html,body{ height: 100%; }
    body{
        margin: 0;
        background: var(--bg);
        color: var(--teks);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    .container{
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 16px;
    }

    header{
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 250, 251, 0.95);
        border-bottom: 1px solid var(--garis);
        backdrop-filter: blur(10px);
    }

    .header-bar{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 12px 0;
    }

    .brand{
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: var(--teks);
    }
    .brand-logo{
        width: 38px;
        height: 38px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: var(--hitam);
        color: var(--putih);
        font-weight: 900;
        letter-spacing: .5px;
    }
    .brand-name{
        font-weight: 900;
        line-height: 1.1;
    }
    .brand-tag{
        font-size: 12px;
        color: var(--muted2);
        margin-top: 2px;
    }

    .search{
        display: none;
        flex: 1;
        max-width: 520px;
        position: relative;
    }
    .search-icon{
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted2);
        font-size: 14px;
    }
    .search input{
        width: 100%;
        padding: 10px 12px 10px 34px;
        border-radius: 18px;
        border: 1px solid var(--garis);
        background: var(--panel);
        color: var(--teks);
        outline: none;
    }

    @media (min-width: 768px){
        .search{ display: block; }
    }

    .btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 16px;
        text-decoration: none;
        font-weight: 800;
        font-size: 14px;
    }
    .btn-outline{
        background: var(--panel);
        border: 1px solid var(--garis);
        color: var(--teks);
    }
    .btn-outline:hover{
        background: var(--panel2);
    }
    .btn-solid{
        background: var(--putih);
        color: var(--hitam);
        border: 1px solid #EAEAEA;
    }

    .section{
        margin-top: 32px;
    }
    .section-head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }
    .section-title{
        font-size: 28px;
        font-weight: 900;
        color: var(--teks);
    }
    .section-link{
        color: var(--muted);
        text-decoration: none;
        font-size: 14px;
    }
    .section-link:hover{
        color: var(--teks);
    }

    .chips{
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .chip{
        padding: 8px 14px;
        border-radius: 999px;
        background: var(--panel);
        border: 1px solid var(--garis);
        color: var(--muted);
        text-decoration: none;
        font-size: 14px;
        transition: .2s;
    }
    .chip.active{
        background: var(--putih);
        color: var(--hitam);
    }
    .chip:hover{
        background: var(--panel2);
    }

    .product-grid{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:14px;
    }
    @media(min-width:768px){
        .product-grid{ grid-template-columns:repeat(3,1fr);}
    }
    @media(min-width:1100px){
        .product-grid{ grid-template-columns:repeat(4,1fr);}
    }

    .product-card{
        border:1px solid var(--garis);
        background: linear-gradient(180deg, #161616, #0E0E0E);
        border-radius:22px;
        overflow:hidden;
        transition:.25s ease;
        position:relative;
    }
    .product-card:hover{
        border-color:#444;
        background:linear-gradient(180deg, #1B1B1B, #0D0D0D);
        transform:translateY(-4px);
        box-shadow:0 12px 28px rgba(0,0,0,0.35);
    }

    .product-photo{
        display:block;
        width:100%;
        aspect-ratio:1/1;
        background:#0F0F0F;
        border-bottom:1px solid #1E1E1E;
        overflow:hidden;
    }
    .product-photo img{
        width:100%;
        height:100%;
        object-fit:cover;
        transition:0.4s ease;
    }
    .product-card:hover .product-photo img{
        transform:scale(1.06);
    }

    .product-body{
        padding:16px 18px 20px;
    }
    .product-category{
        font-size:12px;
        color:var(--muted2);
        text-transform:uppercase;
        letter-spacing:.5px;
        margin-bottom:4px;
    }
    .product-name{
        font-size:16px;
        font-weight:700;
        margin-bottom:8px;
        color:var(--putih);
    }
    .product-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:12px;
    }
    .product-price{
        font-size:17px;
        font-weight:800;
        color:var(--putih);
    }
    .btn-full{
        display:block;
        width:100%;
        text-align:center;
        margin-top:8px;
        border-radius:14px;
        padding:10px 0;
        transition:.2s;
    }
    .btn-full:hover{
        transform:translateY(-2px);
    }

    .empty{
        grid-column:1 / -1;
        text-align:center;
        padding:24px;
        color:var(--muted2);
    }

    .pagination{
        margin-top: 32px;
        display: flex;
        justify-content: center;
    }

    footer{
        border-top:1px solid var(--garis);
        padding:18px;
        text-align:center;
        color:var(--muted2);
        font-size:13px;
        margin-top:16px;
    }

    /* Filter tambahan untuk search (opsional) */
    .filter-row{
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .filter-input{
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid var(--garis);
        background: var(--panel);
        color: var(--teks);
        font-size: 14px;
    }
</style>

<main>
    <section class="container section">
        {{-- SEARCH TITLE --}}
        <div class="section-head">
            <h2 class="section-title">Hasil Pencarian: “{{ $keyword }}”</h2>
            <div style="color: var(--muted2); font-size: 14px;">
                {{ $products->total() }} produk ditemukan
            </div>
        </div>

        {{-- FILTER OPSIONAL (untuk nilai tambah) --}}
        <form class="filter-row" action="{{ route('customer.search') }}" method="GET">
            <input type="hidden" name="q" value="{{ $keyword }}">
            <input class="filter-input" type="number" name="min_price" placeholder="Harga Min" value="{{ request('min_price') }}">
            <input class="filter-input" type="number" name="max_price" placeholder="Harga Max" value="{{ request('max_price') }}">
            <select class="filter-input" name="sort">
                <option value="">Urutkan</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
            </select>
            <button class="btn btn-solid" type="submit">Filter</button>
        </form>

        {{-- PRODUCT GRID --}}
        <div class="product-grid">
            @forelse($products as $product)
                @php
                    $imgPath = $product->thumbnail->image 
                        ?? ($product->images->first()->image ?? null);
                    $imgUrl = $imgPath ? asset('storage/'.$imgPath) : asset('images/default-product.png');
                @endphp

                <article class="product-card">
                    <a class="product-photo" href="{{ url('/products/'.$product->id) }}">
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                    </a>

                    <div class="product-body">
                        <div class="product-category">
                            {{ optional($product->category)->name ?? 'Uncategorized' }}
                        </div>

                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        <div class="product-row">
                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <a class="btn btn-solid btn-full" href="{{ url('/products/'.$product->id) }}">
                            Detail →
                        </a>
                    </div>
                </article>
            @empty
                <div class="empty">Produk tidak ditemukan untuk "{{ $keyword }}". Coba kata kunci lain.</div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </section>
</main>

<footer>
    © {{ date('Y') }} Y2K Accessories — IMUPP
</footer>

</x-customer-layout>