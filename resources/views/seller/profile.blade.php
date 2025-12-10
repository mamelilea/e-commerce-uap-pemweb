<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a
                href="{{ route('seller.categories.index') }}"
                class="inline-flex items-center px-3 py-1.5 rounded-full border border-gray-200 bg-white text-xs font-medium text-gray-600 shadow-sm hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
            >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil Toko
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FLASH MESSAGE --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded">
                    <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- FORM DATA TOKO --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">
                                Data Toko
                            </h3>
                        </div>

                        <div class="px-6 py-5">
                            <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Toko <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name"
                                           class="block w-full rounded-md border-gray-300 shadow-sm
                                                  focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                  @error('name') border-red-500 @enderror"
                                           value="{{ old('name', $store->name) }}">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Logo Toko
                                    </label>
                                    <input type="file" name="logo"
                                           class="block w-full text-sm text-gray-900
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100
                                                  @error('logo') border-red-500 @enderror">
                                    @error('logo')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if($store->logo)
                                        <div class="mt-3">
                                            <p class="text-xs text-gray-500 mb-1">Logo saat ini:</p>
                                            <img src="{{ asset('storage/'.$store->logo) }}"
                                                 alt="Logo Toko"
                                                 class="h-16 w-auto rounded border border-gray-200 object-contain bg-gray-50">
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Deskripsi Toko
                                    </label>
                                    <textarea name="about" rows="3"
                                              class="block w-full rounded-md border-gray-300 shadow-sm
                                                     focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                     @error('about') border-red-500 @enderror">{{ old('about', $store->about) }}</textarea>
                                    @error('about')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            No. Telepon
                                        </label>
                                        <input type="text" name="phone"
                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                      focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                      @error('phone') border-red-500 @enderror"
                                               value="{{ old('phone', $store->phone) }}">
                                        @error('phone')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kota
                                        </label>
                                        <input type="text" name="city"
                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                      focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                      @error('city') border-red-500 @enderror"
                                               value="{{ old('city', $store->city) }}">
                                        @error('city')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kode Pos
                                        </label>
                                        <input type="text" name="postal_code"
                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                      focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                      @error('postal_code') border-red-500 @enderror"
                                               value="{{ old('postal_code', $store->postal_code) }}">
                                        @error('postal_code')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Alamat Lengkap
                                    </label>
                                    <textarea name="address" rows="2"
                                              class="block w-full rounded-md border-gray-300 shadow-sm
                                                     focus:ring-indigo-500 focus:border-indigo-500 text-sm
                                                     @error('address') border-red-500 @enderror">{{ old('address', $store->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent
                                                   text-sm font-medium rounded-md text-white
                                                   bg-indigo-600 hover:bg-indigo-700
                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Simpan Profil Toko
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- FORM TAMBAH REKENING & LIST --}}
                <div class="space-y-6">

                    {{-- FORM TAMBAH --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-3 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">
                                Tambah Rekening Bank
                            </h3>
                        </div>

                        <div class="px-6 py-5">
                            <form action="{{ route('seller.bank.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Pemilik Rekening
                                    </label>
                                    <input type="text" name="bank_account_name"
                                           class="block w-full rounded-md border-gray-300 shadow-sm
                                                  focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                           value="{{ old('bank_account_name') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor Rekening
                                    </label>
                                    <input type="text" name="bank_account_number"
                                           class="block w-full rounded-md border-gray-300 shadow-sm
                                                  focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                           value="{{ old('bank_account_number') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Bank
                                    </label>
                                    <input type="text" name="bank_name"
                                           class="block w-full rounded-md border-gray-300 shadow-sm
                                                  focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                           value="{{ old('bank_name') }}">
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-2 border border-transparent
                                                   text-xs font-medium rounded-md text-white
                                                   bg-emerald-600 hover:bg-emerald-700
                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                        Tambah Rekening
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- LIST REKENING --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="px-6 py-3 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800 text-sm">
                                Daftar Rekening Bank
                            </h3>
                        </div>

                        <div class="px-4 py-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 bg-gray-50 text-gray-600 text-xs uppercase tracking-wide">
                                            <th class="px-3 py-2 text-left">Pemilik</th>
                                            <th class="px-3 py-2 text-left">No. Rekening</th>
                                            <th class="px-3 py-2 text-left">Bank</th>
                                            <th class="px-3 py-2 text-left">Status</th>
                                            <th class="px-3 py-2 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse(($balance?->withdrawals) ?? [] as $wd)
                                            <tr class="align-top">
                                                <form action="{{ route('seller.bank.update', $wd) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <td class="px-3 py-2">
                                                        <input type="text" name="bank_account_name"
                                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                                      focus:ring-indigo-500 focus:border-indigo-500 text-xs"
                                                               value="{{ old('bank_account_name_'.$wd->id, $wd->bank_account_name) }}">
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <input type="text" name="bank_account_number"
                                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                                      focus:ring-indigo-500 focus:border-indigo-500 text-xs"
                                                               value="{{ old('bank_account_number_'.$wd->id, $wd->bank_account_number) }}">
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <input type="text" name="bank_name"
                                                               class="block w-full rounded-md border-gray-300 shadow-sm
                                                                      focus:ring-indigo-500 focus:border-indigo-500 text-xs"
                                                               value="{{ old('bank_name_'.$wd->id, $wd->bank_name) }}">
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <span class="inline-flex px-2 py-1 rounded-full text-xs
                                                                     bg-gray-100 text-gray-700 capitalize">
                                                            {{ $wd->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <div class="flex items-center justify-center space-x-2">
                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1 border border-transparent
                                                                           text-xs font-medium rounded-md text-white
                                                                           bg-indigo-600 hover:bg-indigo-700
                                                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                Update
                                                            </button>
                                                </form>
                                                            <form action="{{ route('seller.bank.destroy', $wd) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirm('Yakin hapus rekening ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="inline-flex items-center px-3 py-1 border border-transparent
                                                                               text-xs font-medium rounded-md text-white
                                                                               bg-rose-600 hover:bg-rose-700
                                                                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-3 py-4 text-center text-xs text-gray-500">
                                                    Belum ada rekening bank terdaftar.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> {{-- /right side --}}
            </div> {{-- /grid --}}
        </div>
    </div>
</x-app-layout>
