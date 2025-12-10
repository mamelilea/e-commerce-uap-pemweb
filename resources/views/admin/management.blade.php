<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('MANAGEMENT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white h-auto overflow-hidden shadow-sm sm:rounded-lg py-10 px-10">
                <div class="flex flex-wrap gap-10">
                    @if($stores)
                        @foreach ($stores as $store)
                            <h2 class="text-xl font-semibold mt-4">{{ $store->name }}</h2>
                            <div class="flex flex-wrap gap-10">
                                @foreach ($store->products as $product)
                                    <div class="bg-pink-100 h-[330px] w-[250px] sm:rounded-lg">
                                        <img src="{{ asset($product->thumbnail->image) }}" alt="{{ $product->name }}" class="w-[250px] object-cover sm:rounded-t-lg">
                                        <p class="text-left text-xl mt-2 ml-2 font-semibold text-gray-700">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-left text-lg mt-1 ml-2 font-normal text-gray-500">
                                            Rp. {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p>Tidak ada toko atau produk.</p>
                    @endif

                </div>
            </div>
        </div>
</x-admin-layout>