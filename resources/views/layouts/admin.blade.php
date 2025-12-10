<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    {{-- Admin Navbar --}}
    <nav class="bg-black text-white shadow-lg border-b border-gray-200">
        <div class="container-custom">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-extrabold text-white">
                        Admin Panel
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white">View Site</a>
                    <span class="text-sm text-gray-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-300 hover:text-white">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white min-h-screen border-r border-gray-200">
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.stores.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('admin.stores.*') ? 'bg-black text-white font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Store Verification
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-black text-white font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    User & Store Management
                </a>
                <a href="{{ route('admin.withdrawals.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-md {{ request()->routeIs('admin.withdrawals.*') ? 'bg-black text-white font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
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
