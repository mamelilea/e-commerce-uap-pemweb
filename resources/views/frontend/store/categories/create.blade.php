@extends('layouts.frontend')

@section('title', 'Create Category')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <a href="{{ route('seller.categories.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-k-pink mb-3 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Categories
            </a>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Create New Category</h1>
            <p class="text-gray-500 mt-2">Organize your products with a new category.</p>
        </div>
    </div>

    <form action="{{ route('seller.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">01</span>
                        Category Details
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="e.g., K-Pop Albums" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tagline (Optional)</label>
                            <input type="text" name="tagline" value="{{ old('tagline') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="e.g., Latest releases from your favorite artists">
                            @error('tagline')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="5" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4" placeholder="Describe this category in detail..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Media -->
            <div class="space-y-8">
                 <!-- Hierarchy Card -->
                 <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-pink-50 text-k-pink flex items-center justify-center mr-3 text-sm">02</span>
                        Hierarchy
                    </h2>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Parent Category</label>
                         <select name="parent_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-k-pink/20 focus:border-k-pink transition-all py-3 px-4">
                            <option value="">None (Main Category)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500">Select a parent to make this a subcategory.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gray-900 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-gray-800 transition-all transform hover:-translate-y-0.5">
                        Create Category
                    </button>
                    <a href="{{ route('seller.categories.index') }}" class="px-6 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
