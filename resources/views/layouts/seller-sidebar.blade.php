<aside 
    :class="[
        open ? 'translate-x-0' : '-translate-x-full',
        sidebarCollapsed ? 'w-64 sm:w-20' : 'w-64'
    ]"
    @mouseenter="sidebarCollapsed = false"
    @mouseleave="sidebarCollapsed = true"
    x-init="sidebarCollapsed = true"
    class="fixed inset-y-0 left-0 z-40 bg-[#0a0a0a] border-r border-white/10 min-h-screen transition-all duration-300 ease-in-out sm:sticky sm:top-0 sm:h-screen sm:translate-x-0 shadow-lg sm:shadow-none flex flex-col"
>
    <!-- Header -->
    <div class="h-16 flex items-center justify-between border-b border-white/10 transition-all duration-300"
        :class="sidebarCollapsed ? 'px-1' : 'px-4'">
        <div class="flex items-center gap-2 overflow-hidden whitespace-nowrap flex-shrink-0" :class="sidebarCollapsed ? 'w-full justify-center' : ''">
            <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 decoration-0 text-[#E0E0E0]">
                <!-- Logo Y2K Style -->
                <div class="w-[38px] h-[38px] rounded-[14px] grid place-items-center bg-white text-black font-black text-sm tracking-[0.5px] flex-shrink-0">
                    Y2K
                </div>
                <div x-show="!sidebarCollapsed" class="transition-opacity duration-300 delay-100">
                    <div class="font-black text-base text-white leading-[1.1]">Y2K Accessories</div>
                    <div class="text-[10px] text-[#9C9C9C] mt-[2px] whitespace-nowrap">ring • necklace • bracelet • charms</div>
                </div>
            </a>
        </div>
        
        <!-- Close Button (Mobile) -->
        <button @click="open = false" class="sm:hidden p-1 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 space-y-6">
        
        <!-- Group: Overview -->
        <div>
            <div x-show="!sidebarCollapsed" class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider transition-opacity duration-200">
                Overview
            </div>
            <div class="space-y-1 px-3">
                <a href="{{ route('seller.dashboard') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Dashboard</span>
                    
                    <!-- Tooltip -->
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                        Dashboard
                    </div>
                </a>

                <!-- Lihat Beranda -->
                <a href="{{ route('customer.home') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 text-gray-400 hover:bg-white/5 hover:text-white">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Lihat Beranda</span>
                    
                    <!-- Tooltip -->
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">
                        Lihat Beranda
                    </div>
                </a>
            </div>
        </div>

        <!-- Group: Menu Utama -->
        <div>
            <div x-show="!sidebarCollapsed" class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider transition-opacity duration-200">
                Menu Utama
            </div>
            <div class="space-y-1 px-3">
                <a href="{{ route('seller.store.manage') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.store.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                   <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Profil Toko</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Profil Toko</div>
                </a>

                <a href="{{ route('seller.products.index') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.products.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Produk Saya</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Produk Saya</div>
                </a>

                <a href="{{ route('seller.orders.index') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.orders.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Pesanan</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Pesanan</div>
                </a>
            </div>
        </div>

        <!-- Group: Keuangan -->
        <div>
            <div x-show="!sidebarCollapsed" class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider transition-opacity duration-200">
                Keuangan
            </div>
            <div class="space-y-1 px-3">
                <a href="{{ route('seller.balance.index') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.balance.index') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Saldo Toko</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Saldo Toko</div>
                </a>

                <a href="{{ route('seller.balance.withdraw') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('seller.balance.withdraw') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Penarikan Dana</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Penarikan Dana</div>
                </a>
            </div>
        </div>
    </nav>

    <!-- Profile Section (Bottom) -->
    <div class="border-t border-white/10 p-4 bg-[#161616]" :class="sidebarCollapsed ? 'flex justify-center' : ''">
        <div class="flex items-center gap-3">
             <!-- Profile Link Container -->
             <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 flex-1 min-w-0 group cursor-pointer">
                 <!-- User Avatar (Now uses Store Logo) -->
                 <div class="w-10 h-10 rounded-full bg-[#161616] border border-white/10 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 overflow-hidden group-hover:ring-2 ring-indigo-500 transition-all">
                    @if(Auth::user()->store && Auth::user()->store->logo)
                         <img src="{{ Auth::user()->store->logo == 'wtc-logo.png' ? asset('images/wtc-logo.png') : asset('storage/' . Auth::user()->store->logo) }}" alt="Store Logo" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                
                <!-- User Info (Hidden when collapsed) -->
                <div x-show="!sidebarCollapsed" class="flex-1 min-w-0 transition-opacity duration-300">
                    <div class="text-sm font-medium text-[#EDEDEC] truncate group-hover:text-white transition-colors">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 truncate group-hover:text-gray-400 transition-colors">{{ Auth::user()->email }}</div>
                </div>
             </a>

            <!-- Logout Button (Icon only when collapsed via tooltip logic, or full when expanded) -->
             <form method="POST" action="{{ route('logout') }}" x-show="!sidebarCollapsed">
                @csrf
                <button type="submit" class="p-2 text-gray-400 hover:text-white transition-colors" title="Log Out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
        
        <!-- Collapsed Logout Trigger (Optional: make the whole area clickable or add a specific mini button if needed, but for now simple layout) -->
         <form method="POST" action="{{ route('logout') }}" x-show="sidebarCollapsed" class="mt-2 flex justify-center w-full">
            @csrf
            <button type="submit" class="p-2 text-gray-400 hover:text-white transition-colors" title="Log Out">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
</aside>

<!-- Overlay -->
<div x-show="open" @click="open = false" class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity sm:hidden" style="display: none;"></div>
