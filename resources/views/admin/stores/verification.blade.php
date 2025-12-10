<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                {{ __('Verifikasi Pengajuan Toko') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Daftar toko yang menunggu persetujuan untuk bergabung di KiloMeter.
            </p>
        </div>
    </x-slot>

    <div class="space-y-4">

        @if (session('success'))
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            @if ($unverifiedStores->isEmpty())
                <div class="p-8 text-center text-sm text-slate-500">
                    Tidak ada pengajuan toko yang perlu diverifikasi saat ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Toko</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Telepon Toko</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach ($unverifiedStores as $store)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-6 py-4 align-top">
                                        <div class="font-semibold text-slate-900">{{ $store->name }}</div>
                                        @if (!empty($store->address) || !empty($store->city))
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $store->address ?? '' }} @if($store->city) , {{ $store->city }} @endif
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-slate-800">
                                            {{ $store->user->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ $store->user->email ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700 border border-slate-100">
                                            {{ $store->phone ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top text-right space-x-2">
                                        <form method="POST" action="{{ route('admin.stores.verify', $store) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm">
                                                Verifikasi
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.stores.reject', $store) }}" class="inline"
                                              onsubmit="return confirm('Yakin menolak dan menghapus toko ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-500 hover:bg-red-600 text-white shadow-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $unverifiedStores->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
