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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 decoration-0 text-[#E0E0E0]">
                <!-- Logo Y2K Style -->
                <div class="w-[38px] h-[38px] rounded-[14px] grid place-items-center bg-white text-black font-black text-sm tracking-[0.5px] flex-shrink-0">
                    ADM
                </div>
                <div x-show="!sidebarCollapsed" class="transition-opacity duration-300 delay-100">
                    <div class="font-black text-base text-white leading-[1.1]">ADMIN PANEL</div>
                    <div class="text-[10px] text-[#9C9C9C] mt-[2px] whitespace-nowrap">control center</div>
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
                Menu
            </div>
            <div class="space-y-1 px-3">
                <a href="{{ route('admin.dashboard') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Dashboard</span>
                    
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Dashboard</div>
                </a>

                <a href="{{ route('admin.verification') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('admin.verification') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Verifikasi Toko</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Verifikasi Toko</div>
                </a>

                <a href="{{ route('admin.payment.verification') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('admin.payment.verification') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Verifikasi Pembayaran</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Verifikasi Pembayaran</div>
                </a>

                <a href="{{ route('admin.withdrawal.verification') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('admin.withdrawal.verification') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Verifikasi Penarikan</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Verifikasi Penarikan</div>
                </a>

                <a href="{{ route('admin.management') }}" 
                   :class="sidebarCollapsed ? 'justify-center' : ''"
                   class="flex items-center px-3 py-2.5 rounded-lg group relative transition-colors duration-200 {{ request()->routeIs('admin.management') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="ml-4 font-medium whitespace-nowrap transition-opacity duration-200">Manajemen Sistem</span>
                    <div x-show="sidebarCollapsed" class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50 whitespace-nowrap">Manajemen Sistem</div>
                </a>
            </div>
        </div>

    </nav>

    <!-- Footer / Profile -->
    <div class="border-t border-white/10 p-4 bg-[#0a0a0a]">
        <div class="flex flex-col gap-4">
            <a href="{{ route('profile.edit') }}" class="group flex items-center justify-between hover:bg-white/5 p-2 rounded-lg transition-colors duration-200">
                <div class="flex items-center gap-3 overflow-hidden" :class="sidebarCollapsed ? 'justify-center w-full' : ''">
                    <div class="w-8 h-8 rounded-full bg-white text-black font-bold flex items-center justify-center flex-shrink-0">
                         {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div x-show="!sidebarCollapsed" class="flex flex-col transition-opacity duration-300">
                        <span class="text-sm font-medium text-white truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-start text-gray-500">Edit Profil</span>
                    </div>
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" x-show="!sidebarCollapsed" class="block transition-opacity duration-300">
                @csrf
                <button type="button" @click="confirmLogout($event)" 
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all duration-200 group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-medium">Log Out</span>
                </button>
            </form>
        </div>
    </div>
</aside>
