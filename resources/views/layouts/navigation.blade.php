<nav x-data="{ open: false }" class="bg-[#0a0a0a] border-b border-white/10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <!-- Logo Removed as per request -->
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
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#0a0a0a] border-b border-white/10">
        <div class="pt-2 pb-3 space-y-1">
             <div class="px-4 py-2 text-white font-medium">
                Menu
             </div>
        </div>

        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                @auth
                    <div class="font-medium text-base text-white">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ auth()->user()->email }}</div>
                @else
                    <div class="font-medium text-base text-white">Guest</div>
                    <div class="font-medium text-sm text-gray-400">-</div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white hover:bg-white/10">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="confirmLogout(event)" class="text-gray-300 hover:text-white hover:bg-white/10">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
