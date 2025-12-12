<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="font-sans text-3xl font-bold text-hubbub-black uppercase tracking-widest mb-2">Create Account</h2>
        <p class="text-gray-400 font-sans text-sm">Join Sillia Beauty Market today</p>
    </div>

    <!-- Google Login (Optional for Register too, consistent) -->
    <a href="{{ route('google.login') }}" class="w-full bg-white border border-gray-200 text-gray-700 font-sans font-bold text-xs uppercase tracking-wide py-4 rounded-full hover:bg-gray-50 hover:border-hubbub-pink hover:text-hubbub-pink transition-all flex items-center justify-center gap-3 mb-8 shadow-sm group hover:-translate-y-1 duration-300">
        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.11c-.22-.66-.35-1.36-.35-2.11s.13-1.45.35-2.11V7.05H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.95l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.05l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
        Sign up with Google
    </a>
    
    <div class="relative flex py-2 items-center mb-8">
        <div class="flex-grow border-t border-gray-100"></div>
        <span class="flex-shrink-0 mx-4 text-gray-300 text-xs font-bold uppercase tracking-widest">or</span>
        <div class="flex-grow border-t border-gray-100"></div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="hello@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <x-input-label for="password" :value="__('Password')" class="font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" 
                            type="password" 
                            name="password" 
                            required autocomplete="new-password"
                            placeholder="••••••••" />
             <button type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.innerText = p.type === 'password' ? 'Show' : 'Hide';" class="absolute right-4 top-[42px] text-[10px] text-hubbub-pink font-bold hover:text-pink-700 uppercase tracking-widest transition-colors">
                Show
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
             <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 uppercase tracking-widest text-xs transform hover:-translate-y-1 duration-300">
                {{ __('Register') }}
            </button>
        </div>
        
        <div class="flex items-center justify-center space-x-2 text-xs font-sans mt-8 font-medium">
             <span class="text-gray-400">Already have an account?</span>
            <a class="text-hubbub-pink hover:text-pink-700 font-bold uppercase tracking-wide" href="{{ route('login') }}">
                {{ __('Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
