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
                Metode Pembayaran
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">
                <form action="{{ route('pengguna.metodepembayaran.store', $product->id) }}" method="POST" >
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">     
                    <div class="flex flex-col gap-6">
                        <div>
                            <p class="font-semibold text-xl text-gray-600">Opsi Pembayaran</p>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - BNI" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/bni.png') }}" alt="bni" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - BNI </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - BRI" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/bri.png') }}" alt="bri" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - BRI </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - Mandiri" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/mandiri.png') }}" alt="mandiri" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - Mandiri </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - Bank Jatim" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/bankjatim.png') }}" alt="bankjatim" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - Bank Jatim </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - BSI" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/bsi.png') }}" alt="bsi" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - BSI </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="Bank Transfer - BCA" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <img src="{{ asset('image/bca.png') }}" alt="bca" class="w-20 object-contain mt-4">
                                <p class="mt-5 text-gray-700 font-normal"> Bank Transfer - BCA </p>
                            </label>
                            <label for="payment" class="block text-xl flex gap-10 font-medium text-gray-700 mt-5">
                                <input type="radio" name="payment" id="payment" value ="COD" required
                                    class="mt-5 border border-gray-300 rounded-md shadow-sm
                                    focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                <p class="mt-5 text-gray-700 font-normal"> COD </p>
                            </label>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-pink-600 text-white rounded-md
                                hover:bg-pink-700 focus:outline-none focus:ring-2
                                focus:ring-offset-2 focus:ring-pink-500">
                                Simpan Metode Pembayaran
                            </button>
                        </div>
                        
                    </div>
                </form>
</x-app-layout>