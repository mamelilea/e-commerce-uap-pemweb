<x-public-layout>

    <div class="bg-black text-white w-full border-b-4 border-black mb-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-center overflow-x-auto">
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 font-bold uppercase text-sm whitespace-nowrap border-b-4 transition-colors {{ !request('category') ? 'border-[#ff9900] text-[#ff9900]' : 'border-transparent hover:bg-gray-900 hover:text-gray-200' }}">
                   Home
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}" 
                       class="px-6 py-3 font-bold uppercase text-sm whitespace-nowrap border-b-4 transition-colors {{ request('category') == $category->slug ? 'border-[#ff9900] text-[#ff9900]' : 'border-transparent hover:bg-gray-900 hover:text-gray-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">


        <div>
            <div class="flex items-center space-x-4 mb-6">
                <h2 class="text-2xl font-bold">Products</h2>
                <x-dropdown align="left" width="w-64">
                    <x-slot name="trigger">
                        <button class="inline-flex justify-between w-64 items-center px-4 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none transition ease-in-out duration-150">
                            <div>Filter Price</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="request()->fullUrlWithQuery(['sort_by' => 'price_asc'])" class="hover:text-[#ff9900] hover:bg-gray-50">
                            {{ __('Price: Low to High') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="request()->fullUrlWithQuery(['sort_by' => 'price_desc'])" class="hover:text-[#ff9900] hover:bg-gray-50">
                            {{ __('Price: High to Low') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-2xl hover:bg-[#ff9900] hover:-translate-y-2 hover:scale-105 group">
                        <a href="{{ route('product.detail', $product->slug) }}">

                            <div class="h-48 bg-gray-200 w-full flex items-center justify-center overflow-hidden">
                                @if($product->productImages->count() > 0)
                                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gray-400 group-hover:text-black">No Image</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-black truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 group-hover:text-black mb-2">{{ $product->productCategory->name }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-primary font-bold group-hover:text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-400 group-hover:text-black">{{ $product->store->city }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-public-layout>
