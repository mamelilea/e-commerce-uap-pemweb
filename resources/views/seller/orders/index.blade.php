@extends('layouts.seller')

@section('title', 'Orders')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" style="color: #252B42;">Orders</h1>
            <p class="text-gray-600">Manage customer orders</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('seller.orders.index') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ !request('status') ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Orders
            </a>
            <a href="{{ route('seller.orders.index', ['status' => 'paid']) }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'paid' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                New Orders
            </a>
            <a href="{{ route('seller.orders.index', ['status' => 'processed']) }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'processed' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Processing
            </a>
            <a href="{{ route('seller.orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'shipped' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Shipped
            </a>
            <a href="{{ route('seller.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'completed' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Completed
            </a>
        </div>
    </div>

    {{-- Orders Table --}}
    @if($orders->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="text-primary-500 font-bold hover:underline">
                            #{{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $order->buyer->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $order->buyer->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $order->transactionDetails->count() }} items
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-gray-900">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-bold rounded-full
                            {{ $order->payment_status === 'completed' ? 'bg-success-100 text-success-700' : '' }}
                            {{ $order->payment_status === 'paid' ? 'bg-warning-100 text-warning-700' : '' }}
                            {{ $order->payment_status === 'processed' ? 'bg-primary-100 text-primary-700' : '' }}
                            {{ $order->payment_status === 'shipped' ? 'bg-secondary-100 text-secondary-700' : '' }}
                            {{ $order->payment_status === 'unpaid' ? 'bg-gray-100 text-gray-700' : '' }}
                            {{ $order->payment_status === 'cancelled' ? 'bg-danger-100 text-danger-700' : '' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="text-primary-500 hover:text-primary-600 font-medium">
                            View Details →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">No orders found</h3>
        <p class="text-gray-500">You don't have any {{ request('status') ? request('status') : '' }} orders yet</p>
    </div>
    @endif
</div>
@endsection
