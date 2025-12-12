<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans font-bold text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('Store Verification') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                
                @if($stores->count() > 0)
                    <div class="overflow-hidden rounded-xl border border-gray-100">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Store Name</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Owner</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Details</th>
                                    <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($stores as $store)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-sans font-bold text-hubbub-black text-lg">{{ $store->name }}</div>
                                            <div class="text-[10px] text-gray-400 font-sans font-bold uppercase tracking-widest mt-1">{{ $store->city }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-hubbub-black font-sans text-sm">{{ $store->user->name }}</div>
                                            <span class="text-xs text-gray-400 font-sans">{{ $store->user->email }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="mb-1 text-xs text-gray-600 font-sans"><strong class="font-bold text-gray-800 uppercase tracking-wide">About:</strong> {{ Str::limit($store->about, 50) }}</p>
                                            <p class="text-xs text-gray-600 font-sans"><strong class="font-bold text-gray-800 uppercase tracking-wide">Address:</strong> {{ $store->address }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('admin.verification.approve', $store->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="group inline-flex items-center px-4 py-2 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-green-200">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.verification.reject', $store->id) }}" method="POST" onsubmit="return confirm('Reject and Delete Store?');">
                                                    @csrf
                                                    <button type="submit" class="group inline-flex items-center px-4 py-2 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-red-200">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="font-sans text-xl font-bold uppercase text-gray-400 mb-2">No pending verifications</p>
                        <p class="text-gray-400 text-sm font-sans">All stores are good to go.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
