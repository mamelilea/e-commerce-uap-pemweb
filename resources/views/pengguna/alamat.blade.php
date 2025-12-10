<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <button onclick="history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                    viewBox="0 0 48 48" class="text-pink-300">
                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="4"
                        d="M31 36L19 24l12-12"/>
                </svg>
            </button>
            <h2 class="font-semibold text-xl text-pink-300 leading-tight">
                Alamat Pengiriman
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">
                <form action="{{ route('pengguna.alamat.store', $product->id) }}" method="POST" >
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex flex-col gap-6">
                        <div>
                            <label for="address" class="block text-xl font-medium text-gray-700">
                                Alamat Lengkap
                            </label>
                            <textarea name="address" id="address" rows="4" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm"></textarea>
                            <label for="address_id" class="block text-xl font-medium text-gray-700 mt-5">
                                Nomor Alamat
                            </label>
                            <input type="text" name="address_id" id="address_id" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            <label for="city" class="block text-xl font-medium text-gray-700 mt-5">
                                Kota
                            </label>
                            <input type="text" name="city" id="city" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            <label for="postal_code" class="block text-xl font-medium text-gray-700 mt-5">
                                Kode Pos
                            </label>
                            <input type="text" name="postal_code" id="postal_code" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                Nama Pemesan
                            </label>
                            <input type="text" name="buyer_name" id="buyer_name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                Nomor Telepon
                            </label>
                            <input type="text" name="phone_number" id="phone_number" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-pink-600 text-white rounded-md
                                hover:bg-pink-700 focus:outline-none focus:ring-2
                                focus:ring-offset-2 focus:ring-pink-500">
                                Simpan address
                            </button>
                        </div>
                    </div>
                </form>
</x-app-layout>