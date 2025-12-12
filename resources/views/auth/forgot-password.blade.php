<x-guest-layout>
    <div class="mb-6 text-[10px] text-gray-400 font-sans font-bold uppercase tracking-widest text-center leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    
    <x-auth-session-status class="mb-6 font-bold text-hubbub-pink text-xs uppercase tracking-wide text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

       
        <div>
            <label for="email" class="block font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 uppercase tracking-widest text-xs transform hover:-translate-y-1 duration-300">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
