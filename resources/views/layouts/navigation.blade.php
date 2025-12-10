<nav x-data="{ open: false }" class="bg-white/90 border-b border-slate-200 sticky top-0 z-50 shadow-sm backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo + Brand + Nav Links -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('LogoProjectKiloMeter.svg') }}" class="h-10 w-auto" alt="KiloMeter Logo">
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:flex sm:items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="text-slate-700 hover:text-slate-900">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    @auth
                    @if (Auth::user()->role === 'admin')
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')"
                        class="text-slate-700 hover:text-slate-900">
                        {{ __('Admin Panel') }}
                    </x-nav-link>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex items-center space-x-6">

                {{-- 🔍 Search --}}
                <form action="{{ route('home') }}" method="GET" class="relative">
                    {{-- pertahankan category filter kalau ada --}}
                    @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari sepatu atau toko..."
                        class="w-56 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="absolute right-2 top-1.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                        </svg>
                    </button>
                </form>

                {{-- Guest: tombol Login & Register --}}
                @guest
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900">
                    Masuk
                </a>

                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-widest bg-emerald-500 text-white hover:bg-emerald-600">
                    Daftar
                </a>
                @endguest

                {{-- Auth: avatar dropdown --}}
                @auth

                @if (!Auth::user()->store()->exists())
                <a href="{{ route('stores.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-widest bg-emerald-500 text-white hover:bg-emerald-600">
                    Daftarkan Toko
                </a>
                @endif
                @php
                $cart = session('cart', []);
                $cartCount = is_array($cart) ? array_sum($cart) : 0;
                @endphp

                <a href="{{ route('cart.index') }}"
                    class="relative group inline-flex items-center rounded-full bg-slate-900 text-white px-2 py-1.5 hover:bg-slate-800 transition-all duration-200">

                    {{-- ICON KERANJANG --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25h1.386c.51 0 .955.343 1.087.835L5.91 8.25m0 0h12.24m-12.24 0l1.318 5.272c.132.492.577.835 1.087.835h7.67c.51 0 .955-.343 1.087-.835L18.75 8.25m-1.44 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-8.31 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>

                    {{-- TEKS YANG MUNCUL SAAT HOVER --}}
                    <span
                        class="ml-0 max-w-0 overflow-hidden whitespace-nowrap text-xs font-semibold transition-all duration-200 group-hover:ml-2 group-hover:max-w-xs">
                        Keranjang
                    </span>

                    {{-- BADGE JUMLAH ITEM --}}
                    @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-emerald-500 text-[10px] font-bold text-white px-1">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="border border-slate-200 rounded-full w-9 h-9 flex items-center justify-center overflow-hidden bg-slate-100 text-slate-800">
                            @if (Auth::user()->profile_photo_url ?? false)
                            <img src="{{ Auth::user()->profile_photo_url }}" class="object-cover w-full h-full">
                            @else
                            <span class="font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-3 pb-2 border-b border-slate-100 mb-2">
                            <p class="text-xs text-slate-400">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>

                        @if (Auth::user()->store()->exists())
                        <x-dropdown-link :href="route('seller.dashboard')">
                            {{ __('Store Dashboard') }}
                        </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <!-- Mobile Buttons -->
            <div class="sm:hidden flex items-center space-x-2">
                <button class="text-slate-700 hover:text-slate-900 p-2 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                </button>

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-200">
        <div class="px-4 pt-4 pb-2 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            @auth
            @if (Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                {{ __('Admin Panel') }}
            </x-responsive-nav-link>
            @endif
            @endauth
        </div>

        @auth
        <div class="pt-4 pb-4 border-t border-slate-200">
            <div class="px-4 flex items-center space-x-3">
                <div class="border border-slate-200 rounded-full w-10 h-10 flex items-center justify-center bg-slate-100 text-slate-800 overflow-hidden">
                    @if (Auth::user()->profile_photo_url ?? false)
                    <img src="{{ Auth::user()->profile_photo_url }}" class="object-cover w-full h-full">
                    @else
                    <span class="font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    @endif
                </div>

                <div>
                    <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-600">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                @if (!Auth::user()->store()->exists())
                <x-responsive-nav-link :href="route('stores.create')">
                    {{ __('Daftarkan Toko') }}
                </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

        @guest
        <div class="pt-2 pb-4 border-t border-slate-200">
            <div class="px-4 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Masuk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Daftar') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endguest
    </div>
</nav>