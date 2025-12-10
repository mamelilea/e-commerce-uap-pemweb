<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                Edit Pengguna
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui data akun, role, dan lihat informasi toko terkait.
            </p>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-4">

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

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide mb-3">
                        Data Akun
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input 
                                id="name" 
                                class="block mt-1 w-full" 
                                type="text" 
                                name="name" 
                                :value="old('name', $user->name)" 
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input 
                                id="email" 
                                class="block mt-1 w-full" 
                                type="email" 
                                name="email" 
                                :value="old('email', $user->email)" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select 
                                id="role" 
                                name="role" 
                                class="border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full text-sm" 
                                required
                            >
                                <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>
                    </div>
                </div>

                @if ($user->store)
                    <div class="pt-5 border-t border-dashed border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide mb-3">
                            Informasi Toko Terkait
                        </h3>

                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2 text-sm">
                            <p class="font-semibold text-slate-900">
                                Nama Toko: {{ $user->store->name }}
                            </p>
                            
                            <p>
                                Status Verifikasi: 
                                @if ($user->store->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        Unverified
                                    </span>
                                @endif
                            </p>
                            
                            <p class="text-slate-600">
                                Alamat: {{ $user->store->address }}, {{ $user->store->city }}
                            </p>

                            @if (!$user->store->is_verified)
                                <div class="mt-3">
                                    <form method="POST" action="{{ route('admin.stores.verify', $user->store) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm">
                                            Verifikasi Sekarang
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="pt-5 border-t border-dashed border-slate-200">
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600">
                            Pengguna ini belum memiliki toko.
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('admin.users-stores.index') }}" 
                       class="inline-flex items-center px-4 py-2 rounded-full border border-slate-200 text-xs font-semibold uppercase tracking-widest text-slate-700 hover:bg-slate-50">
                        {{ __('Batal') }}
                    </a>
                    
                    <x-primary-button class="rounded-full">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
