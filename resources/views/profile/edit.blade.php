<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            

            <div class="w-full md:w-1/4 space-y-6">

                <div class="bg-white p-4 rounded-lg shadow border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden flex-shrink-0">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500 font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-gray-900 truncate">{{ Auth::user()->name }}</h3>
                        @if(Auth::user()->store)
                            <p class="text-xs text-green-600 flex items-center gap-1">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                Verified Store
                            </p>
                        @else
                            <p class="text-xs text-gray-500">Member</p>
                        @endif
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">
                        <a href="#" class="px-4 py-3 bg-gray-50 text-indigo-600 font-bold border-l-4 border-indigo-600 text-sm">Biodata Diri</a>
                        <a href="{{ route('orders.history') }}" class="px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-sm border-l-4 border-transparent">Daftar Transaksi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-red-600 text-sm border-l-4 border-transparent flex items-center gap-2">
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>


            <div class="w-full md:w-3/4 space-y-6">

                <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b px-6 py-4">
                        <h2 class="text-lg font-bold text-gray-900">Biodata Diri</h2>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>


                <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b px-6 py-4">
                        <h2 class="text-lg font-bold text-gray-900">Keamanan</h2>
                    </div>
                    <div class="p-6 space-y-8">
                        @include('profile.partials.update-password-form')
                        
                        <div class="pt-8 border-t">
                            <h3 class="text-md font-bold text-red-600 mb-4">Danger Zone</h3>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
