@extends('layouts.frontend')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">All Users</h1>
            <p class="text-gray-500 mt-1">Manage all registered users</p>
        </div>
        <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($users->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <p>No users found</p>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">User</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Store</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'seller' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'member' => 'bg-gray-100 text-gray-800 border-gray-200',
                                ];
                                $color = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold rounded-full border-2 {{ $color }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($user->store)
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->store->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($user->store->is_verified)
                                            <span class="text-green-600">✓ Verified</span>
                                        @else
                                            <span class="text-yellow-600">⏳ Pending</span>
                                        @endif
                                    </p>
                                </div>
                            @else
                                <span class="text-gray-400">No store</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user? This will also delete their store if they have one.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">Protected</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection
