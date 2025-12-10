<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Techly | Gadget & Elektronik Terbaru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/landingpage/home.css') }}" />
</head>

<body>
    {{-- ================= HEADER + HERO (GUEST) ================= --}}
    @guest
        <header class="main-header">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('uploads/weblogo.png') }}" alt="Techly" class="logo-img" />
                    </a>
                    <nav class="nav-menu">
                        <a href="#products" class="nav-link">Produk</a>
                        <a href="#categories" class="nav-link">Kategori</a>
                        <a href="#about" class="nav-link">Tentang</a>

                        <a href="{{ route('checkout.index') }}" class="nav-link cart-link">
                            <span class="cart-icon">🛒</span> Keranjang
                            <span class="cart-count">(0)</span>
                        </a>
                        <a href="{{ route('login') }}" class="nav-link nav-login">
                            <span class="login-icon"></span>Login
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <section class="hero-section">
            <div class="hero-background"></div>
            <div class="container hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Upgrade Gadgetmu<br />
                        <span class="gradient-text">Hidup Lebih Smart!</span>
                    </h1>
                    <p class="hero-subtitle">
                        Dapatkan inovasi elektronik terbaru dengan teknologi mutakhir, harga kompetitif, dan garansi resmi,
                        hanya di sini.
                    </p>
                    <div class="hero-buttons hero-buttons-guest">
                        <div class="top-buttons">
                            <a href="{{ route('register') }}" class="btn btn-primary">📝 Daftar Sekarang</a>
                            <a href="#products" class="btn btn-primary">Lihat Produk</a>
                        </div>
                        <a href="#categories" class="btn btn-secondary btn-middle">Jelajahi Kategori</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="floating-card card-1">📱 Smartphone</div>
                    <div class="floating-card card-2">💻 Laptop</div>
                    <div class="floating-card card-3">🎧 Audio</div>
                    <div class="floating-card card-4">🔌 Aksesoris</div>
                </div>
            </div>
        </section>
    @endguest

    {{-- ================= HEADER + HERO (AUTH) ================= --}}
    @auth
        <header class="main-header">
            <div class="container">
                <div class="header-content">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('uploads/weblogo.png') }}" alt="Techly" class="logo-img" />
                    </a>
                    <nav class="nav-menu">
                        <a href="#products" class="nav-link">Produk</a>
                        <a href="#categories" class="nav-link">Kategori</a>
                        <a href="#about" class="nav-link">Tentang</a>
                        <a href="{{ route('history.index') }}" class="nav-link">Riwayat</a>

                        <a href="{{ route('checkout.index') }}" class="nav-link cart-link">
                            <span class="cart-icon">🛒</span> Keranjang
                            <span class="cart-count">(0)</span>
                        </a>
                        <!-- NAV PROFILE -->
                        <div class="nav-profile" id="navProfile">
                            <img src="{{ asset('img/user-icon.svg') }}" alt="Profile" class="profile-icon" />
                            <div class="profile-dropdown" id="profileDropdown">
                                <a href="{{ route('profile.edit') }}">Profile</a>

                                {{-- Kalau user BELUM punya toko → tampilkan "Buka Toko" --}}
                                @if (!auth()->user()->store)
                                    <a href="{{ route('seller.store.create') }}">Buka Toko</a>
                                @endif

                                {{-- (Optional) kalau sudah punya & sudah verified → tombol ke dashboard seller --}}
                                @if (auth()->user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}">Dashboard Seller</a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <section class="hero-section">
            <div class="hero-background"></div>
            <div class="container hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Upgrade Gadgetmu<br />
                        <span class="gradient-text">Hidup Lebih Smart!</span>
                    </h1>
                    <p class="hero-subtitle">
                        Dapatkan inovasi elektronik terbaru dengan teknologi mutakhir, harga kompetitif, dan garansi resmi,
                        hanya di sini.
                    </p>
                    <div class="hero-buttons hero-buttons-auth">
                        <div class="top-buttons">
                            <a href="#products" class="btn btn-primary">🔍 Lihat Produk</a>
                        </div>
                        <a href="#categories" class="btn btn-secondary btn-middle">📂 Jelajahi Kategori</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="floating-card card-1">📱 Smartphone</div>
                    <div class="floating-card card-2">💻 Laptop</div>
                    <div class="floating-card card-3">🎧 Audio</div>
                    <div class="floating-card card-4">🔌 Aksesoris</div>
                </div>
            </div>
        </section>
    @endauth

    {{-- ================= SECTION PRODUCTS (SAMA UNTUK GUEST & AUTH) ================= --}}
    <section id="products" class="product-list-section">
        <div class="container">
            <div class="section-header">
                <h2>Temukan Gadget Favoritmu</h2>
                <p class="section-subtitle">
                    Jelajahi berbagai pilihan produk berkualitas dengan harga terbaik
                </p>
            </div>

            <div class="products-toolbar">
                <div class="toolbar-left">
                    <div class="search-input-wrapper">
                        <input id="searchInput" class="input-search" type="search" placeholder="Cari produk..."
                            aria-label="Cari produk" onkeyup="filterProducts()" />
                    </div>
                </div>

                <div class="toolbar-right">
                    <select id="filterCategory" class="select-sort" onchange="filterProducts()">
                        <option value="">Semua Kategori</option>
                        @foreach (\App\Models\ProductCategory::all() as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select id="sortSelect" class="select-sort" onchange="sortProducts()">
                        <option value="">Urutkan: Terpopuler</option>
                        <option value="price-asc">Harga: Rendah → Tinggi</option>
                        <option value="price-desc">Harga: Tinggi → Rendah</option>
                        <option value="newest">Terbaru</option>
                    </select>
                </div>
            </div>

            <div id="productGrid" class="product-grid">
                @forelse($products as $product)
                    <div class="bs-card" data-name="{{ strtolower($product->name) }}"
                        data-category="{{ $product->productCategory->slug }}" data-price="{{ $product->price }}"
                        data-created="{{ $product->created_at->toIso8601String() }}">
                        <div class="bs-image">
                            @php
                                $thumb = $product->productImages->first();
                            @endphp
                            <img src="{{ $thumb ? asset($thumb->image) : asset('img/products/default-product.png') }}"
                                alt="{{ $product->name }}">
                            <span class="bs-category">{{ $product->productCategory->name }}</span>
                        </div>
                        <div class="bs-content">
                            <div class="bs-name">{{ $product->name }}</div>
                            <div class="bs-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="bs-rating">
                                ★★★★☆ <span style="font-size:12px; color:#666;">(123 Terjual)</span>
                            </div>
                            <a href="{{ route('product.detail', $product->slug) }}"
                                class="btn btn-add-cart btn-detail-bs">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada produk tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= SCRIPT PRODUCTS (ATAS) ================= --}}
    <script>
        function filterProducts() {
            const search = document.getElementById('searchInput').value.toLowerCase().trim();
            const category = document.getElementById('filterCategory').value.toLowerCase().trim();
            const cards = document.querySelectorAll('#productGrid .bs-card');

            cards.forEach(card => {
                const name = (card.getAttribute('data-name') || '').toLowerCase();
                const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
                const matchesSearch = !search || name.includes(search) || cardCategory.includes(search);
                const matchesCategory = !category || cardCategory === category;

                card.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
            });
        }

        function sortProducts() {
            const sort = document.getElementById('sortSelect').value;
            const grid = document.getElementById('productGrid');
            const cards = Array.from(grid.querySelectorAll('.bs-card'));

            cards.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                const dateA = new Date(a.getAttribute('data-created'));
                const dateB = new Date(b.getAttribute('data-created'));


                switch (sort) {
                    case 'price-asc':
                        return priceA - priceB;
                    case 'price-desc':
                        return priceB - priceA;
                    case 'newest':
                        return dateB - dateA;
                    default:
                        return 0;
                }
            });

            cards.forEach(card => grid.appendChild(card));
        }
    </script>

    {{-- ================= SECTION CATEGORIES ================= --}}
    <section id="categories" class="category-section">
        <div class="container">

            <div class="section-header">
                <h2>Telusuri Kategori</h2>
                <p class="section-subtitle">Temukan produk sesuai kebutuhan Anda</p>
            </div>

            <div class="category-top-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" fill="none" />
                        <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"
                            fill="none" />
                    </svg>
                    <input id="categorySearch" class="input-search" type="search"
                        placeholder="Cari kategori atau produk..." aria-label="Cari kategori atau produk">
                </div>

                <select id="filterCategoryRight" class="select-sort">
                    <option value="">Semua Kategori</option>
                    <option value="smartphone">Smartphone</option>
                    <option value="laptop">Laptop</option>
                    <option value="audio">Audio</option>
                    <option value="aksesoris">Aksesoris</option>
                </select>

                <div class="price-filter-group">
                    <input id="minPrice" type="number" placeholder="Min: Rp" class="price-input" min="0">
                    <span class="separator">-</span>
                    <input id="maxPrice" type="number" placeholder="Max: Rp" class="price-input" min="0">
                    <button id="filterPriceBtn" class="btn btn-primary">Terapkan</button>
                </div>
            </div>

            <div class="category-grid">
                <div class="category-card" data-slug="smartphone">
                    <div class="category-img">
                        <img src="{{ asset('uploads/hp.svg') }}" alt="Smartphone">
                    </div>
                    <h3>Smartphone</h3>
                    <p>Ponsel pintar terbaru</p>
                </div>

                <div class="category-card" data-slug="laptop">
                    <div class="category-img">
                        <img src="{{ asset('uploads/laptop.svg') }}" alt="Laptop">
                    </div>
                    <h3>Laptop</h3>
                    <p>Komputer portable bertenaga</p>
                </div>

                <div class="category-card" data-slug="audio">
                    <div class="category-img">
                        <img src="{{ asset('uploads/audio.svg') }}" alt="Audio">
                    </div>
                    <h3>Audio</h3>
                    <p>Headphone & speaker premium</p>
                </div>

                <div class="category-card" data-slug="aksesoris">
                    <div class="category-img">
                        <img src="{{ asset('uploads/aksesoris.svg') }}" alt="Aksesoris">
                    </div>
                    <h3>Aksesoris</h3>
                    <p>Perlengkapan & aksesori gadget</p>
                </div>
            </div>

            <div id="category-products" class="product-grid"></div>
        </div>
    </section>

    {{-- ================= ABOUT ================= --}}
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h2>Apa itu Techly?</h2>
                    <p>
                        Techly didirikan oleh sekelompok Mahasiswa Fakultas Ilmu Komputer
                        Universitas Brawijaya dengan tujuan membuat gadget berkualitas
                        lebih mudah diakses oleh semua orang. Kami memilih produk resmi
                        dan tepercaya, menjaga harga kompetitif, serta menempatkan layanan
                        pelanggan dan transparansi sebagai prioritas.
                    </p>
                    <p>
                        Visi kami adalah menjadi destinasi elektronik terpercaya di
                        Indonesia, sedangkan misi kami mencakup kurasi produk bermutu,
                        pengiriman cepat, dukungan purna jual yang responsif, dan
                        pengalaman belanja yang aman.
                    </p>
                    <p>
                        Kami berpegang pada nilai kepercayaan, kualitas, dan kenyamanan.
                        Semua transaksi diproses aman, produk dilengkapi garansi resmi,
                        dan kebijakan pengembalian jelas untuk melindungi pelanggan.
                    </p>
                    <a href="about.html" class="btn btn-secondary" style="margin-top: 12px; display: inline-block">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <div class="about-image" aria-hidden="true">
                    <div class="about-illustration">
                        <img src="{{ asset('uploads/weblogo.png') }}" alt="Ilustrasi Tentang Techly" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FOOTER (GUEST) ================= --}}
    @guest
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-col">
                    <img src="{{ asset('uploads/logotbg.svg') }}" class="footer-logo" alt="Techly">
                    <p class="footer-desc">
                        Techly — Gadget & Elektronik terpercaya. Pengiriman cepat dan bergaransi.
                    </p>

                    <div class="footer-social">
                        <a href="#"><img src="{{ asset('uploads/logofb.svg') }}" class="social-icon-img"
                                alt="Facebook"></a>
                        <a href="#"><img src="{{ asset('uploads/logoig.svg') }}" class="social-icon-img"
                                alt="Instagram"></a>
                        <a href="#"><img src="{{ asset('uploads/logowa.svg') }}" class="social-icon-img"
                                alt="Whatsapp"></a>
                        <a href="#"><img src="{{ asset('uploads/logolinkedin.svg') }}" class="social-icon-img"
                                alt="LinkedIn"></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kebijakan</h4>
                    <ul>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Keamanan Pengguna</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <p>Email: <a href="mailto:admintechly@techly.id">admintechly@techly.id</a></p>
                    <p>Telp: +62 812-3456-7890</p>
                    <p>Alamat: Malang, Jawa Timur</p>
                </div>

                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Dapatkan promo & update terbaru.</p>

                    <form class="newsletter-form">
                        <input type="email" placeholder="Email kamu..." required>
                        <button type="submit">Daftar</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                © <span id="footerYear"></span> Techly. Semua hak dilindungi.
            </div>
        </footer>
    @endguest

    {{-- ================= FOOTER (AUTH) ================= --}}
    @auth
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-col">
                    <img src="{{ asset('uploads/logotbg.svg') }}" class="footer-logo" alt="Techly">
                    <p class="footer-desc">
                        Techly — Gadget & Elektronik terpercaya. Pengiriman cepat dan bergaransi.
                    </p>

                    <div class="footer-social">
                        <a href="#"><img src="{{ asset('uploads/logofb.svg') }}" class="social-icon-img"
                                alt="Facebook"></a>
                        <a href="#"><img src="{{ asset('uploads/logoig.svg') }}" class="social-icon-img"
                                alt="Instagram"></a>
                        <a href="#"><img src="{{ asset('uploads/logowa.svg') }}" class="social-icon-img"
                                alt="Whatsapp"></a>
                        <a href="#"><img src="{{ asset('uploads/logolinkedin.svg') }}" class="social-icon-img"
                                alt="LinkedIn"></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kebijakan</h4>
                    <ul>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Keamanan Pengguna</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <p>Email: <a href="mailto:admintechly@techly.id">admintechly@techly.id</a></p>
                    <p>Telp: +62 812-3456-7890</p>
                    <p>Alamat: Malang, Jawa Timur</p>
                </div>

                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Dapatkan promo & update terbaru.</p>

                    <form class="newsletter-form">
                        <input type="email" placeholder="Email kamu..." required>
                        <button type="submit">Daftar</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                © <span id="footerYear"></span> Techly. Semua hak dilindungi.
            </div>
        </footer>
    @endauth

    {{-- ================= SCRIPT GLOBAL (FOOTER YEAR, NAV PROFILE, CATEGORY FILTER) ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic year footer
            const yearEl = document.getElementById('footerYear');
            if (yearEl) {
                yearEl.textContent = new Date().getFullYear();
            }

            // Nav Profile dropdown (hanya ada saat auth)
            const navProfile = document.getElementById('navProfile');
            if (navProfile) {
                navProfile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');
                });

                document.addEventListener('click', function() {
                    navProfile.classList.remove('active');
                });
            }

            // ================= CATEGORY SECTION (SEARCH + DROPDOWN + MIN/MAX + TERAPKAN) =================
            const categoryCards = document.querySelectorAll(".category-card");
            const productContainer = document.getElementById("category-products");
            const searchInput = document.getElementById("categorySearch");
            const filterCategoryRight = document.getElementById("filterCategoryRight");
            const minPriceInput = document.getElementById("minPrice");
            const maxPriceInput = document.getElementById("maxPrice");
            const filterPriceBtn = document.getElementById("filterPriceBtn");

            if (!productContainer) return;

            let allProducts = [];
            const fallbackImage = "{{ asset('img/products/default-product.png') }}";

            // Ambil semua produk sekali
            fetch('/api/all-products')
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    allProducts = Array.isArray(data) ? data : [];
                })
                .catch(function(err) {
                    console.error('Gagal memuat /api/all-products:', err);
                });


            // Search: live, hanya pakai keyword (tanpa min/max & dropdown)
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    applySearchOnly();
                });
            }

            // Tombol Terapkan: pakai keyword + kategori dropdown + min/max
            if (filterPriceBtn) {
                filterPriceBtn.addEventListener('click', function() {
                    applyFullFilter();
                });
            }

            // Klik kartu kategori: set dropdown dan langsung filter full
            categoryCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    const slug = card.getAttribute('data-slug') || '';
                    if (filterCategoryRight) {
                        filterCategoryRight.value = slug;
                    }
                    applyFullFilter();
                });
            });

            // Fungsi: filter hanya berdasarkan keyword (live search)
            function applySearchOnly() {
                const keyword = searchInput ? (searchInput.value || '').toLowerCase().trim() : '';

                const filtered = allProducts.filter(function(p) {
                    const name = (p.name || '').toLowerCase();
                    const catName = p.product_category && p.product_category.name ?
                        p.product_category.name.toLowerCase() :
                        '';

                    if (!keyword) return true;
                    return name.includes(keyword) || catName.includes(keyword);
                });

                renderProducts(filtered);
            }

            // Fungsi: filter lengkap (keyword + dropdown kategori + min/max), dipanggil oleh TERAPKAN & klik card
            function applyFullFilter() {
                const keyword = searchInput ? (searchInput.value || '').toLowerCase().trim() : '';
                const selectedCategory = filterCategoryRight ? (filterCategoryRight.value || '').toLowerCase()
                    .trim() : '';
                const min = (minPriceInput && minPriceInput.value !== '') ? parseFloat(minPriceInput.value) : 0;
                const max = (maxPriceInput && maxPriceInput.value !== '') ? parseFloat(maxPriceInput.value) :
                    Infinity;

                const filtered = allProducts.filter(function(p) {
                    const name = (p.name || '').toLowerCase();
                    const catName = p.product_category && p.product_category.name ?
                        p.product_category.name.toLowerCase() :
                        '';
                    const catSlug = p.product_category && p.product_category.slug ?
                        p.product_category.slug.toLowerCase() :
                        '';
                    const price = p.price ? parseFloat(p.price) : 0;

                    const matchKeyword = !keyword ||
                        name.includes(keyword) ||
                        catName.includes(keyword);

                    const matchCategory = !selectedCategory ||
                        catSlug === selectedCategory;

                    const matchMin = !min || price >= min;
                    const matchMax = !max || price <= max;

                    return matchKeyword && matchCategory && matchMin && matchMax;
                });

                renderProducts(filtered);
            }

            // Render kartu produk di section kategori
            function renderProducts(products) {
                productContainer.innerHTML = '';

                if (!products || !products.length) {
                    productContainer.innerHTML = '<p>Tidak ada produk ditemukan.</p>';
                    return;
                }

                products.forEach(function(product) {
                    const images = Array.isArray(product.product_images) ? product.product_images : [];
                    let thumb = null;

                    if (images.length > 0) {
                        for (var i = 0; i < images.length; i++) {
                            if (images[i].is_thumbnail) {
                                thumb = images[i];
                                break;
                            }
                        }
                        if (!thumb) {
                            thumb = images[0];
                        }
                    }

                    const imgSrc = thumb ?
                        (window.location.origin + '/' + thumb.image) :
                        fallbackImage;

                    const priceFormatted = Number(product.price).toLocaleString('id-ID');

                    const cardHtml =
                        '<div class="bs-card">' +
                        '<div class="bs-image">' +
                        '<img src="' + imgSrc + '" alt="' + (product.name || '') + '">' +
                        '<span class="bs-category">' + (product.product_category ? (product.product_category
                            .name || '') : '') + '</span>' +
                        '</div>' +
                        '<div class="bs-content">' +
                        '<div class="bs-name">' + (product.name || '') + '</div>' +
                        '<div class="bs-price">Rp ' + priceFormatted + '</div>' +
                        '<div class="bs-rating">' +
                        '★★★★☆ <span style="font-size:12px; color:#666;">(123 Terjual)</span>' +
                        '</div>' +
                        '<a href="/product/' + product.slug +
                        '" class="btn btn-add-cart btn-detail-bs">Lihat Detail</a>' +
                        '</div>' +
                        '</div>';

                    productContainer.insertAdjacentHTML('beforeend', cardHtml);
                });
            }
        });
    </script>

    {{-- kalau kamu punya script global lain, tetap bisa dipanggil --}}
    <script src="{{ asset('script.js') }}"></script>
</body>

</html>
