<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300 transition-colors">
            @elseif(Auth::user()->store)
                <a href="{{ route('seller.dashboard') }}" class="text-white hover:text-gray-300 transition-colors">
            @else
                <a href="{{ route('customer.home') }}" class="text-white hover:text-gray-300 transition-colors">
            @endif
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
                <span class="tracking-wide">{{ __('Profile Saya') }}</span>
            </h2>
            
            @if(!Auth::user()->store && !Auth::user()->isAdmin())
            <div class="ml-auto">
                 <a href="{{ route('store.register') }}" onclick="return confirm('Apakah Anda yakin ingin membuka toko? Anda akan dialihkan ke halaman registrasi.');" class="bg-white text-black text-xs font-bold px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    BUKA TOKO
                 </a>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Info -->
                <div class="p-4 sm:p-8 bg-[#161616] shadow-lg sm:rounded-[20px] border border-white/10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="p-4 sm:p-8 bg-[#161616] shadow-lg sm:rounded-[20px] border border-white/10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-[#161616] shadow-lg sm:rounded-[20px] border border-white/10">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
