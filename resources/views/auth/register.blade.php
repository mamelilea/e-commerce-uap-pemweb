<x-guest-layout>
    <!-- Header Form -->
    <div class="mb-6">
        <p class="text-xs font-semibold tracking-wide text-emerald-600 uppercase mb-1">
            Buat akun baru
        </p>
        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
            Daftar di KiloMeter
        </h2>
        <p class="mt-2 text-sm text-gray-500">
            Satu akun untuk menemukan berbagai koleksi sepatu terbaik untuk setiap langkahmu.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama lengkap kamu"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="username"
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <p class="mt-1 text-xs text-gray-500">
                Gunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
            </p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi password" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Tulis ulang password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2 space-y-3">
            <x-primary-button class="w-full justify-center">
                Buat akun
            </x-primary-button>

            <p class="text-sm text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
