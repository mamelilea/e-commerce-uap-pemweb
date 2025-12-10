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
                DETAIL PRODUK
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">

                <!-- BAGIAN DETAIL PRODUK -->
                <div class="flex flex-wrap gap-10">
                    <div class="flex gap-10">
                        <div class="w-[350px] h-[350px]">
                            <img src="{{ asset($product->thumbnail->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover rounded-lg">
                        </div>

                        <div class="w-[700px]">
                            <p class="text-left text-3xl font-semibold text-pink-600">
                                {{ $product->name }}
                            </p>

                            <p class="text-left text-xl font-normal text-gray-500">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <br>

                            @php
                                $rating = $product->reviews_avg_rating ?? 0;
                                $full = floor($rating);
                                $half = ($rating - $full) >= 0.5;
                                $empty = 5 - $full - ($half ? 1 : 0);
                            @endphp

                            <div class="flex items-center gap-1">
                                @for ($i = 0; $i < $full; $i++)
                                    <span class="text-yellow-400 text-lg">★</span>
                                @endfor
                                @if ($half)
                                    <span class="text-yellow-400 text-lg">☆</span>
                                @endif
                                @for ($i = 0; $i < $empty; $i++)
                                    <span class="text-gray-300 text-lg">✩</span>
                                @endfor

                                <span class="text-sm text-gray-500 ml-1">
                                    ({{ $product->reviews_count }} ulasan)
                                </span>

                                <p class="text-base font-normal text-pink-600 ml-3">
                                    1,46 Juta Terjual
                                </p>
                            </div>

                            <br>

                            <div>
                                <p class="text-left text-lg font-normal text-gray-700">
                                    Deskripsi Produk :
                                </p>
                                <p class="text-justify text-base font-normal text-gray-500 mt-2">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <br>

                            <p class="text-left text-lg font-normal text-gray-700">Review Produk :</p>

                            <div class="flex flex-wrap gap-5">
                                @forelse ($product->reviews as $r)
                                    <div class="w-[350px] p-4 border-2 border-pink-600 rounded-lg">
                                        <div>
                                            <img src="{{ asset($r->transaction->buyer->profile_picture) }}" class="w-8 h-8 inline-block mr-2 rounded-full">
                                            <b class="text-pink-600">{{ $r->transaction->buyer->user->name }}</b>
                                            <span class="text-gray-500">• Rating: {{ $r->rating }}/5</span>
                                        </div>
                                        <p>{{ $r->review }}</p>
                                    </div>
                                @empty
                                    <p>Belum ada review.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <!-- TOMBOL KERANJANG & BELI SEKARANG -->
                <div class="w-full flex justify-end mt-10 gap-5">

                    <!-- Tambah Keranjang -->
                    <button class="bg-white hover:bg-pink-600 hover:text-white hover:border-pink-600 text-pink-200 border-2 border-pink-200 font-semibold py-2 px-4 w-[350px] h-[50px] rounded flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
                            <circle cx="176" cy="416" r="32" fill="currentColor"/>
                            <circle cx="400" cy="416" r="32" fill="currentColor"/>
                            <path fill="currentColor" d="M456.8 120.78a23.92 23.92 0 0 0-18.56-8.78H133.89l-6.13-34.78A16 16 0 0 0 112 64H48a16 16 0 0 0 0 32h50.58l45.66 258.78A16 16 0 0 0 160 368h256a16 16 0 0 0 0-32H173.42l-5.64-32h241.66A24.07 24.07 0 0 0 433 284.71l28.8-144a24 24 0 0 0-5-19.93"/>
                        </svg>
                        Masukkan Keranjang
                    </button>

                    <!-- Tombol Beli Sekarang (open modal) -->
                    <button
                        @click="open = true"
                        class="bg-pink-300 hover:bg-pink-600 text-white font-semibold py-2 px-4 w-[780px] h-[50px] rounded"
                    >
                        Beli Sekarang
                    </button>
                </div>

            </div>
        </div>

        <!-- MODAL PEMILIHAN JUMLAH -->
        <div
            x-show="open"
            x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white p-6 rounded-lg w-[400px] shadow-lg">
                <h2 class="text-xl font-semibold text-pink-600 mb-4">Jumlah Pembelian</h2>

                <form action="{{ route('pengguna.cekout', $product->id) }}" method="GET">
                    <label class="block text-gray-700 mb-1">Jumlah :</label>
                    <input
                        type="number"
                        name="qty"
                        value="1"
                        min="1"
                        class="w-full border rounded p-2"
                        required
                    >

                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="button"
                            @click="open = false"
                            class="px-4 py-2 rounded border border-gray-300"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 rounded bg-pink-500 text-white hover:bg-pink-600"
                        >
                            Lanjut Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</x-app-layout>
