<x-guest-layout>
    <!-- Header Form -->
    <div class="mb-6">
        <p class="text-xs font-semibold tracking-wide text-emerald-600 uppercase mb-1">
            Lupa password
        </p>
        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
            Reset password akun KiloMeter
        </h2>
        <p class="mt-2 text-sm text-gray-500">
            Masukkan email yang terdaftar di KiloMeter. Kami akan mengirimkan link untuk mengatur ulang password kamu.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2 space-y-3">
            <x-primary-button class="w-full justify-center">
                Kirim link reset password
            </x-primary-button>

            <p class="text-sm text-center text-gray-600">
                Ingat password kamu?
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">
                    Kembali ke halaman login
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
