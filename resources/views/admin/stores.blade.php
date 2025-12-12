<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans font-bold text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('Manage Stores') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Store Details</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Owner</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Joined</th>
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
                                        @if($store->is_verified)
                                            <span class="inline-flex px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold font-sans text-gray-400 uppercase tracking-wide">
                                        {{ $store->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store? This will also delete all products associated with it.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="group inline-flex items-center px-4 py-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-red-200">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stores->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
