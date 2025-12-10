<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($transactions->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">You have no orders yet.</p>
                            <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Start Shopping</a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($transactions as $transaction)
                                <div class="border rounded-lg p-4 flex flex-col md:flex-row justify-between items-start md:items-center disabled-link {{ $transaction->delivery_status == 'received' ? 'bg-gray-100 border-gray-300 opacity-75' : 'bg-white border-gray-200 shadow-sm' }}">
                                    <div>
                                        <p class="font-bold text-gray-800">Order #{{ $transaction->code }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y') }}</p>
                                        <p class="text-sm font-medium mt-1">{{ $transaction->store->name }}</p>
                                    </div>
                                    <div class="mt-4 md:mt-0 text-right">
                                        <p class="text-indigo-600 font-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                                        <div class="mt-2 text-right">
                                            @if($transaction->delivery_status == 'received')
                                                <div class="flex flex-col items-end gap-2">
                                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        Completed
                                                    </div>
                                                    @if(!$transaction->isFullyReviewedBy(auth()->user()))
                                                        <a href="{{ route('reviews.create', $transaction->id) }}" class="inline-flex items-center px-4 py-2 bg-[#ff9900] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 focus:outline-none focus:border-orange-900 focus:ring ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                            Rate Products
                                                        </a>
                                                    @endif
                                                </div>
                                            @elseif($transaction->tracking_number)
                                                 <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-1 inline-block">Shipped: {{ $transaction->tracking_number }}</span>
                                                 <br>
                                                 <form action="{{ route('orders.complete', $transaction->id) }}" method="POST" class="inline-block mt-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1 rounded-md transition duration-150 ease-in-out" onclick="return confirm('Confirm that you have received this order? Funds will be released to the seller.');">
                                                        Confirm Received
                                                    </button>
                                                 </form>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Processing</span>
                                            @endif
                                            
                                        </div>
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
