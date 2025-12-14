@extends('layouts.frontend')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-k-grey/30">
    <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-xl overflow-hidden sm:rounded-3xl border border-gray-100 relative">
        <!-- Decorative Circle -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-k-pink/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-k-blue/20 rounded-full blur-2xl"></div>

        <div class="text-center mb-10 relative z-10">
            <img src="{{ asset('logopink.png') }}" class="w-20 h-auto mx-auto mb-6" alt="Koré">
            <h1 class="text-3xl font-bold text-gray-900 font-sans">Forgot Password?</h1>
            <p class="text-gray-500 mt-2 text-sm">No problem! Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 relative z-10">
                <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="relative z-10 space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 ml-1 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-k-pink focus:ring-k-pink py-3 px-4 bg-gray-50 text-gray-900" 
                    placeholder="you@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-k-pink hover:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-k-pink transition-all transform hover:-translate-y-1">
                Email Password Reset Link
            </button>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="font-bold text-k-pink hover:text-k-blue transition-colors">Sign in</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
