<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
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
                    <div class="bg-gradient-to-r from-orange-500 to-yellow-500 p-8 text-center">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                            <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Menunggu Verifikasi</h2>
                        <p class="text-orange-100">Toko Anda sedang dalam proses verifikasi oleh admin</p>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <!-- Store Info -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Toko Anda</h3>
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
                                        <span class="text-gray-600">Tanggal Pendaftaran:</span>
                                        <span class="font-semibold text-gray-800">{{ Auth::user()->store->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full font-semibold text-xs">
                                            Menunggu Verifikasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Proses Verifikasi</h3>
                            <div class="space-y-4">
                                <!-- Step 1 - Done -->
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="w-1 h-full bg-gray-300 mt-2"></div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-semibold text-gray-800">Pendaftaran Selesai</h4>
                                        <p class="text-sm text-gray-600">Anda telah berhasil mendaftar sebagai penjual</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->store->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <!-- Step 2 - Current -->
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center animate-pulse">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="w-1 h-full bg-gray-300 mt-2"></div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <h4 class="font-semibold text-orange-600">Verifikasi Admin</h4>
                                        <p class="text-sm text-gray-600">Tim admin sedang meninjau data toko Anda</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi: 1-3 hari kerja</p>
                                    </div>
                                </div>

                                <!-- Step 3 - Pending -->
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-500">Toko Aktif</h4>
                                        <p class="text-sm text-gray-600">Anda dapat mulai berjualan dan mengelola toko</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-2">Apa yang perlu Anda lakukan?</h4>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        <li>• Tunggu email konfirmasi dari admin</li>
                                        <li>• Pastikan data yang Anda berikan sudah benar</li>
                                        <li>• Anda akan mendapat notifikasi jika toko disetujui atau ditolak</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Admin -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Ada pertanyaan?
                                <a href="mailto:admin@example.com" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    Hubungi Admin
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Refresh Info -->
                <div class="mt-6 text-center">
                    <button onclick="location.reload()" class="text-gray-600 hover:text-gray-800 text-sm font-semibold flex items-center gap-2 mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh Halaman
                    </button>
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