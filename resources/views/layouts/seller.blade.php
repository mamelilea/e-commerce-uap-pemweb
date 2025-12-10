<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    {{-- Seller Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('seller.dashboard') }}" class="text-xl font-extrabold text-primary-500">
                        Seller Panel
                    </a>
                    <span class="text-sm text-gray-500">{{ auth()->user()->store->name }}</span>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-primary-500 font-medium">View Store</a>

                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 text-primary-500 hover:text-primary-600 font-bold text-sm transition">
                            <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 hidden lg:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                            <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Seller Dashboard</a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white min-h-screen shadow-sm">
            <nav class="p-4 space-y-1">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('seller.dashboard') ? 'bg-primary-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('seller.products.*') ? 'bg-primary-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('seller.orders.*') ? 'bg-primary-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Orders
                </a>
                <a href="{{ route('seller.balance.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('seller.balance.*') ? 'bg-primary-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Balance
                </a>
                <a href="{{ route('seller.withdrawals.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('seller.withdrawals.*') ? 'bg-primary-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Withdrawals
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="bg-success-50 border border-success-500 text-success-700 px-4 py-3 rounded-md mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-danger-50 border border-danger-500 text-danger-700 px-4 py-3 rounded-md mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
