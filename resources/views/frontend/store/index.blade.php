@extends('layouts.frontend')

@section('title', 'Seller Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $store->name }}</h1>
                <p class="text-gray-500 mt-1">Manage your products and orders</p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <a href="{{ route('seller.products.create') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Product</span>
            </a>
            
            <a href="{{ route('seller.categories.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('seller.orders.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>Orders</span>
            </a>
            
            <a href="{{ route('seller.financials.index') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-green-50 border-2 border-green-200 text-green-700 font-bold rounded-lg hover:bg-green-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Financials</span>
            </a>
            
            <a href="{{ route('store.edit') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-50 border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Settings</span>
            </a>
        </div>
    </div>


    <!-- Verification Status Alert -->
    @if(!$store->is_verified)
        <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-yellow-800 mb-1">Store Pending Verification</h3>
                    <p class="text-sm text-yellow-700 mb-3">
                        Your store is currently pending admin verification. You will be able to add products and start selling once your store has been approved by our team.
                    </p>
                    <p class="text-xs text-yellow-600">
                        This process usually takes 1-2 business days. We'll notify you once your store is verified.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-6 rounded-lg">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-green-800 mb-1">Store Verified ✓</h3>
                    <p class="text-sm text-green-700">
                        Your store has been verified! You can now add products and start selling.
                    </p>
                </div>
            </div>
        </div>
    @endif


    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-gray-500 text-sm font-medium">Total Balance</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($store->storeBalance->balance ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-gray-500 text-sm font-medium">Total Products</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $store->products()->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-gray-500 text-sm font-medium">Pending Orders</h3>
            <p class="text-3xl font-bold text-k-pink mt-2">0</p>
        </div>
    </div>

    <!-- Products Table -->
    <h3 class="text-xl font-bold text-gray-900 mb-6">Your Products</h3>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($store->products as $product)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden">
                                @if($product->productImages->first())
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <span class="font-bold text-gray-900">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $product->stock }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 text-sm font-bold">Edit</a>
                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($store->products->isEmpty())
            <div class="p-8 text-center text-gray-500">
                You haven't uploaded any products yet.
            </div>
        @endif
    </div>
</div>
@endsection
