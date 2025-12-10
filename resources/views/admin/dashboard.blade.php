<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Pending Store Verifications</h3>

                    @if($pendingStores->isEmpty())
                        <div class="mt-4 p-4 border rounded bg-gray-50 text-center text-gray-500">
                            No pending verifications.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">Store Name</th>
                                        <th class="py-2 px-4 border-b text-left">Owner</th>
                                        <th class="py-2 px-4 border-b text-left">City</th>
                                        <th class="py-2 px-4 border-b text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingStores as $store)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $store->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $store->user->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $store->city }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <form action="{{ route('admin.store.approve', $store->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm">
                                                        Approve
                                                    </button>
                                                </form>
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


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Pending Withdrawals</h3>
                    @if($pendingWithdrawals->isEmpty())
                        <div class="mt-4 p-4 border rounded bg-gray-50 text-center text-gray-500">
                            No pending withdrawal requests.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">Store</th>
                                        <th class="py-2 px-4 border-b text-left">Amount</th>
                                        <th class="py-2 px-4 border-b text-left">Bank Details</th>
                                        <th class="py-2 px-4 border-b text-left">Date</th>
                                        <th class="py-2 px-4 border-b text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingWithdrawals as $withdrawal)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                {{ $withdrawal->storeBalance->store->name ?? 'Unknown Store' }}
                                                <div class="text-xs text-gray-500">{{ $withdrawal->storeBalance->store->user->name ?? 'Unknown Owner' }}</div>
                                            </td>
                                            <td class="py-2 px-4 border-b font-bold text-indigo-600">
                                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="py-2 px-4 border-b text-sm">
                                                <div class="font-semibold">{{ $withdrawal->bank_name }}</div>
                                                <div>{{ $withdrawal->bank_account_number }}</div>
                                                <div class="text-gray-500">{{ $withdrawal->bank_account_name }}</div>
                                            </td>
                                            <td class="py-2 px-4 border-b text-sm text-gray-600">
                                                {{ $withdrawal->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <form action="{{ route('admin.withdrawal.approve', $withdrawal->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm" onclick="return confirm('Approve this withdrawal?');">
                                                        Approve
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left w-12">ID</th>
                                    <th class="py-2 px-4 border-b text-left">Name</th>
                                    <th class="py-2 px-4 border-b text-left">Email</th>
                                    <th class="py-2 px-4 border-b text-left">Role</th>
                                    <th class="py-2 px-4 border-b text-left">Joined</th>
                                    <th class="py-2 px-4 border-b text-left w-32">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                                        <td class="py-2 px-4 border-b font-medium">{{ $user->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @if($user->id !== Auth::id())
                                                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('To confirm DELETION, clicks OK. This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm w-full">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Stores</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left w-12">ID</th>
                                    <th class="py-2 px-4 border-b text-left">Store Name</th>
                                    <th class="py-2 px-4 border-b text-left">Owner</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                    <th class="py-2 px-4 border-b text-left w-32">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $store->id }}</td>
                                        <td class="py-2 px-4 border-b font-medium">{{ $store->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $store->user->name }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $store->is_verified ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $store->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b flex gap-2">
                                            <form action="{{ route('admin.store.suspend', $store->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="py-1 px-3 rounded text-sm text-white {{ $store->is_suspended ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600' }}">
                                                    {{ $store->is_suspended ? 'Activate' : 'Suspend' }}
                                                </button>
                                            </form>

                                             <form action="{{ route('admin.store.destroy', $store->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store? All products and data will be removed.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
