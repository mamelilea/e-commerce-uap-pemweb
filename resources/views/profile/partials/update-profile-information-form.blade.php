<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-yellow-50 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-medium hover:text-yellow-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-400 transition-colors">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                   class="text-sm text-green-600 font-medium">
                    {{ __('Saved successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>
