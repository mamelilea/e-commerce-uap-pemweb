@extends('layouts.frontend')

@section('title', 'Manage Stores')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">All Stores</h1>
            <p class="text-gray-500 mt-1">Manage all registered stores</p>
        </div>
        <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($stores->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <p>No stores found</p>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Store</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Owner</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Registered</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($stores as $store)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-900">{{ $store->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $store->city }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $store->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $store->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($store->is_verified)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border-2 border-green-200">
                                    Verified
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full border-2 border-yellow-200">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $store->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if(!$store->is_verified)
                                    <form action="{{ route('admin.store.verify', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-bold text-sm">
                                            Verify
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.store.reject', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-bold text-sm">
                                            Unverify
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.store.delete', $store->id) }}" method="POST" onsubmit="return confirm('Delete this store? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $stores->links() }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif
@endsection
