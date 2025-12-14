<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root{
            --bg: #0B0B0B;
            --panel: #121212;
            --panel2: #171717;
            --garis: #242424;
            --garis2: #343434;
            --teks: #F2F2F2;
            --muted: #B9B9B9;
            --muted2: #9C9C9C;
            --putih: #FFFFFF;
            --hitam: #000000;
            --pink: #f0bbbbff;
            --pink-tua: #d26b6bff;
        }

        *{ box-sizing: border-box; }
        html, body {
            height: 100%;
            margin: 0;
            background: var(--bg);
            color: var(--teks);
            font-family: 'Figtree', sans-serif;
        }

        .app-content {
            position: relative;
            z-index: 10;
            background: var(--bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding-bottom: 10rem;
            min-height: 100vh;
        }

        .footer-reveal {
            position: sticky;
            bottom: 0;
            z-index: -10;
        }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--bg);
            border-bottom: 1px solid var(--garis);
        }

        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--teks);
        }
        .brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--putih);
            color: var(--hitam);
            font-weight: 900;
            letter-spacing: 0.5px;
        }
        .brand-name {
            font-weight: 900;
            line-height: 1.1;
        }
        .brand-tag {
            font-size: 12px;
            color: var(--muted2);
            margin-top: 2px;
        }

        .search {
            display: none;
            flex: 1;
            max-width: 520px;
            position: relative;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted2);
            font-size: 14px;
        }
        .search-clear {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: #ccc;
            color: #fff;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-clear:hover {
            background: #999;
        }
        .search input {
            width: 100%;
            padding: 10px 40px 10px 34px;
            border-radius: 18px;
            border: 1px solid var(--garis);
            background: #e7e7e7ff;
            color: #111;
            outline: none;
            font-weight: 600;
        }
        .search input:not(:placeholder-shown) ~ .search-clear {
            display: flex;
        }
        @media (min-width: 768px) {
            .search { display: block; }
        }

        .auth a {
            font-weight: 700;
            font-size: 14px;
            padding: 10px 18px;
            border-radius: 24px;
            text-decoration: none;
            transition: background-color 0.25s ease;
            white-space: nowrap;
        }
        .auth .btn-outline {
            border: 1px solid var(--garis);
            background: var(--panel);
            color: var(--teks);
            margin-right: 10px;
        }
        .auth .btn-outline:hover {
            background: var(--panel2);
        }
        .auth .btn-solid {
            background: var(--putih);
            color: var(--hitam);
        }
        .auth .btn-solid:hover {
            background: #EEE;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--panel);
            border: 1px solid var(--garis);
            border-radius: 12px;
            min-width: 160px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 6px;
            z-index: 100;
            margin-top: 8px;
        }
        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-item {
            display: block;
            padding: 10px 16px;
            color: var(--teks);
            text-decoration: none;
            font-size: 14px;
            border-radius: 8px;
            transition: background 0.2s;
            text-align: left;
            width: 100%;
            background: none;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }
        .dropdown-item:hover {
            background: var(--panel2);
        }

        footer {
            border-top: 1px solid var(--garis);
            padding: 18px;
            text-align: center;
            color: var(--muted2);
            font-size: 13px;
            margin-top: 40px;
            background: var(--bg);
        }
    </style>
</head>
<body class="font-sans antialiased">
    
    <div class="app-content">
        <header>
            <div class="container header-bar">
                <div class="flex items-center gap-4">
                    @if(auth()->check() && auth()->user()->store)
                        <a href="{{ route('seller.dashboard') }}" style="color: var(--teks);" class="hover:opacity-75 transition-opacity" title="Kembali ke Dashboard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                    @endif
                    <a class="brand" href="{{ route('customer.home') }}">
                    <div class="brand-logo">Y2K</div>
                    <div>
                        <div class="brand-name">Y2K Accessories</div>
                        <div class="brand-tag">ring • necklace • bracelet • sunglasses • charms</div>
                    </div>
                </a>
                </div>
    
                <form class="search" action="{{ route('customer.search') }}" method="GET">
                    <div class="search-icon">⌕</div>
                    <input type="text" name="q" id="searchInput" placeholder="Cari aksesoris y2k..." value="{{ request('q') }}" required autocomplete="off">
                    <div class="search-clear" onclick="document.getElementById('searchInput').value = ''; document.getElementById('searchInput').focus();">✕</div>
                </form>

                <div style="margin-right: 20px;">
                    <a href="{{ route('cart.index') }}" title="Keranjang" style="color: var(--teks); display: block;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
    
                <div class="auth">
                    @auth
        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="btn-outline">Dashboard</a>
                        @else
                            @if(!auth()->user()->store)
                                <a href="{{ route('transaction.history') }}" class="btn-outline">History</a>
                                
                                <div class="profile-dropdown">
                                    <a href="{{ route('profile.edit') }}" class="btn-solid">Profile</a>
                                    <div class="dropdown-menu">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="color: var(--pink-tua);">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-outline">Log in</a>
                        <a href="{{ route('register') }}" class="btn-solid">Register</a>
                    @endauth
                </div>
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
    </div>

    <div class="footer-reveal">
        <x-footer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.action && e.target.action.includes('logout')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin ingin log out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak',
                    background: '#fff',
                    color: '#000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }
        });
    </script>
</body>
</html>
