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
                Jenis Pengiriman
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">
                <form action="{{ route('pengguna.pengiriman.store', $product->id) }}" method="POST" >
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex flex-col gap-6">
                        <div>
                            <p class="block text-xl font-medium text-gray-700">
                                Opsi Pengiriman
                            </p>
                            <div class="flex flex-wrap gap-9 mt-8">
                                <div>
                                    <img src="{{ asset('image/jne.jpg') }}" alt="JNE"
                                        class="w-35 h-20 object-contain">
                                        <p class="text-center mt-2 text-gray-600">JNE</p>
                                </div>
                                <div>
                                    <img src="{{ asset('image/jt.jpg') }}" alt="J&T"
                                        class="w-35 h-20 object-contain">
                                        <p class="text-center mt-2 text-gray-600">J&T</p>
                                </div>
                                <div>
                                    <img src="{{ asset('image/anteraja.jpg') }}" alt="Anteraja"
                                        class="w-35 h-20 object-contain">
                                        <p class="text-center mt-2 text-gray-600">Anteraja</p>
                                </div>
                                <div>
                                    <img src="{{ asset('image/sicepat.png') }}" alt="SiCepat"
                                        class="w-35 h-20 object-contain">
                                        <p class="text-center mt-2 text-gray-600">SiCepat</p>
                                </div>
                            </div>
                            <label for="shipping_type" class="block text-xl font-medium text-gray-700 mt-10">
                                Jenis Pengiriman
                            </label>
                            <input type="text" name="shipping_type" id="shipping_type" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm
                                focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-pink-600 text-white rounded-md
                                hover:bg-pink-700 focus:outline-none focus:ring-2
                                focus:ring-offset-2 focus:ring-pink-500">
                                Simpan Jenis Pengiriman
                            </button>
                        </div>
                    </div>
                </form>
</x-app-layout>