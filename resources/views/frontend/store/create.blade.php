@extends('layouts.frontend')

@section('title', 'Open Your Shop')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('logopink.png') }}" alt="Koré" class="h-16 mx-auto mb-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Your Shop</h1>
            <p class="text-gray-600">Fill in the details below to start selling on Koré</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
            <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Shop Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Shop Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="Enter your shop name" 
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Logo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Shop Logo
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <div id="logo-preview" class="w-24 h-24 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="file" 
                                    name="logo" 
                                    id="logo-input"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-k-pink file:text-white hover:file:bg-pink-600 cursor-pointer"
                                    accept="image/*"
                                >
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Shop Description
                        </label>
                        <textarea 
                            name="about" 
                            rows="4" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="Tell customers about your shop..."
                        >{{ old('about') }}</textarea>
                        @error('about')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="e.g., 08123456789"
                            value="{{ old('phone') }}"
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="city" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="e.g., Jakarta, Surabaya, Bandung"
                            value="{{ old('city') }}"
                            required
                        >
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Full Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Address
                        </label>
                        <textarea 
                            name="address" 
                            rows="3" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="Enter your complete shop address..."
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Postal Code
                        </label>
                        <input 
                            type="text" 
                            name="postal_code" 
                            class="w-full rounded-lg border-gray-300 focus:ring-k-pink focus:border-k-pink" 
                            placeholder="e.g., 12345"
                            value="{{ old('postal_code') }}"
                            maxlength="10"
                        >
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-4">
                            <span class="text-red-500">*</span> Required fields
                        </p>
                        
                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-k-pink text-white font-bold py-3 px-6 rounded-lg hover:bg-pink-600 transition-colors duration-200 flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Shop
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Already have a shop? 
                <a href="{{ route('store.index') }}" class="text-k-pink font-semibold hover:underline">Go to Dashboard</a>
            </p>
        </div>
    </div>
</div>

<!-- Logo Preview Script -->
<script>
document.getElementById('logo-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logo-preview');
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" alt="Logo preview">';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
