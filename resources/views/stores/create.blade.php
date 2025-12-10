<x-app-layout>
    <div class="px-4 py-8 lg:px-10 bg-slate-50 min-h-screen">
        {{-- Header / breadcrumb --}}
        <div class="max-w-5xl mx-auto mb-8">
            <div class="flex items-center gap-2 text-xs font-medium">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                    Seller Area
                </span>
            </div>

            <div class="mt-3 flex items-center gap-3 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-slate-700">Dashboard</a>
                <span>/</span>
                <span class="text-slate-700 font-medium">Buat Toko</span>
            </div>

            <h1 class="mt-5 text-2xl font-semibold text-slate-900">
                Buat Toko
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Lengkapi data toko untuk mulai berjualan di KiloMeter.
            </p>
        </div>

        {{-- Card form --}}
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                {{-- Header card --}}
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-xs font-semibold text-slate-500 tracking-[0.12em]">
                        DATA TOKO
                    </h2>
                </div>

                {{-- Body form --}}
                <div class="px-6 py-6">
                    <form id="create-store-form"
                          action="{{ route('stores.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf

                        {{-- Nama Toko --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="block w-full rounded-xl border @error('name') border-red-400 @else border-slate-300 @enderror
                                          px-3.5 py-2.5 text-sm text-slate-900
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                          placeholder:text-slate-400 bg-white">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Logo --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Logo Toko
                            </label>
                            <input type="file" name="logo" accept="image/*"
                                   class="block w-full text-xs text-slate-600
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-xs file:font-semibold
                                          file:bg-slate-100 file:text-slate-700
                                          hover:file:bg-slate-200">
                            @error('logo')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tentang Toko --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tentang Toko
                            </label>
                            <textarea name="about" rows="3"
                                      class="block w-full rounded-xl border border-slate-300
                                             px-3.5 py-2.5 text-sm text-slate-900
                                             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                             placeholder:text-slate-400 bg-white">{{ old('about') }}</textarea>
                            @error('about')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                No. HP / WhatsApp
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="block w-full rounded-xl border border-slate-300
                                          px-3.5 py-2.5 text-sm text-slate-900
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                          placeholder:text-slate-400 bg-white">
                            @error('phone')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kota & Kode Pos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Kota
                                </label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                       class="block w-full rounded-xl border border-slate-300
                                              px-3.5 py-2.5 text-sm text-slate-900
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                              placeholder:text-slate-400 bg-white">
                                @error('city')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Kode Pos
                                </label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                       class="block w-full rounded-xl border border-slate-300
                                              px-3.5 py-2.5 text-sm text-slate-900
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                              placeholder:text-slate-400 bg-white">
                                @error('postal_code')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Alamat Lengkap
                            </label>
                            <textarea name="address" rows="2"
                                      class="block w-full rounded-xl border border-slate-300
                                             px-3.5 py-2.5 text-sm text-slate-900
                                             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                             placeholder:text-slate-400 bg-white">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>

                    {{-- Info tambahan (opsional) --}}
                    <div class="mt-6 rounded-xl bg-slate-50 border border-dashed border-slate-200 px-4 py-3 text-xs text-slate-500">
                        Pastikan data toko sudah benar. Kamu bisa mengubahnya kapan saja dari halaman pengaturan toko.
                    </div>
                </div>

                {{-- Footer card: tombol --}}
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-3 bg-slate-50">
                    <a href="{{ route('stores.index') }}"
                       class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-sm font-medium
                              border border-slate-300 text-slate-700 bg-white hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" form="create-store-form"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-semibold
                                   bg-slate-900 text-white hover:bg-slate-800">
                        Simpan Toko
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
