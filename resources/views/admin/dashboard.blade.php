<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans font-bold text-3xl text-hubbub-black leading-tight tracking-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Total Users -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 relative overflow-hidden group hover:-translate-y-1">
                     <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                     </div>
                     <div class="text-gray-400 text-[10px] font-bold font-sans uppercase tracking-widest mb-2">Total Users</div>
                     <div class="text-5xl font-sans font-bold text-hubbub-black group-hover:text-hubbub-pink transition-colors tracking-tight">{{ $usersCount }}</div>
                </div>

                <!-- Total Stores -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 relative overflow-hidden group hover:-translate-y-1">
                     <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                     </div>
                     <div class="text-gray-400 text-[10px] font-bold font-sans uppercase tracking-widest mb-2">Total Stores</div>
                     <div class="text-5xl font-sans font-bold text-hubbub-black group-hover:text-hubbub-pink transition-colors tracking-tight">{{ $storesCount }}</div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 relative overflow-hidden group hover:-translate-y-1">
                     <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                     </div>
                     <div class="text-gray-400 text-[10px] font-bold font-sans uppercase tracking-widest mb-2">Total Transactions</div>
                     <div class="text-5xl font-sans font-bold text-hubbub-black group-hover:text-hubbub-pink transition-colors tracking-tight">{{ $transactionsCount }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-gray-100">
                <h3 class="text-xl font-sans font-bold text-hubbub-black mb-8 uppercase tracking-wide border-b border-gray-100 pb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.verification') }}" class="group inline-flex items-center gap-2 bg-hubbub-pink text-white font-sans font-bold uppercase text-xs px-8 py-4 rounded-full hover:bg-pink-600 shadow-lg shadow-pink-200 hover:-translate-y-1 transition-all duration-300 tracking-wider">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verify Stores
                    </a>
                    <a href="{{ route('admin.withdrawals') }}" class="group inline-flex items-center gap-2 bg-white text-gray-600 font-sans font-bold uppercase text-xs px-8 py-4 rounded-full border border-gray-200 hover:border-hubbub-pink hover:text-hubbub-pink hover:bg-pink-50 hover:-translate-y-1 transition-all duration-300 tracking-wider shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:text-hubbub-pink transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm3-6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                         Manage Withdrawals
                    </a>
                    <a href="{{ route('admin.stores') }}" class="group inline-flex items-center gap-2 bg-white text-gray-600 font-sans font-bold uppercase text-xs px-8 py-4 rounded-full border border-gray-200 hover:border-hubbub-pink hover:text-hubbub-pink hover:bg-pink-50 hover:-translate-y-1 transition-all duration-300 tracking-wider shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:text-hubbub-pink transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                         </svg>
                         Manage Stores
                    </a>
                    <a href="{{ route('admin.users') }}" class="group inline-flex items-center gap-2 bg-white text-gray-600 font-sans font-bold uppercase text-xs px-8 py-4 rounded-full border border-gray-200 hover:border-hubbub-pink hover:text-hubbub-pink hover:bg-pink-50 hover:-translate-y-1 transition-all duration-300 tracking-wider shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:text-hubbub-pink transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
