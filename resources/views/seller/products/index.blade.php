<x-app-layout>
    <x-slot name="header">
        <h2 class="font-header font-bold text-3xl uppercase text-hubbub-black leading-tight tracking-tighter">
            {{ __('Manage Products') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-hubbub-gray min-h-screen animate-fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                
                <div class="border-b border-gray-100 pb-6 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="font-sans text-xl font-bold uppercase text-hubbub-black tracking-tight">My Products</h3>
                    <a href="{{ route('seller.products.create') }}" class="w-full sm:w-auto text-center bg-hubbub-black text-white font-sans font-bold uppercase px-8 py-3 rounded-full hover:bg-hubbub-pink transition-all shadow-lg hover:shadow-pink-200 transform hover:-translate-y-0.5 text-xs tracking-wider">Add New Product</a>
                </div>

                @if($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-l-xl">Image</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Name</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Price</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Stock</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest">Status</th>
                                    <th class="px-5 py-4 bg-pink-50 text-left text-[10px] font-sans font-bold text-hubbub-pink uppercase tracking-widest rounded-r-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-5 text-sm">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-lg border border-gray-100 bg-gray-50 overflow-hidden">
                                                @if($product->productImages->first())
                                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="" />
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-300 font-sans font-bold uppercase">No IMG</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <p class="font-bold font-sans text-gray-800 uppercase text-xs tracking-wide">{{ $product->name }}</p>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <p class="font-sans font-bold text-hubbub-pink">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-5 py-5 text-sm font-sans font-medium text-gray-600">
                                            {{ $product->stock }}
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <span class="relative inline-block px-3 py-1 text-[10px] font-sans font-bold uppercase leading-tight {{ $product->is_active ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} rounded-full">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 text-sm">
                                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 font-sans font-bold uppercase text-[10px] transition-colors tracking-wider">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 mt-4">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="p-16 text-center">
                         <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-hubbub-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <p class="font-sans text-xl font-bold uppercase text-gray-400 mb-2">No products found</p>
                         <p class="text-gray-400 text-sm mb-6">Start building your catalog today.</p>
                        <a href="{{ route('seller.products.create') }}" class="inline-block bg-hubbub-black text-white font-sans font-bold uppercase px-8 py-3 rounded-full hover:bg-hubbub-pink transition-colors">Start Selling</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
