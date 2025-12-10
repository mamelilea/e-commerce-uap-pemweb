<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($transactions->isEmpty())
                        <p class="text-gray-500 text-center">No orders yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Order ID</th>
                                        <th class="py-2 px-4 border-b">Buyer</th>
                                        <th class="py-2 px-4 border-b">Total</th>
                                        <th class="py-2 px-4 border-b">Payment</th>
                                        <th class="py-2 px-4 border-b">Tracking No.</th>
                                        <th class="py-2 px-4 border-b">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('seller.orders.show', $transaction->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline">
                                                    #{{ $transaction->code }}
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $transaction->buyer ? $transaction->buyer->user->name : 'Unknown' }}</td>
                                            <td class="py-2 px-4 border-b">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <span class="px-2 py-1 rounded text-xs {{ $transaction->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($transaction->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                {{ $transaction->tracking_number ?? 'Not Shipped' }}
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex flex-col gap-2">
                                                    <a href="{{ route('seller.orders.show', $transaction->id) }}" class="bg-gray-100 text-gray-700 text-center text-xs px-2 py-1 rounded hover:bg-gray-200">
                                                        View Details
                                                    </a>
                                                    @if($transaction->delivery_status == 'received')
                                                        <span class="bg-green-100 text-green-800 text-center text-xs px-2 py-1 rounded">Completed</span>
                                                    @else
                                                        <form action="{{ route('seller.orders.update', $transaction->id) }}" method="POST" class="flex gap-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="text" name="tracking_number" placeholder="Input Resi" value="{{ $transaction->tracking_number }}" class="text-sm border rounded w-24 px-2 py-1">
                                                            <button type="submit" class="bg-blue-500 text-white text-xs px-2 py-1 rounded">Upd</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
