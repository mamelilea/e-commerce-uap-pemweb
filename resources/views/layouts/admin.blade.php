<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ 
            open: false, 
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            toggleSidebar() {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
            }
        }" class="min-h-screen bg-[#0a0a0a] text-[#EDEDEC] flex">
            <!-- Sidebar -->
            @include('layouts.admin-sidebar')

            <div class="flex-1 flex flex-col">
                 <!-- Top Navigation / Header for mobile and user dropdown -->
                <nav class="bg-[#0a0a0a] border-b border-white/10 sm:hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Logo for Mobile -->
                                <div class="shrink-0 flex items-center sm:hidden">
                                     <a href="{{ route('admin.dashboard') }}">
                                        <x-application-logo class="block h-9 w-auto fill-current text-[#EDEDEC]" />
                                    </a>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 focus:text-white transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#0a0a0a] border-b border-white/10 absolute w-full z-50">
                        <div class="pt-2 pb-3 space-y-1">
                            {{-- Sidebar handles navigation on mobile --}}
                        </div>
                         <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-white/10">
                            <div class="px-4">
                                <div class="font-medium text-base text-[#EDEDEC]">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="confirmLogout(event)">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-[#0a0a0a] border-b border-white/10 shadow-sm h-16 flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#0a0a0a] flex flex-col">
                    <div class="flex-1">
                        {{ $slot }}
                    </div>
                    <div class="mt-32">
                        <x-footer :simple="true" />
                    </div>
                </main>
            </div>
        </div>
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmLogout(event) {
                event.preventDefault();
                const form = event.target.closest('form');
                
                Swal.fire({
                    title: 'Apakah anda yakin ingin log out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak',
                    background: '#1a1a1a', 
                    color: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    </body>
</html>
