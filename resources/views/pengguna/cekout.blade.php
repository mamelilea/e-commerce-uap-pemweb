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
                CHECKOUT
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">
                <div class="flex flex-wrap gap-10">
                    <div class="flex gap-10">
                        <div class="w-[200px] h-[200px]">
                            <img src="{{ asset($product->thumbnail->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="w-[890px] h-[200px] flex flex-col">
                            <div>
                                <p class="text-left text-3xl font-semibold text-gray-600">
                                    {{ $product->name }}
                                </p>
                                <p class="text-left text-l font-normal text-gray-600">
                                    {{ $product->description }}
                                </p>
                            </div>
                            <div x-data="{ qty: {{ $qty }}, price: {{ $product->price }} }"
                                class="flex justify-between items-center w-full mt-auto">

                                <!-- Harga -->
                                <p class="text-left text-xl font-semibold text-gray-600">
                                    Rp <span x-text="(price).toLocaleString('id-ID')"></span>
                                </p>

                                <!-- Qty -->
                                <p class="text-gray-600 text-xl">
                                    x<span x-text="qty"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-pink-300 my-4"></div>
                <div x-data="{ qty: {{ $qty }}, price: {{ $product->price }} }"
                    class="flex justify-between items-center w-full mt-auto">
                    <p class="text-left text-xl font-semibold text-gray-600">
                        Total Pembelian
                    </p>
                    <p class="text-left text-2xl font-semibold text-pink-600">
                        Rp <span x-text="(qty*price).toLocaleString('id-ID')"></span>
                    </p>
                </div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10 mt-5">
                <div class="flex justify-between items-center w-full mt-auto">
                    <p class="text-left text-xl font-semibold text-gray-600">
                        Alamat Pengiriman
                    </p>
                    <a href="{{ route('pengguna.alamat', ['product' => $product->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
                                <path fill="currentColor" d="M15.707 11.293a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 1 1-1.414-1.414l4.95-4.95l-4.95-4.95a1 1 0 0 1 1.414-1.414z"/></g>
                        </svg>
                    </a>
                </div>
                <p class="text-gray-500">{{ $address }} {{ $city }} {{ $postal_code }}</p>
                <div class="border-b border-pink-300 my-4"></div>
                <div class="flex justify-between items-center w-full mt-auto">
                    <p class="text-left text-xl font-semibold text-gray-600">
                        Jenis Pengiriman
                    </p>
                    <a href="{{ route('pengguna.pengiriman', ['product' => $product->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
                                <path fill="currentColor" d="M15.707 11.293a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 1 1-1.414-1.414l4.95-4.95l-4.95-4.95a1 1 0 0 1 1.414-1.414z"/></g>
                        </svg>
                    </a>
                </div>
                <p class="text-gray-500">{{ $shipping_type }}</p>
                <div class="border-b border-pink-300 my-4"></div>
                <div class="flex justify-between items-center w-full mt-auto">
                    <p class="text-left text-xl font-semibold text-gray-600">
                        Metode Pembayaran
                    </p>
                    <a  href="{{ route('pengguna.metodepembayaran', ['product' => $product->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
                                <path fill="currentColor" d="M15.707 11.293a1 1 0 0 1 0 1.414l-5.657 5.657a1 1 0 1 1-1.414-1.414l4.95-4.95l-4.95-4.95a1 1 0 0 1 1.414-1.414z"/></g>
                        </svg>
                    </a>
                </div>
                <p class="text-gray-500">{{ $payment }}</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10 mt-5">
                <div class="justify-between items-center w-full mt-auto">
                    <p class="text-left text-xl font-semibold text-gray-600">
                        Rincian Harga
                    </p>
                    <div class="justify-between items-center w-full mt-auto">
                        <div class="flex justify-between w-full mt-2">
                            <p class="text-left text-lg font-normal text-gray-600">
                                Harga Produk
                            </p>
                            <div x-data="{ qty: {{ $qty }}, price: {{ $product->price }} }">
                                <p class="text-left text-lg font-normal text-gray-600">
                                    Rp <span x-text="(qty*price).toLocaleString('id-ID')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between w-full mt-2">
                            <p class="text-left text-lg font-normal text-gray-600">
                                Biaya Pengiriman
                            </p>
                            <p class="text-left text-lg font-normal text-gray-600">
                                Rp {{ number_format($shippingCost, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex justify-between w-full mt-2">
                            <p class="text-left text-lg font-normal text-gray-600">
                                Pajak
                            </p>
                            <div x-data="{ qty: {{ $qty }}, price: {{ $product->price }} }">
                                <p class="text-left text-lg font-normal text-gray-600">
                                    Rp <span x-text="(qty*price*0.01).toLocaleString('id-ID')"></span>
                                </p>
                            </div>
                        </div>
                        <div class="border-b border-pink-300 my-4"></div>
                        <div class="flex justify-between w-full mt-2">
                            <p class="text-left text-lg font-normal text-gray-600">
                                Total Harga
                            </p>
                            <div x-data="{ qty: {{ $qty }}, price: {{ $product->price }} }">
                                <p class="text-left text-3xl font-semibold text-pink-600">
                                    Rp <span x-text="(qty*price + {{ $shippingCost }} + qty*price*0.01).toLocaleString('id-ID')"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('pengguna.cekout.store', ['product' => $product->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="qty" value="{{ $qty }}">
                <input type="hidden" name="address" value="{{ $address }}">
                <input type="hidden" name="address_id" value="{{ $address_id }}">
                <input type="hidden" name="city" value="{{ $city }}">
                <input type="hidden" name="postal_code" value="{{ $postal_code }}">
                <input type="hidden" name="shipping_type" value="{{ $shipping_type }}">
                <input type="hidden" name="shipping_cost" value="{{ $shippingCost }}">
                <input type="hidden" name="tax" value="{{ $product->price * $qty * 0.01 }}">
                <input type="hidden" name="grand_total" value="{{ ($product->price * $qty) + 5000 + ($product->price * $qty * 0.01) }}">

                <button type="submit"
                    class="bg-pink-300 hover:bg-pink-600 text-white font-semibold py-2 px-4 w-full h-[50px] rounded mt-5">
                    Checkout Sekarang
                </button>

            </form>
            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>