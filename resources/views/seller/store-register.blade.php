@extends('layouts.customer')

@section('title', 'Become a Seller')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2" style="color: #252B42;">Become a Seller</h1>
                <p class="text-gray-600">Start selling your products on our platform</p>
            </div>

            {{-- Registration Form --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Store Name --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                            Store Name <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="input-field @error('name') border-danger-500 @enderror"
                            placeholder="e.g., XIV Collective"
                            required>
                        @error('name')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- About Store --}}
                    <div class="mb-6">
                        <label for="about" class="block text-sm font-bold text-gray-700 mb-2">
                            About Your Store <span class="text-danger-500">*</span>
                        </label>
                        <textarea 
                            id="about" 
                            name="about" 
                            rows="4"
                            class="input-field @error('about') border-danger-500 @enderror"
                            placeholder="Describe your store, products, and brand identity..."
                            required>{{ old('about') }}</textarea>
                        @error('about')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                            Phone Number <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            class="input-field @error('phone') border-danger-500 @enderror"
                            placeholder="08123456789"
                            required>
                        @error('phone')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="mb-6">
                        <label for="city" class="block text-sm font-bold text-gray-700 mb-2">
                            City <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="city" 
                            name="city" 
                            value="{{ old('city') }}"
                            class="input-field @error('city') border-danger-500 @enderror"
                            placeholder="Jakarta"
                            required>
                        @error('city')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">
                            Store Address <span class="text-danger-500">*</span>
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3"
                            class="input-field @error('address') border-danger-500 @enderror"
                            placeholder="Complete store address..."
                            required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Postal Code --}}
                    <div class="mb-6">
                        <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">
                            Postal Code <span class="text-danger-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="postal_code" 
                            name="postal_code" 
                            value="{{ old('postal_code') }}"
                            class="input-field @error('postal_code') border-danger-500 @enderror"
                            placeholder="12345"
                            required>
                        @error('postal_code')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Logo Upload (Optional) --}}
                    <div class="mb-6">
                        <label for="logo" class="block text-sm font-bold text-gray-700 mb-2">
                            Store Logo (Optional)
                        </label>
                        <input 
                            type="file" 
                            id="logo" 
                            name="logo" 
                            accept="image/*"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100
                                cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Max 2MB. Recommended: 500x500px</p>
                        @error('logo')
                            <p class="text-danger-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="mb-6">
                        <label class="flex items-start gap-2">
                            <input 
                                type="checkbox" 
                                name="terms" 
                                class="mt-1 rounded border-gray-300 text-primary-500 focus:ring-primary-500"
                                required>
                            <span class="text-sm text-gray-600">
                                I agree to the <a href="#" class="text-primary-500 hover:underline">Terms & Conditions</a> and <a href="#" class="text-primary-500 hover:underline">Seller Policy</a>
                            </span>
                        </label>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary flex-1">
                            Register Store
                        </button>
                        <a href="{{ route('home') }}" class="btn-outline flex-1 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            {{-- Info Box --}}
            <div class="mt-6 bg-primary-50 border border-primary-200 rounded-lg p-6">
                <h3 class="font-bold text-primary-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    What happens after registration?
                </h3>
                <ul class="text-sm text-primary-700 space-y-1 ml-7">
                    <li>• Your store will be reviewed by our admin team</li>
                    <li>• Verification usually takes 1-2 business days</li>
                    <li>• You'll receive notification once approved</li>
                    <li>• After verification, you can start adding products</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
