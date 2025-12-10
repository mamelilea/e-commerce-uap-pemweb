<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($cartItems->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Your cart is empty.</p>
                            <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Continue Shopping</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="border-b">
                                    <tr>
                                        <th class="text-left py-4 px-4">Product</th>
                                        <th class="text-left py-4 px-4">Quantity</th>
                                        <th class="text-left py-4 px-4">Price</th>
                                        <th class="text-left py-4 px-4">Total</th>
                                        <th class="text-left py-4 px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-4 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-16 h-16 bg-gray-200 rounded overflow-hidden mr-4">
                                                        @if($item->product->productImages->count() > 0)
                                                            <img src="{{ asset('storage/' . $item->product->productImages->first()->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="flex items-center justify-center h-full text-xs text-gray-400">No Image</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('product.detail', $item->product->slug) }}" class="font-semibold hover:text-indigo-600">{{ $item->product->name }}</a>
                                                        <p class="text-xs text-gray-500">Store: {{ $item->product->store->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="flex items-center border border-gray-300 rounded w-max">
                                                    <button type="button" class="px-2 py-1 text-gray-600 hover:bg-gray-100 border-r border-gray-300 btn-decrement" data-id="{{ $item->id }}">-</button>
                                                    <input type="number" 
                                                           id="quantity-{{ $item->id }}"
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           class="quantity-input w-12 text-center text-sm p-1 border-none focus:ring-0"
                                                           data-id="{{ $item->id }}"
                                                           data-url="{{ route('cart.update', $item->id) }}">
                                                    <button type="button" class="px-2 py-1 text-gray-600 hover:bg-gray-100 border-l border-gray-300 btn-increment" data-id="{{ $item->id }}">+</button>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td class="py-4 px-4 font-semibold">Rp <span id="item-total-{{ $item->id }}">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span></td>
                                            <td class="py-4 px-4">
                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-xs">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right py-4 px-4 font-bold text-lg">Grand Total:</td>
                                        <td class="py-4 px-4 font-bold text-lg text-indigo-600">Rp <span id="grand-total">{{ number_format($total, 0, ',', '.') }}</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-between items-center">
                            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Continue Shopping</a>
                            
                            <a href="{{ route('cart.checkout') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded shadow-md transition">
                                Proceed to Checkout
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            function updateCart(cartId, quantity, url) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`item-total-${cartId}`).textContent = data.item_total;
                        document.getElementById('grand-total').textContent = data.grand_total;
                    }
                })
                .catch(error => console.error('Error:', error));
            }


            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartId = this.dataset.id;
                    const url = this.dataset.url;
                    let quantity = parseInt(this.value);
                    if (quantity < 1) {
                        quantity = 1;
                        this.value = 1;
                    }
                    updateCart(cartId, quantity, url);
                });
            });


            document.querySelectorAll('.btn-increment').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartId = this.dataset.id;
                    const input = document.getElementById(`quantity-${cartId}`);
                    let quantity = parseInt(input.value);
                    quantity++;
                    input.value = quantity;
                    updateCart(cartId, quantity, input.dataset.url);
                });
            });


            document.querySelectorAll('.btn-decrement').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartId = this.dataset.id;
                    const input = document.getElementById(`quantity-${cartId}`);
                    let quantity = parseInt(input.value);
                    if (quantity > 1) {
                        quantity--;
                        input.value = quantity;
                        updateCart(cartId, quantity, input.dataset.url);
                    }
                });
            });
        });
    </script>
</x-app-layout>
