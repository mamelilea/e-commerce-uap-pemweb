<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">

            @if (Route::has('login'))
                <nav class="bg-black border-b border-gray-900">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <div class="shrink-0 flex items-center">
                                    <a href="{{ route('home') }}">
                                        <x-application-logo class="text-2xl text-white" />
                                    </a>
                                </div>
                            </div>
                            

                            <div class="flex-1 flex justify-center items-center px-6 lg:px-12">
                                <form action="{{ route('home') }}" method="GET" class="w-full max-w-lg">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-700 rounded-lg leading-5 bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:border-[#ff9900] focus:ring-[#ff9900] sm:text-sm" placeholder="Search for products...">
                                    </div>
                                </form>
                            </div>


                             <div class="flex items-center space-x-4">
                                @auth

                                    <a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        @if(isset($cartCount) && $cartCount > 0)
                                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                                {{ $cartCount }}
                                            </span>
                                        @endif
                                    </a>


                                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-black hover:text-white focus:outline-none transition ease-in-out duration-150">
                                                    <div class="flex items-center">
                                                        @if (Auth::user()->avatar)
                                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover mr-2">
                                                        @else
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover mr-2">
                                                        @endif
                                                        <div class="hidden md:block">{{ Auth::user()->name }}</div>
                                                        <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                @if(Auth::user()->isAdmin())
                                                     <x-dropdown-link :href="route('admin.dashboard')">
                                                        {{ __('Admin Panel') }}
                                                    </x-dropdown-link>
                                                @elseif(Auth::user()->isSeller())
                                                    <x-dropdown-link :href="route('seller.dashboard')">
                                                        {{ __('Seller Dashboard') }}
                                                    </x-dropdown-link>
                                                     <x-dropdown-link :href="route('seller.orders.index')">
                                                        {{ __('Manage Orders') }}
                                                    </x-dropdown-link>
                                                     <x-dropdown-link :href="route('seller.products.index')">
                                                        {{ __('My Products') }}
                                                    </x-dropdown-link>
                                                     <x-dropdown-link :href="route('seller.balance.index')">
                                                        {{ __('Store Balance') }}
                                                    </x-dropdown-link>
                                                @else

                                                @endif

                                                <x-dropdown-link :href="route('orders.history')">
                                                    {{ __('My Purchases') }}
                                                </x-dropdown-link>

                                                <x-dropdown-link :href="route('profile.edit')">
                                                    {{ __('Profile') }}
                                                </x-dropdown-link>


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
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white underline">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-300 hover:text-white underline">Register</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            @endif


            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
