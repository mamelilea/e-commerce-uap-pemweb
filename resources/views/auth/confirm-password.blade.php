<x-guest-layout>
    <div class="mb-6 text-[10px] text-gray-400 font-sans font-bold uppercase tracking-widest text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block font-sans font-bold text-xs uppercase tracking-wide text-gray-400 mb-2 ml-1">{{ __('Password') }}</label>

            <input id="password" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl p-4 font-sans focus:border-hubbub-pink focus:ring-hubbub-pink focus:bg-white shadow-inner transition-all duration-300"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Current Password">

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide" />
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 uppercase tracking-widest text-xs transform hover:-translate-y-1 duration-300">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
