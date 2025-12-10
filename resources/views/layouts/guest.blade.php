<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KiloMeter') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-5xl grid gap-8 md:grid-cols-2">
                {{-- Panel Brand KiloMeter --}}
                <div class="hidden md:flex flex-col justify-between rounded-2xl bg-slate-900/60 border border-slate-700/60 p-8 shadow-2xl">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-slate-800 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('KMNeonLogo.svg') }}" alt="KiloMeter" class="h-12 w-12 object-cover">
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold tracking-tight">KiloMeter</h1>
                                <p class="text-sm text-slate-300">E-Commerce Sepatu Pilihanmu</p>
                            </div>
                        </div>

                        <div class="mt-10 space-y-4">
                            <p class="text-sm text-slate-200 leading-relaxed">
                                Temukan berbagai koleksi sepatu kekinian, nyaman dipakai, dan siap menemani setiap langkahmu.
                            </p>

                            <ul class="text-sm text-slate-300 space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    <span>Brand original & berkualitas</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    <span>Transaksi aman dan nyaman</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    <span>Langkah pasti untuk gaya sehari-hari</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-700/70 mt-6">
                        <p class="text-xs text-slate-400">
                            &copy; {{ date('Y') }} KiloMeter. All rights reserved.
                        </p>
                    </div>
                </div>

                {{-- Panel Form Auth --}}
                <div class="bg-white text-gray-900 rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
