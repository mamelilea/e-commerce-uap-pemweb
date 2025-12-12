<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
                {{ __('Seller Dashboard') }} <span class="text-gray-400 mx-2">//</span> <span class="text-hubbub-pink">{{ $store->name }}</span>
            </h2>
            <div>
                 @if(!$store->is_verified)
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-header font-bold uppercase px-3 py-1 border border-yellow-200 shadow-sm">Pending Verification</span>
                 @else
                    <span class="bg-green-100 text-green-800 text-xs font-header font-bold uppercase px-3 py-1 border border-green-200 shadow-sm">Verified Store</span>
                 @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Stats Cards --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-gray-400 text-[10px] font-bold font-sans uppercase mb-2 tracking-widest">Total Sales</div>
                    <div class="text-3xl font-sans font-bold text-hubbub-pink">Rp {{ number_format($sales, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-gray-400 text-[10px] font-bold font-sans uppercase mb-2 tracking-widest">Total Orders</div>
                    <div class="text-3xl font-sans font-bold text-hubbub-black">{{ $orderCount }}</div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div class="text-gray-400 text-[10px] font-bold font-sans uppercase mb-4 tracking-widest">Quick Actions</div>
                    <div class="flex space-x-3">
                        <a href="{{ route('seller.products.create') }}" class="flex-1 bg-hubbub-black text-white text-center px-4 py-3 text-xs font-bold font-sans uppercase rounded-full hover:bg-hubbub-pink transition-colors">Add Product</a>
                        <a href="{{ route('seller.balance') }}" class="flex-1 border border-hubbub-black text-hubbub-black text-center px-4 py-3 text-xs font-bold font-sans uppercase rounded-full hover:bg-hubbub-black hover:text-white transition-colors">Balance</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Sidebar Navigation --}}
                <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm h-fit">
                    <nav class="flex flex-col space-y-1">
                        <a href="{{ route('seller.dashboard') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.dashboard') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Dashboard</a>
                        <a href="{{ route('seller.products') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.products*') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Products</a>
                        <a href="{{ route('seller.orders') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.orders*') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Orders</a>
                        <a href="{{ route('seller.balance') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.balance*') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Balance & History</a>
                        <a href="{{ route('seller.withdrawals') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.withdrawals*') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Withdrawals</a>
                        <a href="{{ route('seller.profile') }}" class="block px-6 py-3 font-sans font-bold uppercase text-xs rounded-xl {{ request()->routeIs('seller.profile*') ? 'bg-pink-50 text-hubbub-pink' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">Store Settings</a>
                    </nav>
                </div>

                {{-- Main Content Area --}}
                <div class="md:col-span-3 bg-white p-10 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center min-h-[400px]">
                    <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-hubbub-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-sans font-bold uppercase text-hubbub-black mb-3">Welcome back, {{ $store->name }}!</h3>
                    <p class="text-gray-400 font-sans max-w-md mx-auto leading-relaxed">Ready to elevate your beauty business? Use the sidebar to manage your products, track orders, and withdraw your earnings.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
