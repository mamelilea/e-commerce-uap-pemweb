@extends('layouts.seller')

@section('title', 'Seller Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold" style="color: #252B42;">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->store->products->count() }}</p>
                </div>
                <div class="bg-primary-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending Orders</p>
                    @php 
                        $pendingOrders = auth()->user()->store->transactions()->whereIn('payment_status', ['paid', 'processed'])->count();
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                </div>
                <div class="bg-warning-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Available Balance</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(auth()->user()->store->storeBalance->balance ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-success-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    @php 
                        $totalRevenue = auth()->user()->store->transactions()->where('payment_status', 'completed')->sum('grand_total');
                    @endphp
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-secondary-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-lg font-bold mb-4" style="color: #252B42;">Quick Actions</h2>
        <div class="flex gap-4">
            <a href="{{ route('seller.products.create') }}" class="btn-primary">
                + Add New Product
            </a>
            <a href="{{ route('seller.orders.index') }}" class="btn-outline">
                View Orders
            </a>
            <a href="{{ route('seller.withdrawals.index') }}" class="btn-secondary">
                Request Withdrawal
            </a>
        </div>
    </div>

    {{-- Recent Orders --}}
    @php
        $recentOrders = auth()->user()->store->transactions()->with('buyer.user')->latest()->take(5)->get();
    @endphp
    @if($recentOrders->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold" style="color: #252B42;">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('seller.orders.show', $order->id) }}" class="text-primary-500 font-medium hover:underline">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->buyer->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-bold rounded-full
                                {{ $order->payment_status === 'completed' ? 'bg-success-100 text-success-700' : '' }}
                                {{ $order->payment_status === 'paid' ? 'bg-primary-100 text-primary-700' : '' }}
                                {{ $order->payment_status === 'shipped' ? 'bg-secondary-100 text-secondary-700' : '' }}
                                {{ $order->payment_status === 'unpaid' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
