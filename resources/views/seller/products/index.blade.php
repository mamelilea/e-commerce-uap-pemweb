<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Product List</h3>
                        <a href="{{ route('seller.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Add New Product</a>
                    </div>
                    
                    @php
                        $products = \App\Models\Product::where('store_id', Auth::user()->store->id)->latest()->get();
                    @endphp

                    @if($products->isEmpty())
                        <p class="text-gray-500 text-center">No products found.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="border rounded-lg p-4 bg-white shadow-sm">
                                    <h4 class="font-bold truncate">{{ $product->name }}</h4>
                                    <p class="text-indigo-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('seller.products.edit', $product->id) }}" class="text-sm text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
