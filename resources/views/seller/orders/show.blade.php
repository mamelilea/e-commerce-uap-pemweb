<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }} #{{ $transaction->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('seller.orders.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to Orders</a>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start border-b pb-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Order Date</p>
                            <p class="font-medium">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                             <p class="text-sm text-gray-500 mb-1">Status</p>
                             <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $transaction->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaction->payment_status) }}
                             </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="font-semibold text-lg mb-4">Customer Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium">{{ $transaction->buyer->user->name ?? 'Unknown' }}</p>
                                <p class="text-gray-600">{{ $transaction->buyer->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-lg mb-4">Shipping Destination</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium">Address:</p>
                                <p class="text-gray-600 mb-2">{{ $transaction->address }}</p>
                                <p class="text-gray-600">{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-semibold text-lg mb-4">Items Ordered</h3>
                    <div class="border rounded-lg overflow-hidden mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaction->transactionDetails as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if($detail->product->productImages->count() > 0)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" alt="">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $detail->product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detail->qty }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mb-8">
                        <div class="w-full md:w-1/3">
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Shipping ({{ $transaction->shipping }})</span>
                                <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-2 text-lg font-bold mt-2">
                                <span>Total Amount</span>
                                <span class="text-indigo-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-6">
                        <h3 class="font-semibold text-lg mb-4 text-blue-900">Order Fulfillment</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <div>
                                <p class="text-sm text-blue-800 mb-2">Current Status:</p>
                                <div class="flex items-center gap-2">
                                    @if($transaction->delivery_status == 'processing')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Processing</span>
                                    @elseif($transaction->delivery_status == 'shipped')
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Shipped</span>
                                    @elseif($transaction->delivery_status == 'received')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Completed</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                @if($transaction->delivery_status == 'received')
                                    <div class="bg-white p-4 rounded border border-green-200">
                                        <p class="text-green-700 font-medium flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Order Completed
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">Funds have been released to your balance.</p>
                                    </div>
                                @else
                                    <form action="{{ route('seller.orders.update', $transaction->id) }}" method="POST" class="bg-white p-4 rounded border">
                                        @csrf
                                        @method('PATCH')
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Update Tracking Number</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="tracking_number" value="{{ $transaction->tracking_number }}" placeholder="Enter Resi Number" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
