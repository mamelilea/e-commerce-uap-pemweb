


<x-guest-layout>
    <!-- Kontainer utama dengan desain estetik ala SweetCake -->
    <div class="shadow-2xl rounded-3xl p-8 sm:p-10 w-full max-w-md
                bg-white/90  border-2 border-pink-100/70">

         <!-- Logo / Judul -->
            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold text-pink-500 drop-shadow-sm">
                    🍰 SweetCake Login
                </h1>
                <p class="text-pink-500 mt-2">
                    Selamat datang kembali di toko kue cantikmu 💕
                </p>
            </div>


        <!-- Session Status (Pesan berhasil/gagal) -->
        <x-auth-session-status class="mb-4 text-center text-sm font-medium text-green-600" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" class="text-pink-600 font-semibold" :value="('Email')" />
                <x-text-input id="email"
                    class="block w-full rounded-xl border-pink-300 focus:border-pink-500 focus:ring-pink-500 placeholder-pink-300/80 text-pink-700 p-3"
                    type="email" name="email" :value="old('email')" required autofocus
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-6">
                <x-input-label for="password" class="text-pink-700 font-bold mb-1" :value="('Kata Sandi')" />
                <x-text-input id="password"
                    class="block w-full rounded-xl border-pink-300 focus:border-pink-500 focus:ring-pink-500 text-pink-700 p-3"
                    type="password" name="password" required autocomplete="current-password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-6">
                <!-- Remember Me -->
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-pink-300 text-pink-500 shadow-sm focus:ring-pink-400">
                    <span class="ms-2 text-sm text-pink-600 font-medium select-none">{{ __('Ingat Saya') }}</span>
                </label>
                
                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="text-sm text-pink-500 hover:text-pink-700 hover:underline transition duration-150"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa Kata Sandi?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="mt-6 flex justify-between items-center">
                <button type="submit"
                    class="w-full bg-pink-500 text-white px-5 py-2 rounded-full font-semibold 
                           shadow-xl shadow-pink-300/60
                           hover:bg-pink-600 hover:shadow-2xl hover:shadow-pink-400/70
                           transition-all duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-pink-300">
                    Masuk ke Toko Kue
                </button>
            </div>
        </form>

        <!-- Footer / Link Daftar -->
        <p class="text-center text-sm text-pink-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="font-extrabold text-pink-600 hover:text-pink-700 hover:underline transition duration-150">
                Daftar di sini
            </a>
        </p>
    </div>
</x-guest-layout>
