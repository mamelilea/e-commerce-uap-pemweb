@extends('layouts.frontend')

@section('title', 'My Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Products</h1>
            <p class="text-gray-500 mt-2">Manage your product catalog.</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl font-bold text-white hover:bg-gray-800 transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Product
        </a>
    </div>

    <!-- Product Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Total Products</div>
            <div class="text-3xl font-bold text-gray-900">{{ $products->total() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
             <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Total Stock</div>
            <div class="text-3xl font-bold text-gray-900">{{ $products->sum('stock') }}</div>
        </div>
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
             <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Total Value</div>
            <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($products->sum(function($product){ return $product->price * $product->stock; }), 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($products->isEmpty())
            <div class="text-center py-16 px-6">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Products Yet</h3>
                <p class="text-sm mb-4">Start selling by adding your first product.</p>
                <a href="{{ route('seller.products.create') }}" class="inline-block px-4 py-2 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors">
                    Add First Product
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Stock</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                        @if($product->getThumbnailUrl())
                                            <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($product->about, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $product->productCategory->name ?? 'Uncategorized' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                             <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                               <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                   Active
                               </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product permanently?');">
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
            </div>
            
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
