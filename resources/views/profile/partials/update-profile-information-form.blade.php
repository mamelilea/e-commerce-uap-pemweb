<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 flex flex-col md:flex-row gap-8" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <div class="w-full md:w-1/3 flex flex-col items-center">
            <div class="w-48 h-48 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 mb-4 flex items-center justify-center">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-6xl font-bold text-gray-300">{{ substr($user->name, 0, 1) }}</div>
                @endif
            </div>
            
            <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])" />
            
            <button type="button" onclick="document.getElementById('avatar').click()" class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-50 transition">
                Pilih Foto
            </button>
            <p class="text-xs text-gray-500 mt-2 text-center">
                Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>


        <div class="w-full md:w-2/3 space-y-6">
            

            <div>
                <h3 class="font-bold text-gray-900 mb-4">Ubah Biodata Diri</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
                        <label class="block text-sm font-medium text-gray-500 md:col-span-1">Nama</label>
                        <div class="md:col-span-2">
                             <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                             <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="pt-6 border-t">
                <h3 class="font-bold text-gray-900 mb-4">Ubah Kontak</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
                        <label class="block text-sm font-medium text-gray-500 md:col-span-1">Email</label>
                        <div class="md:col-span-2 flex items-center gap-2">
                             <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                             @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <p class="text-sm text-red-600">Unverified</p>
                             @else
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Terverifikasi</span>
                             @endif
                        </div>
                        <div class="md:col-span-3">
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="pt-6 flex justify-end">
                <x-primary-button class="w-full md:w-auto px-8">{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 ml-4 self-center">{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>
