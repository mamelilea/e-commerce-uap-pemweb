<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller Panel - {{ config('app.name', 'Marketplace') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo / Brand -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('seller.dashboard') }}" class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                        🏪 Seller Panel
                    </a>

                    <!-- Navigation Menu -->
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('seller.dashboard') }}"
                            class="text-gray-700 hover:text-blue-600 transition font-medium {{ request()->routeIs('seller.dashboard') || request()->routeIs('seller.orders.*') ? 'text-blue-600' : '' }}">
                            📦 Pesanan
                        </a>
                        <a href="{{ route('seller.products.index') }}"
                            class="text-gray-700 hover:text-blue-600 transition font-medium {{ request()->routeIs('seller.products.*') ? 'text-blue-600' : '' }}">
                            📦 Produk
                        </a>
                        <a href="{{ route('seller.store.index') }}"
                            class="text-gray-700 hover:text-blue-600 transition font-medium {{ request()->routeIs('seller.store.*') ? 'text-blue-600' : '' }}">
                            🏬 Toko
                        </a>
                        <a href="{{ route('seller.balance.index') }}"
                            class="text-gray-700 hover:text-blue-600 transition font-medium {{ request()->routeIs('seller.balance') ? 'text-blue-600' : '' }}">
                            💰 Saldo
                        </a>
                    </div>
                </div>

                <!-- Right Side Menu -->
                <div class="flex items-center gap-4">
                    <!-- Store Info -->
                    @if(auth()->user()->store)
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->store->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->name }}</p>
                    </div>
                    @endif

                    <!-- Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profil
                            </a>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Lihat Toko
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu (Optional) -->
    <div class="md:hidden bg-white border-t">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-around">
                <a href="{{ route('seller.dashboard') }}"
                    class="flex flex-col items-center gap-1 py-2 px-3 {{ request()->routeIs('seller.dashboard') || request()->routeIs('seller.orders.*') ? 'text-blue-600' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="text-xs font-medium">Pesanan</span>
                </a>
                <a href="{{ route('seller.products.index') }}"
                    class="flex flex-col items-center gap-1 py-2 px-3 {{ request()->routeIs('seller.products.*') ? 'text-blue-600' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="text-xs font-medium">Produk</span>
                </a>
                <a href="{{ route('seller.store.index') }}"
                    class="flex flex-col items-center gap-1 py-2 px-3 {{ request()->routeIs('seller.store.*') ? 'text-blue-600' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="text-xs font-medium">Toko</span>
                </a>
                <a href="{{ route('seller.balance.index') }}"
                    class="flex flex-col items-center gap-1 py-2 px-3 {{ request()->routeIs('seller.balance') ? 'text-blue-600' : 'text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs font-medium">Saldo</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16 py-6">
        <div class="container mx-auto px-4 text-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} Marketplace. All rights reserved.</p>
        </div>
    </footer>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>