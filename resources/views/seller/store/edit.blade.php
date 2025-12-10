@extends('layouts.seller')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Back Button -->
    <a href="{{ route('seller.store.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Profil Toko
    </a>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Profil Toko</h1>
        <p class="text-gray-600 mt-2">Perbarui informasi toko Anda</p>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm p-8 space-y-6">

            <!-- Current Logo -->
            @if($store->logo)
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Toko Saat Ini</label>
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . $store->logo) }}"
                        alt="{{ $store->name }}"
                        class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Upload logo baru untuk menggantinya</p>
                        <p class="text-xs text-gray-500">Format: JPG, PNG, GIF</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Upload New Logo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ $store->logo ? 'Upload Logo Baru' : 'Upload Logo Toko' }}
                </label>
                <div class="flex items-center gap-4">
                    <label for="logo" class="cursor-pointer">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition">
                            <div id="logo-preview" class="hidden mb-2">
                                <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg mx-auto">
                            </div>
                            <div id="logo-placeholder">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-600">Klik untuk upload logo</p>
                                <p class="text-xs text-gray-500 mt-1">Max: 2MB</p>
                            </div>
                        </div>
                        <input type="file" id="logo" name="logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                    </label>
                </div>
                @error('logo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <!-- Store Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Toko <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $store->name) }}"
                    placeholder="Contoh: Toko Elektronik Jaya"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- About -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tentang Toko <span class="text-red-500">*</span>
                </label>
                <textarea name="about" rows="5"
                    placeholder="Ceritakan tentang toko Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>{{ old('about', $store->about) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Maksimal 1000 karakter</p>
                @error('about')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Kontak</h3>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone) }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr>

            <!-- Address -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Alamat Toko</h3>

                <!-- City -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kota <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="city" value="{{ old('city', $store->city) }}"
                        placeholder="Contoh: Jakarta"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('city')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" rows="4"
                        placeholder="Jl. Contoh No. 123, RT/RW 01/02, Kelurahan..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>{{ old('address', $store->address) }}</textarea>
                    @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postal Code -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Pos <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}"
                        placeholder="12345"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('postal_code')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Perhatian:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan informasi toko akurat dan terkini</li>
                            <li>Alamat akan digunakan untuk keperluan pengiriman</li>
                            <li>Logo toko akan tampil di halaman produk Anda</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                    Simpan Perubahan
                </button>
                <a href="{{ route('seller.store.index') }}"
                    class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function previewLogo(input) {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('logo-placeholder');
        const img = preview.querySelector('img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection