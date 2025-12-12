<x-guest-layout>
    <div class="mb-6 text-[10px] text-gray-400 font-sans font-bold uppercase tracking-widest text-center leading-relaxed">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-bold text-hubbub-pink text-xs uppercase tracking-wide text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col items-stretch gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="w-full bg-hubbub-black text-white font-sans font-bold py-4 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 uppercase tracking-widest text-xs transform hover:-translate-y-1 duration-300">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full text-center text-xs text-gray-400 font-sans font-bold uppercase tracking-widest hover:text-hubbub-pink transition-colors">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
