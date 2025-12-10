<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('Registrasi Toko') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

        {{-- Judul --}}
        <h3 class="text-center text-2xl font-bold text-pink-400 mb-6">
            Formulir Pendaftaran Toko
        </h3>

        {{-- Kotak putih --}}
        <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl px-10 py-10 
                    border border-pink-100 max-w-2xl mx-auto">

            <form action="{{ route('toko.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Toko</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Masukkan nama toko kamu" required>
                </div>

                <div class="mb-4">
                    <label for="logo" class="block text-gray-700 font-semibold mb-2">Logo Toko</label>
                    <input type="file" name="logo" id="logo"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        accept=".jpg,.jpeg,.png" required>
                    <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG, maks 2MB</p>
                </div>

                <div class="mb-4">
                    <label for="about" class="block text-gray-700 font-semibold mb-2">Deskripsi Toko</label>
                    <textarea name="about" id="about" rows="3"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Tuliskan deskripsi singkat toko kamu" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="0812xxxxxxx" required>
                </div>

                <div class="mb-4">
                    <label for="address_id" class="block text-gray-700 font-semibold mb-2">ID Alamat</label>
                    <input type="number" name="address_id" id="address_id"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Masukkan ID alamat" required>
                    <p class="text-sm text-gray-500 mt-1">Sementara isi dengan angka (contoh: 1)</p>
                </div>

                <div class="mb-4">
                    <label for="city" class="block text-gray-700 font-semibold mb-2">Kota</label>
                    <input type="text" name="city" id="city"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Contoh: Bandung" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="2"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Masukkan alamat lengkap toko" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="postal_code" class="block text-gray-700 font-semibold mb-2">Kode Pos</label>
                    <input type="text" name="postal_code" id="postal_code"
                        class="w-full border border-gray-300 rounded-lg p-3 
                        focus:ring-pink-300 focus:border-pink-300"
                        placeholder="Misal: 40287" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-12 py-3 bg-pink-300 hover:bg-pink-400 text-white 
                               font-semibold rounded-xl shadow-md transition transform hover:scale-105">
                        Daftarkan Toko
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
</x-app-layout>
