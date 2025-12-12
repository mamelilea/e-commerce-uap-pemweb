<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label for="password" class="block font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <label for="password_confirmation" class="block font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1">{{ __('Confirm Password') }}</label>

            <input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 uppercase tracking-widest text-xs transform hover:-translate-y-1 duration-300">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
