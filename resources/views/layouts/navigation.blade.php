<!-- Top Bar -->
<div class="bg-hubbub-pink text-white text-xs py-2 text-center font-sans tracking-wide">
    Gratis Ongkir · Kemasan Aman · Produk 100% Original
</div>

<nav x-data="{ open: false }" class="bg-hubbub-pink-light border-b border-white/50 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center gap-8">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-1 group">
                    <h1 class="font-header text-2xl sm:text-3xl font-bold text-hubbub-black group-hover:opacity-80 transition-opacity">Sillia <span class="text-hubbub-pink">Beauty Market</span></h1>
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-2xl">
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-hubbub-pink group-focus-within:text-hubbub-pink/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <form action="{{ route('home') }}" method="GET">
                        <input type="text" name="search" class="block w-full p-3 pl-12 text-sm text-gray-900 border-none rounded-full bg-white focus:ring-2 focus:ring-hubbub-pink/50 placeholder-gray-400 shadow-sm transition-shadow" placeholder="Cari produk kecantikan ...">
                    </form>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="hidden sm:flex items-center space-x-6">
                
                @guest
                    <div class="flex items-center space-x-4 font-sans font-medium text-gray-600">
                        <a href="{{ route('login') }}" class="hover:text-hubbub-pink transition-colors">Masuk</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="hover:text-hubbub-pink transition-colors">Daftar</a>
                    </div>
                @endguest

                <a href="{{ route('cart.index') }}" class="group flex items-center text-gray-700 hover:text-hubbub-pink transition-colors relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    @if(Auth::check() && \App\Models\Cart::where('user_id', Auth::id())->count() > 0)
                        <span class="absolute -top-1 -right-2 bg-hubbub-black text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center">
                            {{ \App\Models\Cart::where('user_id', Auth::id())->count() }}
                        </span>
                    @endif
                </a>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="font-sans font-medium text-gray-700 hover:text-hubbub-pink transition-colors flex items-center">
                                <div class="w-8 h-8 rounded-full bg-hubbub-pink text-white flex items-center justify-center text-xs tracking-wider border-2 border-white hover:border-hubbub-pink/50 transition-colors shadow-sm">
                                    {{ Str::upper(Str::substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Wallet Section -->
                            <div class="px-4 py-3 border-b border-gray-50">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">My Wallet</span>
                                <span class="block text-hubbub-pink text-sm font-bold font-sans">Rp {{ number_format(Auth::user()->balance->balance ?? 0, 0, ',', '.') }}</span>
                            </div>
                            
                            @if(Auth::user()->role === 'admin')
                                <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50">Admin Zone</div>
                                <x-dropdown-link :href="route('admin.dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users')">{{ __('Manage Users') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.stores')">{{ __('Manage Stores') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.verification')">{{ __('Verify Stores') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.withdrawals')">{{ __('Withdrawals') }}</x-dropdown-link>
                                <div class="border-t border-gray-100 my-1"></div>
                            @endif

                            @if(Auth::user()->store)
                                <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50">Seller Zone</div>
                                <x-dropdown-link :href="route('seller.dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.products')">{{ __('My Products') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.orders')">{{ __('Incoming Orders') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.balance')">{{ __('My Finances') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.profile')">{{ __('Store Settings') }}</x-dropdown-link>
                                <div class="border-t border-gray-100 my-1"></div>
                            @elseif(Auth::user()->role !== 'admin')
                                <x-dropdown-link :href="route('store.register')">{{ __('Open Store') }}</x-dropdown-link>
                                <div class="border-t border-gray-100 my-1"></div>
                            @endif
                            
                            <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50">My Account</div>
                            <x-dropdown-link :href="route('history')">{{ __('My Orders') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('wallet.topup')">{{ __('Topup Wallet') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Settings') }}</x-dropdown-link>
                            
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 hover:text-red-600 font-medium border-t border-gray-100">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden gap-1">
                 <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-hubbub-pink transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                     @if(Auth::check() && \App\Models\Cart::where('user_id', Auth::id())->count() > 0)
                        <span class="absolute top-1 right-0 bg-hubbub-black text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center leading-none">
                            {{ \App\Models\Cart::where('user_id', Auth::id())->count() }}
                        </span>
                    @endif
                </a>
                
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-hubbub-pink focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="px-4 py-2">
             <form action="{{ route('home') }}" method="GET">
                <input type="text" name="search" class="block w-full p-2 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-hubbub-pink focus:border-hubbub-pink" placeholder="Cari produk...">
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="font-sans font-medium">{{ __('Home') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('collection')" :active="request()->routeIs('collection')" class="font-sans font-medium">{{ __('Collection') }}</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4 mb-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-hubbub-pink text-white flex items-center justify-center font-header font-bold text-lg tracking-wider">
                         {{ Str::upper(Str::substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-bold text-base text-gray-800 font-sans">{{ Auth::user()->name }}</div>
                         <div class="mt-1 flex items-center gap-2">
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Wallet</span>
                            <span class="text-xs text-hubbub-pink font-bold font-sans">Rp {{ number_format(Auth::user()->balance->balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    @if(Auth::user()->role === 'admin')
                        <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50">Admin Zone</div>
                        <x-responsive-nav-link :href="route('admin.dashboard')" class="font-sans font-medium text-sm">{{ __('Dashboard') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.users')" class="font-sans font-medium text-sm">{{ __('Manage Users') }}</x-responsive-nav-link>
                         <x-responsive-nav-link :href="route('admin.stores')" class="font-sans font-medium text-sm">{{ __('Manage Stores') }}</x-responsive-nav-link>
                         <x-responsive-nav-link :href="route('admin.verification')" class="font-sans font-medium text-sm">{{ __('Verify Stores') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.withdrawals')" class="font-sans font-medium text-sm">{{ __('Withdrawals') }}</x-responsive-nav-link>
                    @endif

                    @if(Auth::user()->store)
                        <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50 mt-2">Seller Zone</div>
                        <x-responsive-nav-link :href="route('seller.dashboard')" class="font-sans font-medium text-sm">{{ __('Dashboard') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('seller.products')" class="font-sans font-medium text-sm">{{ __('My Products') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('seller.orders')" class="font-sans font-medium text-sm">{{ __('Incoming Orders') }}</x-responsive-nav-link>
                         <x-responsive-nav-link :href="route('seller.balance')" class="font-sans font-medium text-sm">{{ __('My Finances') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('seller.profile')" class="font-sans font-medium text-sm">{{ __('Store Settings') }}</x-responsive-nav-link>
                    @elseif(Auth::user()->role !== 'admin')
                         <x-responsive-nav-link :href="route('store.register')" class="font-sans font-medium text-sm mt-2">{{ __('Open Store') }}</x-responsive-nav-link>
                    @endif

                    <div class="px-4 py-2 text-[10px] font-bold text-hubbub-pink font-sans uppercase tracking-widest bg-pink-50 mt-2">My Account</div>
                    <x-responsive-nav-link :href="route('history')" class="font-sans font-medium text-sm">{{ __('My Orders') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('wallet.topup')" class="font-sans font-medium text-sm">{{ __('Topup Wallet') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')" class="font-sans font-medium text-sm">{{ __('Profile Settings') }}</x-responsive-nav-link>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-sans font-medium text-sm !text-red-500 hover:!text-red-600 border-t border-gray-100 mt-2">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="font-sans font-medium">{{ __('Log in') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="font-sans font-medium">{{ __('Register') }}</x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
