@extends('layouts.admin')

@section('title', 'Store Verification')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pending Store Verifications</h1>
            <p class="text-gray-600">Review and approve new store registrations</p>
        </div>
        <a href="{{ route('admin.stores.all') }}" class="btn-outline">View All Stores</a>
    </div>

    @if($pendingStores->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pendingStores as $store)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $store->name }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($store->about, 50) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $store->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $store->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $store->city }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $store->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.stores.show', $store->id) }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm">
                                Review →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $pendingStores->links() }}
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">No pending stores</h3>
        <p class="text-gray-500">All store registrations have been reviewed</p>
    </div>
    @endif
</div>
@endsection
