<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Techly Admin')</title>

    {{-- CSS utama Techly (navbar, footer, dll) --}}
    <link rel="stylesheet" href="{{ asset('css/landingpage/home.css') }}" />

    {{-- CSS khusus admin --}}
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}" />

    @stack('styles')
</head>

<body>
    {{-- HEADER / NAVBAR ADMIN --}}
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                {{-- Logo utama kiri --}}
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <img src="{{ asset('uploads/weblogo.png') }}" alt="Techly" class="logo-img" />
                </a>

                {{-- NAV ADMIN --}}
                <nav class="admin-navbar">
                    <ul class="nav-links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.stores.verification') }}"
                                class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                                Verifikasi Toko
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users-stores.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                Manajemen Pengguna
                            </a>
                        </li>
                    </ul>

                    {{-- Profile Dropdown --}}
                    <div class="nav-profile" id="navProfile">
                        <img src="{{ asset('img/user-icon.svg') }}" alt="Profile" class="profile-icon" />

                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="profile-info">
                                <strong>{{ auth()->user()->name }}</strong><br>
                                <small>Admin</small>
                            </div>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">Logout</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    {{-- KONTEN ADMIN --}}
    <main class="admin-main">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- FOOTER sama seperti landing --}}
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

    @stack('scripts')

    {{-- Script dropdown profile --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>

</html>
