<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kore') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-k-grey text-k-text">
    
    <!-- Navbar (Dribbble Style) -->
    <nav class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <!-- Left: Logo & Links -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ asset('logopink.png') }}" class="h-14 w-auto" alt="Koré Logo">
                </a>
                <div class="hidden md:flex space-x-6 text-sm font-medium text-gray-600">
                    <a href="{{ route('home') }}?category=album" class="hover:text-k-pink transition-colors">Albums</a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('home') }}?category=lightstick" class="hover:text-k-pink transition-colors">Lightsticks</a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('home') }}?category=photocard" class="hover:text-k-pink transition-colors">Photocards</a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('home') }}?category=apparel" class="hover:text-k-pink transition-colors">Apparel</a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('home') }}?category=keychains-stickers" class="hover:text-k-pink transition-colors">Keychain & Sticker</a>
                </div>
            </div>
            
            <!-- Right: Auth & Search -->
            <div class="flex items-center gap-4">
                <div class="hidden md:block relative">
                    <form action="{{ route('home') }}" method="GET">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-k-pink">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-48 pl-9 pr-4 py-2 rounded-full border-none bg-gray-50 text-sm focus:ring-2 focus:ring-k-pink text-gray-600 placeholder-gray-400 transition-all">
                    </form>
                </div>

                <!-- Wishlist & Cart -->
                <div class="flex items-center gap-4 text-gray-400">
                    <a href="{{ route('wishlist.index') }}" class="hover:text-k-pink transition-colors relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        @auth
                            @php
                                $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                            @endphp
                            @if($wishlistCount > 0)
                                <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $wishlistCount > 9 ? '9+' : $wishlistCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    <a href="{{ route('cart.index') }}" class="hover:text-k-pink transition-colors relative">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                       </svg>
                       @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount > 9 ? '9+' : $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->role === 'admin')
                                {{-- Admin Menu --}}
                                <x-dropdown-link :href="route('admin.index')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.stores')">
                                    {{ __('Manage Stores') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.users')">
                                    {{ __('Manage Users') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @elseif(Auth::user()->role === 'seller')
                                {{-- Seller Menu --}}
                                <x-dropdown-link :href="route('store.index')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('store.edit')">
                                    {{ __('Store Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('seller.orders.index')">
                                    {{ __('Orders') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('store.index')">
                                    {{ __('Products') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('seller.financials.balance')">
                                    {{ __('Store Balance') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('seller.financials.index')">
                                    {{ __('Withdrawals') }}
                                </x-dropdown-link>
                            @else
                                {{-- Regular User Menu --}}
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('history.index')">
                                    {{ __('My Orders') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('wallet.index')">
                                    {{ __('My Wallet') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('store.index')">
                                    {{ __('Open Your Shop') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">Sign in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-lg bg-k-pink text-white text-sm font-bold hover:bg-pink-400 transition-colors">Sign up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 mt-24 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="block font-bold text-3xl text-gray-900 tracking-tight font-sans mb-2">Koré.</a>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-xs font-light">
                        Your daily dose of K-Aesthetic. We curate the best merchandise for fans worldwide. 
                    </p>
                </div>

                <!-- Shop Links -->
                <div>
                    <h3 class="font-bold text-gray-900 text-lg mb-6">Shop</h3>
                    <ul class="space-y-4 text-sm text-gray-500 font-medium">
                        <li><a href="{{ route('home') }}#official" class="hover:text-k-pink hover:pl-2 transition-all duration-300 inline-block">Official Merchandise</a></li>
                        <li><a href="{{ route('home') }}#fanmade" class="hover:text-k-pink hover:pl-2 transition-all duration-300 inline-block">Fanmade Merchandise</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-k-pink hover:pl-2 transition-all duration-300 inline-block">New Arrivals</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div>
                    <h3 class="font-bold text-gray-900 text-lg mb-6">Connect</h3>
                    <ul class="space-y-4 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-3 group">
                             <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-k-pink group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                             </div>
                             <a href="https://instagram.com/kore.storeofficial" target="_blank" class="hover:text-gray-900 transition-colors">kore.storeofficial</a>
                        </li>
                        <li class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-k-pink group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <a href="mailto:jaesalminma@gmail.com" class="hover:text-gray-900 transition-colors">jaesalminma@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-xs font-medium tracking-wide">&copy; {{ date('Y') }} Koré. All rights reserved.</p>
                <div class="flex gap-4 items-center">
                    <p class="text-xs text-gray-400 font-medium tracking-wide flex items-center gap-2">
                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        100% Secure Payment
                    </p>
                </div>
            </div>
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
