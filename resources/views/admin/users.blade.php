<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans font-bold text-3xl text-hubbub-black leading-tight tracking-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">ID</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Name</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Email</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Role</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Joined</th>
                                <th class="px-6 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-xs font-mono font-bold text-gray-400">
                                        #{{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-hubbub-black font-sans">{{ $user->name }}</div>
                                        @if($user->store)
                                            <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] font-medium bg-pink-50 text-hubbub-pink uppercase tracking-wide">
                                                Store: {{ $user->store->name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-sans text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full {{ $user->role == 'admin' ? 'bg-hubbub-black text-white' : 'bg-gray-100 text-gray-500' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold font-sans text-gray-400 uppercase tracking-wide">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="group inline-flex items-center px-4 py-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-full text-[10px] font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow-red-200">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
