@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600">Platform overview and management</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-primary-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Stores</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_stores'] }}</p>
                    <p class="text-xs text-success-600 mt-1">{{ $stats['verified_stores'] }} verified</p>
                </div>
                <div class="bg-secondary-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Actions</p>
                    <p class="text-3xl font-bold text-warning-600">{{ $stats['pending_stores'] + $stats['pending_withdrawals'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['pending_stores'] }} stores, {{ $stats['pending_withdrawals'] }} withdrawals</p>
                </div>
                <div class="bg-warning-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Pending Stores --}}
    @if($pendingStores->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Pending Store Verifications</h2>
            <a href="{{ route('admin.stores.index') }}" class="text-primary-500 hover:underline text-sm font-medium">View All →</a>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($pendingStores as $store)
            <div class="p-6 flex items-center justify-between hover:bg-gray-50">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900">{{ $store->name }}</h3>
                    <p class="text-sm text-gray-600">Owner: {{ $store->user->name }} ({{ $store->user->email }})</p>
                    <p class="text-xs text-gray-500 mt-1">Registered: {{ $store->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.stores.show', $store->id) }}" class="btn-outline text-sm">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Pending Withdrawals --}}
    @if($pendingWithdrawals->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Pending Withdrawal Requests</h2>
            <a href="{{ route('admin.withdrawals.index') }}" class="text-primary-500 hover:underline text-sm font-medium">View All →</a>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($pendingWithdrawals as $withdrawal)
            <div class="p-6 flex items-center justify-between hover:bg-gray-50">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="font-bold text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</h3>
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-warning-100 text-warning-700">Pending</span>
                    </div>
                    <p class="text-sm text-gray-600">Store: {{ $withdrawal->storeBalance->store->name }}</p>
                    <p class="text-xs text-gray-500">{{ $withdrawal->bank_name }} - {{ $withdrawal->bank_account_number }}</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-success text-sm">Approve</button>
                    </form>
                    <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" class="inline" onsubmit="return confirm('Reject this withdrawal?')">
                        @csrf
                        <button type="submit" class="btn-outline text-sm">Reject</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($pendingStores->count() == 0 && $pendingWithdrawals->count() == 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-success-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">All caught up!</h3>
        <p class="text-gray-500">No pending actions at the moment</p>
    </div>
    @endif
</div>
@endsection
