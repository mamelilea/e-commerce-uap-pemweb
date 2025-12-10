<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Panel')</title>

    {{-- CSS Layout --}}
    <link rel="stylesheet" href="{{ asset('css/seller/seller-layout.css') }}">

    {{-- CSS Halaman --}}
    @yield('head')
</head>

<body>
    {{-- Navbar --}}
    <nav class="seller-navbar">

        <div class="nav-left">
            <a href="user.index" class="nav-logo">
                <img src="{{ asset('img/logo-techly.png') }}" class="logo-img" alt="Techly Logo">
            </a>
        </div>

        <ul class="nav-links">
            <li>
                <a href="{{ route('seller.store.create') }}"
                    class="nav-link {{ request()->routeIs('seller.store.create') ? 'active' : '' }}">
                    Pendaftaran Toko
                </a>
            </li>


            {{-- <li>
                <a href="{{ route('seller.orders.index') }}"
                    class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                    Pesanan
                </a>
            </li>

            <li>
                <a href="{{ route('seller.balance.index') }}"
                    class="nav-link {{ request()->routeIs('seller.balance.*') ? 'active' : '' }}">
                    Saldo Toko
                </a>
            </li>

            <li>
                <a href="{{ route('seller.withdraw.index') }}"
                    class="nav-link {{ request()->routeIs('seller.withdraw.*') ? 'active' : '' }}">
                    Penarikan Saldo
                </a>
            </li>

            <li>
                <a href="{{ route('seller.manage.index') }}"
                    class="nav-link {{ request()->routeIs('seller.manage.*') ? 'active' : '' }}">
                    Manajemen Toko
                </a>
            </li> --}}
        </ul>

    </nav>
    {{-- Konten Halaman --}}
    <main class="seller-content">
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer-container">
            <!-- BRAND -->
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

            <!-- NAVIGASI -->
            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>

            <!-- KEBIJAKAN -->
            <div class="footer-col">
                <h4>Kebijakan</h4>
                <ul>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Keamanan Pengguna</a></li>
                </ul>
            </div>

            <!-- KONTAK -->
            <div class="footer-col">
                <h4>Kontak</h4>
                <p>Email: <a href="mailto:admintechly@techly.id">admintechly@techly.id</a></p>
                <p>Telp: +62 812-3456-7890</p>
                <p>Alamat: Malang, Jawa Timur</p>
            </div>

            <!-- NEWSLETTER -->
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
            © 2025 Techly. Semua hak dilindungi.
        </div>
    </footer>
</body>

</html>
