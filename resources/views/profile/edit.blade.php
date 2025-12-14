@extends('layouts.frontend')

@section('title', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Profile</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 mx-auto flex items-center justify-center text-white text-3xl font-bold mb-4">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <nav class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-pink-50 text-k-pink font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile Settings
                        </a>
                        <a href="{{ route('history.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Wishlist
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
