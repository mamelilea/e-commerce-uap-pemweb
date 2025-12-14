@extends('layouts.frontend')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-k-grey/30">
    <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-xl overflow-hidden sm:rounded-3xl border border-gray-100 relative">
        <!-- Decorative Circle -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-k-pink/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-k-blue/20 rounded-full blur-2xl"></div>

        <div class="text-center mb-10 relative z-10">
            <img src="{{ asset('logopink.png') }}" class="w-20 h-auto mx-auto mb-6" alt="Koré">
            <h1 class="text-3xl font-bold text-gray-900 font-sans">Welcome Back!</h1>
            <p class="text-gray-500 mt-2">Sign in to continue your aesthetic journey.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="relative z-10 space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 ml-1 mb-1">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-k-pink focus:ring-k-pink py-3 px-4 bg-gray-50 text-gray-900" 
                    placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 ml-1 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-k-pink focus:ring-k-pink py-3 px-4 bg-gray-50 text-gray-900"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-k-pink shadow-sm focus:ring-k-pink" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-500 hover:text-k-pink font-semibold" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-k-pink hover:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-k-pink transition-all transform hover:-translate-y-1">
                Sign in
            </button>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-bold text-k-pink hover:text-k-blue transition-colors">Sign up</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
