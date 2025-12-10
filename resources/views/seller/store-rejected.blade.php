<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Ditolak - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hidden sm:block">
                            Electromart
                        </span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800 font-semibold">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="max-w-2xl w-full">
                <!-- Status Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Header with Icon -->
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 p-8 text-center">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Pengajuan Ditolak</h2>
                        <p class="text-red-100">Mohon maaf, pengajuan toko Anda tidak dapat disetujui</p>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <!-- Store Info -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Toko</h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center gap-4 mb-4">
                                    @if(Auth::user()->store->logo)
                                    <img src="{{ asset('storage/' . Auth::user()->store->logo) }}"
                                        alt="{{ Auth::user()->store->name }}"
                                        class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg">{{ Auth::user()->store->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->store->city }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold text-xs">
                                            Ditolak
                                        </span>
                                    </div>
                                    @if(Auth::user()->store->verified_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Ditinjau:</span>
                                        <span class="font-semibold text-gray-800">{{ Auth::user()->store->verified_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Rejection Reason -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Alasan Penolakan</h3>
                            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-lg">
                                <div class="flex gap-3">
                                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-red-900 leading-relaxed">{{ Auth::user()->store->rejection_reason }}</p>
                                        @if(Auth::user()->store->verifier)
                                        <p class="text-sm text-red-700 mt-3">
                                            Ditinjau oleh: <span class="font-semibold">{{ Auth::user()->store->verifier->name }}</span>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- What to do next -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-2">Langkah Selanjutnya</h4>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        <li>• Perbaiki informasi toko sesuai alasan penolakan di atas</li>
                                        <li>• Pastikan semua data sudah lengkap dan benar</li>
                                        <li>• Daftar ulang dengan data yang sudah diperbaiki</li>
                                        <li>• Hubungi admin jika ada pertanyaan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="mailto:admin@example.com"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold text-center transition">
                                Hubungi Admin
                            </a>
                            <a href="{{ route('seller.register') }}"
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-center transition">
                                Daftar Ulang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Note -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Akun Anda masih aktif. Anda dapat mendaftar ulang dengan data yang sudah diperbaiki.
                    </p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <p class="text-center text-sm text-gray-600">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>

</html>