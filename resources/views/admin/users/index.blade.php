@extends('layouts.admin')

@section('title', 'User & Store Management')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-white mb-2">User & Store Management</h1>
        <p class="text-gray-400">Manage all users and stores in the system</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Users</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalUsers }}</h3>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Stores</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $totalStores }}</h3>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Verified Stores</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $verifiedStores }}</h3>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Pending Stores</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $pendingStores }}</h3>
                </div>
                <div class="bg-yellow-500/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-gray-800 rounded-lg border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">All Users</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Store</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-6 py-4 text-sm text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->isAdmin())
                                <span class="px-2 py-1 text-xs font-semibold bg-red-500/20 text-red-400 rounded">Admin</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-blue-500/20 text-blue-400 rounded">Member</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">
                            @if($user->store)
                                <span class="text-green-400">{{ $user->store->name }}</span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if(!$user->isAdmin())
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                            @else
                                <span class="text-gray-600">Protected</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-700">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Stores Table --}}
    <div class="bg-gray-800 rounded-lg border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">All Stores</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Store Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">City</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($stores as $store)
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-6 py-4 text-sm text-white font-medium">{{ $store->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $store->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $store->city }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($store->is_verified)
                                <span class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded">Verified</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-500/20 text-yellow-400 rounded">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $store->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.stores.show', $store) }}" class="text-blue-400 hover:text-blue-300">View</a>
                            <form action="{{ route('admin.stores.delete', $store) }}" method="POST" class="inline" onsubmit="return confirm('Delete this store?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No stores found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-700">
            {{ $stores->links() }}
        </div>
    </div>
</div>
@endsection
