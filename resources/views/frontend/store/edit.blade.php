@extends('layouts.frontend')

@section('title', 'Edit Store Profile')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-6">
        <a href="{{ route('store.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Edit Store Profile</h2>

        <form action="{{ route('store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Logo & Banner Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-gray-100">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Store Logo</label>
                    <div class="flex items-start gap-4">
                        <div class="w-24 h-24 rounded-full bg-gray-100 overflow-hidden border-2 border-gray-200 flex-shrink-0">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover" id="logoPreview">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400" id="logoPreview">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo" accept="image/*" onchange="previewLogo(event)" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-k-pink file:text-white hover:file:bg-pink-600 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Banner -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Store Banner</label>
                    <div class="space-y-3">
                        @if($store->banner)
                            <div class="w-full h-32 rounded-lg bg-gray-100 overflow-hidden border-2 border-gray-200">
                                <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover" id="bannerPreview">
                            </div>
                        @endif
                        <input type="file" name="banner" accept="image/*" onchange="previewBanner(event)" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-k-pink file:text-white hover:file:bg-pink-600 cursor-pointer">
                        <p class="text-xs text-gray-500">Recommended: 1200x400px, PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Store Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $store->name) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20 @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-bold text-gray-700 mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city', $store->city) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20 @error('city') border-red-500 @enderror" required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $store->phone) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20" placeholder="e.g., +62 812-3456-7890">
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $store->postal_code) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20" placeholder="e.g., 12345">
                    </div>
                </div>
            </div>

            <!-- Address & About -->
            <div class="space-y-6">
                <div>
                    <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Full Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20" placeholder="Enter your complete store address">{{ old('address', $store->address) }}</textarea>
                </div>

                <div>
                    <label for="about" class="block text-sm font-bold text-gray-700 mb-2">About Store</label>
                    <textarea name="about" id="about" rows="5" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-k-pink focus:ring-2 focus:ring-k-pink/20" placeholder="Tell customers about your store...">{{ old('about', $store->about) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Describe your store, what you sell, and what makes you unique</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600 transition-colors">
                    Delete Store
                </button>
                <div class="flex gap-4">
                    <a href="{{ route('store.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-600 transition-colors shadow-md">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="deleteForm" action="{{ route('store.destroy') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

<script>
function previewLogo(event) {
    const preview = document.getElementById('logoPreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        }
        reader.readAsDataURL(file);
    }
}

function previewBanner(event) {
    const preview = document.getElementById('bannerPreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (!preview) {
                const container = event.target.previousElementSibling;
                if (container && container.tagName === 'DIV') {
                    container.querySelector('img').src = e.target.result;
                }
            } else {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
    }
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete your store? This action cannot be undone and will remove all your products and data.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection
