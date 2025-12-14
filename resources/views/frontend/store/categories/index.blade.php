@extends('layouts.frontend')

@section('title', 'Product Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Product Categories</h1>
            <p class="text-gray-500 mt-1">Manage your product categories</p>
        </div>
        <a href="{{ route('seller.categories.create') }}" class="px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors shadow-md">
            + Add Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($categories->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Categories Yet</h3>
                <p class="text-sm mb-4">Create categories to organize your products</p>
                <a href="{{ route('seller.categories.create') }}" class="inline-block px-4 py-2 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600">
                    Create First Category
                </a>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $category->name }}</p>
                                    @if($category->tagline)
                                        <p class="text-xs text-gray-500">{{ $category->tagline }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                            {{ Str::limit($category->description, 100) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $category->products->count() }} products
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('seller.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('seller.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if($category->children->isNotEmpty())
                        @foreach($category->children as $child)
                        <tr class="hover:bg-gray-50 bg-gray-50/50">
                            <td class="px-6 py-4 pl-12">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $child->name }}</p>
                                        @if($child->tagline)
                                            <p class="text-xs text-gray-500">{{ $child->tagline }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ Str::limit($child->description, 80) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $child->products->count() }} products
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('seller.categories.edit', $child->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('seller.categories.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
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
                    @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif
@endsection
