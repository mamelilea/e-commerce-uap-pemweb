<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink" 
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink" 
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-k-pink focus:ring-k-pink" 
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-k-pink text-white font-bold rounded-lg hover:bg-pink-400 transition-colors">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                   class="text-sm text-green-600 font-medium">
                    {{ __('Password updated successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>
