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
        color: var(--muted);
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
        color: var(--muted);
        font-size: 14px;
    }
    .search input{
        width: 100%;
        padding: 10px 12px 10px 34px;
        border-radius: 18px;
        border: 1px solid var(--garis);
        background: #FFFFFF;
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
        background: transparent;
        border: 1px solid var(--garis);
        color: var(--teks);
    }
    .btn-outline:hover{
        background: var(--panel2);
        border-color: var(--pink-accent);
    }
    .btn-solid{
        background: var(--hitam);
        color: var(--putih);
        border: 1px solid var(--hitam);
    }
    .btn-solid:hover {
        opacity: 0.9;
    }

    .hero{
        padding-top: 24px;
        padding-bottom: 24px;
    }

    .hero-card{
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 32px;
        background: radial-gradient(100% 200% at 0% 0%, #1a1a1a 0%, #000000 100%);
        padding: 32px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 24px 48px -12px rgba(0,0,0,0.5);
    }
    
    @media (min-width: 900px){
        .hero-card{
            grid-template-columns: 1.2fr 0.8fr;
            padding: 48px;
            gap: 48px;
            align-items: center;
        }
    }

    .hero-pill{
        display:inline-flex;
        gap:8px;
        padding:6px 14px;
        font-size:11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border-radius:999px;
        background: rgba(255,255,255,0.05);
        border:1px solid rgba(255,255,255,0.1);
        color: var(--garis);
        margin-bottom: 24px;
        backdrop-filter: blur(4px);
    }
    
    .hero-title{
        margin:0;
        font-size: 42px;
        font-weight: 1000;
        line-height: 0.9;
        color: var(--putih);
        text-transform: uppercase;
        letter-spacing: -1.5px;
    }
    @media(min-width:900px){
        .hero-title{ font-size: 72px; }
    }
    
    .hero-title span{ 
        display: block;
        color: transparent;
        -webkit-text-stroke: 1px rgba(255,255,255,0.3);
    }

    .hero-desc{
        margin-top: 24px;
        color: var(--muted2);
        font-size: 16px;
        line-height: 1.6;
        max-width: 44ch;
        font-weight: 400;
    }
    
    .hero-actions {
        margin-top: 36px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .hero-actions .btn {
        height: 52px;
        padding: 0 28px;
        font-size: 15px;
        border-radius: 99px;
    }
    
    .hero-actions .btn-solid {
        background: var(--putih);
        color: var(--hitam);
        border: 1px solid var(--putih);
        font-weight: 800;
    }
    
    .hero-actions .btn-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255,255,255,0.15);
    }

    .hero-actions .btn-outline {
        background: transparent;
        color: var(--putih);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .hero-actions .btn-outline:hover {
        background: rgba(255,255,255,0.05);
        border-color: var(--putih);
    }

    /* Right Side Visuals */
    .hero-box {
        background: linear-gradient(145deg, #111, #0a0a0a);
        border-radius: 24px;
        border: 1px solid rgba(255,255,255,0.05);
        padding: 20px;
        position: relative;
    }
    
    .hero-box-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 11px;
        font-weight: 700;
        color: #555;
        letter-spacing: 2px;
    }
    
    .mini-tag {
        background: var(--pink-accent);
        color: #000;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 900;
        box-shadow: 0 0 10px rgba(255, 182, 193, 0.4);
    }
    
    .hero-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        aspect-ratio: 16/9;
    }
    
    .hero-tile {
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        transition: 0.3s;
        border: 1px solid transparent;
        overflow: hidden;
        position: relative;
    }
    .hero-tile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .hero-tile:hover {
        border-color: rgba(255,255,255,0.3);
        transform: translateY(-4px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 2;
    }
    .hero-tile:hover img {
        transform: scale(1.1);
    }

    .stamp {
        margin-top: 20px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        padding: 10px 20px;
        background: rgba(0,0,0,0.3);
        color: var(--pink-accent);
        border: 1px solid rgba(255,182,193, 0.15);
        border-radius: 16px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    .section {
        margin-top: 60px;
    }
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        border-bottom: 2px solid var(--garis);
        padding-bottom: 12px;
    }
    .section-title {
        font-size: 20px;
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--teks);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title::before {
        content: '';
        display: block;
        width: 6px;
        height: 24px;
        background: var(--pink-accent);
        border-radius: 4px;
    }
    .section-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--pink-accent);
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 8px;
        background: var(--panel);
        border: 1px solid var(--garis);
        transition: 0.2s;
    }
    .section-link:hover {
        background: var(--panel2);
        color: var(--hitam);
    }
    .chips {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 8px;
        flex-wrap: wrap;
        margin-top: 16px;
    }
    .chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 24px;
        border-radius: 99px;
        border: 1px solid var(--garis);
        background: var(--putih);
        color: var(--muted);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .chip:hover {
        background: var(--panel2);
        color: var(--pink-accent);
        border-color: var(--pink-accent);
        transform: translateY(-1px);
    }
    .chip.active {
        background: var(--hitam);
        color: var(--putih);
        border-color: var(--hitam);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .product-grid{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }
    @media(min-width: 768px){
        .product-grid{ grid-template-columns: repeat(3, 1fr); }
    }
    @media(min-width: 1100px){
        .product-grid{ grid-template-columns: repeat(4, 1fr); }
    }



    .product-photo{
        display:block;
        background:#0E0E0E;
        aspect-ratio:1/1;
    }
    .product-photo img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .empty{
        grid-column:1 / -1;
        text-align:center;
        padding:24px;
        color:var(--muted2);
    }

    footer{
        border-top:1px solid var(--garis);
        padding:18px;
        text-align:center;
        color:var(--muted2);
        font-size:13px;
        margin-top:16px;
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

    .slider-container {
        position: relative;
        max-width: 1120px;
        margin: 24px auto 0;
        border-radius: 28px;
        overflow: hidden;
        aspect-ratio: 21/9;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .slider-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        height: 100%;
    }
    
    .slide {
        min-width: 100%;
        height: 100%;
        position: relative;
    }
    
    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slider-dots {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }
    .slider-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        cursor: pointer;
        transition: 0.3s;
    }
    .slider-dot.active {
        background: #FFF;
        transform: scale(1.2);
    }
</style>

<main>

    <div class="container">
        @if(auth()->check() && auth()->user()->store)
            <div style="background: #F8B444; color: #000; padding: 12px; border-radius: 12px; font-weight: 700; text-align: center; margin-bottom: 24px; border: 1px solid #E6A539;">
                <span>Anda login sebagai Seller. Halaman ini hanya untuk preview tampilan.</span>
            </div>
        @endif

        <div class="slider-container">
            <div class="slider-track" id="sliderTrack">
                <div class="slide">
                    <img src="{{ asset('images/banner-sale.jpg') }}" alt="Sale Banner">
                </div>
                <div class="slide">
                    <img src="{{ asset('images/banner-collection.jpg') }}" alt="Collection Banner">
                </div>
            </div>
            
            <div class="slider-dots" id="sliderDots">
                <div class="slider-dot active" data-index="0"></div>
                <div class="slider-dot" data-index="1"></div>
            </div>
        </div>
    </div>

    <section class="container hero">
        <div class="hero-card">
            <div>
                <div class="hero-pill">early-2000s spirit • bold monochrome • glitchy</div>
                <h1 class="hero-title">Y2K <span>ACCESSORIES DROP</span></h1>
                <p class="hero-desc">
                    Our accessory focus: ring, necklace, sunglasses, bracelet & charms.
                </p>
                <div class="hero-actions">
                    <a class="btn btn-solid" href="#produk">Shop Now</a>
                    <a class="btn btn-outline" href="#new">New Arrivals</a>
                </div>
            </div>

            <div>
                <div class="hero-box">
                    <div class="hero-box-top">
                        <span>FEATURED</span>
                        <span class="mini-tag">LIMITED</span>
                    </div>
                    <div class="hero-grid">
                        @foreach($products->take(6) as $item)
                        @php
                            $hImg = null;
                            if ($item->thumbnail && !empty($item->thumbnail->image)) {
                                $hImg = $item->thumbnail->image;
                            } elseif ($item->images && $item->images->first()) {
                                $hImg = $item->images->first()->image;
                            }
                            $hUrl = $hImg ? asset('storage/'.$hImg) : null;
                        @endphp
                        <div class="hero-tile">
                            @if($hUrl)
                                <img src="{{ $hUrl }}" alt="Product">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="stamp">⚡ Drop terbaru minggu ini</div>
            </div>
        </div>
    </section>

    <section class="container section">
        <div class="section-head">
            <h2 class="section-title">Kategori</h2>
            <a class="section-link" href="{{ route('customer.home') }}">Reset</a>
        </div>

        <div class="chips">
            <a class="chip {{ request('category') ? '' : 'active' }}" href="{{ route('customer.home') }}">Semua</a>

            @foreach($categories as $cat)
                <a class="chip {{ (string)request('category') === (string)$cat->id ? 'active' : '' }}"
                   href="{{ route('customer.home', ['category' => $cat->id]) }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </section>

    <section id="produk" class="container section">
        <div class="section-head">
            <h2 class="section-title">Trending Accessories</h2>
        </div>

        <div class="product-grid">
            @forelse($products as $product)
                @php
                    $imgPath = null;
                    if ($product->thumbnail && !empty($product->thumbnail->image)) {
                        $imgPath = $product->thumbnail->image;
                    } elseif ($product->images && $product->images->first()) {
                        $imgPath = $product->images->first()->image;
                    }

                    $imgUrl = $imgPath ? asset('storage/'.$imgPath) : null;
                @endphp

                <article class="product-card">
                    <a class="product-photo" href="{{ url('/products/'.$product->id) }}">
                        @if($imgUrl)
                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                        @else
                            <div class="no-photo">No Image</div>
                        @endif
                    </a>

                    <div class="product-body">
                        <div class="product-category">{{ optional($product->category)->name ?? 'Uncategorized' }}</div>
                        <div class="product-name">{{ $product->name }}</div>

                        <div class="product-row">
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>

                        <a class="btn btn-solid btn-full" href="{{ url('/products/'.$product->id) }}">Detail →</a>
                    </div>
                </article>
            @empty
                <div class="empty">Produk tidak ditemukan.</div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </section>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('sliderTrack');
        const dots = document.querySelectorAll('.slider-dot');
        const slideCount = dots.length;
        let currentIndex = 0;
        
        function updateSlider(index) {
            track.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
            currentIndex = index;
        }

        setInterval(() => {
            let nextIndex = (currentIndex + 1) % slideCount;
            updateSlider(nextIndex);
        }, 5000);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                updateSlider(index);
            });
        });
    });
</script>

</x-customer-layout>