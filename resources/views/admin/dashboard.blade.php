<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Halo, <span class="font-semibold text-slate-800">{{ Auth::user()->name }}</span> 👋  
                Kelola pengguna dan toko di KiloMeter dari satu tempat.
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Quick Actions -->
        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('admin.stores.verification') }}"
               class="group relative overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500 mb-1">
                        Pengajuan Toko
                    </p>
                    <h3 class="text-lg font-semibold text-slate-900">
                        Verifikasi Pengajuan Toko
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Review dan setujui toko baru yang ingin bergabung di KiloMeter.
                    </p>
                    <span class="mt-3 inline-flex items-center text-sm font-semibold text-emerald-600 group-hover:text-emerald-700">
                        Lihat daftar
                        <svg class="h-4 w-4 ms-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </div>
                <div class="hidden sm:flex items-center justify-center">
                    <div class="h-12 w-12 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.users-stores.index') }}"
               class="group relative overflow-hidden rounded-2xl bg-white shadow-sm border border-slate-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-500 mb-1">
                        Pengguna & Toko
                    </p>
                    <h3 class="text-lg font-semibold text-slate-900">
                        Manajemen Pengguna & Toko
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Edit data pengguna, role, dan pantau status toko mereka.
                    </p>
                    <span class="mt-3 inline-flex items-center text-sm font-semibold text-indigo-600 group-hover:text-indigo-700">
                        Kelola sekarang
                        <svg class="h-4 w-4 ms-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </div>
                <div class="hidden sm:flex items-center justify-center">
                    <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5V4H2v16h5m10 0v-6a3 3 0 00-3-3H10a3 3 0 00-3 3v6m10 0H7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info Box -->
        <div class="rounded-2xl bg-white border border-dashed border-slate-200 p-5 text-sm text-slate-600">
            <p class="font-semibold text-slate-800 mb-1">Tips Admin</p>
            <ul class="list-disc list-inside space-y-1">
                <li>Selalu review data toko sebelum melakukan verifikasi.</li>
                <li>Gunakan role <span class="font-semibold">admin</span> hanya untuk akun yang terpercaya.</li>
                <li>Penghapusan user akan menghapus toko yang terkait (jika ada).</li>
            </ul>
        </div>
    </div>
</x-app-layout>
