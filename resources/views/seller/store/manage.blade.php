<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#EDEDEC] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Manajemen Toko: ') . $store->name }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="font-medium">{{ session('success') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- LEFT COLUMN: Logo & Status -->
                    <div class="md:col-span-1 space-y-6">
                        <!-- Status Card -->
                        <div class="bg-[#161616] p-6 rounded-2xl shadow-sm border border-white/10">
                             <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Status & Verifikasi</h3>
                            <div class="flex items-center justify-between p-4 bg-[#0a0a0a] rounded-xl border border-white/10">
                                <span class="text-gray-400 font-medium text-sm">Status Toko</span>
                                @if ($store->is_verified)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 items-center justify-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200 items-center justify-center text-center">
                                        Belum Diverifikasi
                                    </span>
                                @endif
                            </div>
                            @if (!$store->is_verified)
                                <p class="text-xs text-gray-500 mt-3 text-center">
                                    Toko Anda sedang menunggu persetujuan admin untuk dapat mulai berjualan secara penuh.
                                </p>
                            @endif
                        </div>

                         <!-- Logo Upload Card -->
                         <div class="bg-[#161616] p-6 rounded-2xl shadow-sm border border-white/10">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Logo Brand</h3>
                             <div class="flex flex-col items-center justify-center">
                                <div class="relative w-32 h-32 mb-4 group">
                                     <!-- Preview Image (Always present in DOM, manipulated by JS) -->
                                     <img id="logo-preview" 
                                          src="{{ $store->logo ? ($store->logo == 'wtc-logo.png' ? asset('images/wtc-logo.png') : asset('storage/' . $store->logo)) : '' }}" 
                                          alt="Logo Toko" 
                                          style="{{ $store->logo ? '' : 'display: none;' }}"
                                          class="w-full h-full object-cover rounded-full border-4 border-white shadow-md absolute inset-0 z-10">

                                    <!-- Initials Fallback (Visible only if no logo) -->
                                    <div id="initials-fallback"
                                         style="{{ $store->logo ? 'display: none;' : '' }}"
                                         class="w-full h-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 text-3xl font-bold border-4 border-white shadow-md absolute inset-0">
                                        {{ substr($store->name, 0, 1) }}
                                    </div>

                                    <!-- Hover Overlay with Camera Icon -->
                                    <div class="absolute inset-0 z-20 bg-black/40 rounded-full hidden group-hover:flex items-center justify-center transition-all bg-blend-overlay">
                                        <svg class="w-8 h-8 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>

                                    <!-- Invisible Input Overlay (Guarantees Clickability) -->
                                    <input id="logo" type="file" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50 rounded-full" onchange="previewManageImage(event)">
                                </div>
                                <span class="text-xs text-gray-500">Klik foto untuk ubah logo</span>
                                <x-input-error :messages="$errors->get('logo')" class="mt-2 text-center" />
                             </div>

                             <script>
                                function previewManageImage(event) {
                                    const input = event.target;
                                    const preview = document.getElementById('logo-preview');
                                    const fallback = document.getElementById('initials-fallback');
                                    
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                            if(fallback) fallback.style.display = 'none';
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                             </script>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Form Inputs -->
                    <div class="md:col-span-2 space-y-6">
                        <div class="bg-[#161616] p-8 rounded-2xl shadow-sm border border-white/10">
                             <h3 class="text-lg font-bold text-[#EDEDEC] mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Identitas Brand
                            </h3>

                            <!-- Nama Toko -->
                             <div class="mb-5">
                                <x-input-label for="name" :value="__('Nama Toko')" class="text-gray-300" />
                                <x-text-input id="name" class="block mt-1 w-full bg-[#0a0a0a] border-white/10 text-white focus:bg-[#111] focus:border-indigo-500 transition-colors" type="text" name="name" :value="old('name', $store->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-5">
                                <x-input-label for="about" :value="__('Deskripsi Singkat')" class="text-gray-300" />
                                <textarea id="about" class="block mt-1 w-full rounded-xl border-white/10 bg-[#0a0a0a] text-white focus:border-indigo-500 focus:ring-indigo-500 focus:bg-[#111] shadow-sm transition-colors" name="about" rows="4">{{ old('about', $store->about) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1 text-right">Jelaskan keunikan toko Anda kepada pembeli.</p>
                                <x-input-error :messages="$errors->get('about')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-[#161616] p-8 rounded-2xl shadow-sm border border-white/10">
                            <h3 class="text-lg font-bold text-[#EDEDEC] mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Lokasi Operasional & Kontak
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <x-input-label for="phone" :value="__('Kontak Bisnis')" class="text-gray-300" />
                                    <x-text-input id="phone" class="block mt-1 w-full bg-[#0a0a0a] border-white/10 text-white focus:bg-[#111]" type="text" name="phone" :value="old('phone', $store->phone)" required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                                 <div>
                                    <x-input-label for="postal_code" :value="__('Kode Pos')" class="text-gray-300" />
                                    <x-text-input id="postal_code" class="block mt-1 w-full bg-[#0a0a0a] border-white/10 text-white focus:bg-[#111]" type="text" name="postal_code" :value="old('postal_code', $store->postal_code)" required />
                                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                                </div>
                            </div>

                             <div class="mb-5">
                                <x-input-label for="city" :value="__('Kota / Kabupaten')" class="text-gray-300" />
                                <x-text-input id="city" class="block mt-1 w-full bg-[#0a0a0a] border-white/10 text-white focus:bg-[#111]" type="text" name="city" :value="old('city', $store->city)" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                             <div class="mb-5">
                                <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-gray-300" />
                                <textarea id="address" class="block mt-1 w-full rounded-xl border-white/10 bg-[#0a0a0a] text-white focus:bg-[#111] focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors" name="address" rows="3" required>{{ old('address', $store->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Action Button -->
                         <div class="flex items-center justify-end">
                            <x-primary-button class="px-6 py-3 text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Danger Zone -->
            <div class="mt-12">
                <div class="bg-red-900/10 p-6 rounded-2xl border border-red-500/20 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                         <h3 class="text-lg font-bold text-red-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Zona Berbahaya
                        </h3>
                        <p class="mt-1 text-sm text-red-600 max-w-xl">
                            Menghapus toko akan menghilangkan permanen semua data produk, riwayat pesanan, dan profil toko Anda. Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                   <form method="POST" action="{{ route('seller.store.destroy') }}"
                        onsubmit="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS TOKO INI? Aksi ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit" class="bg-red-600 hover:bg-red-700 border-0 shadow-none">
                            {{ __('Hapus Toko Permanen') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-seller-layout>
