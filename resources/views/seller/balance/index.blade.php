<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Store Balance & Withdrawals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

             @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Current Balance</h3>
                        <p class="text-4xl font-bold text-indigo-600 mb-6">Rp {{ number_format($balance->balance, 0, ',', '.') }}</p>

                        <h4 class="font-semibold mb-2">Request Withdrawal</h4>
                        <form action="{{ route('seller.balance.withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="amount" :value="__('Amount (Rp)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" min="10000" placeholder="Min. 10.000" required />
                            </div>
                            <x-primary-button>
                                {{ __('Request Withdrawal') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>


                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Bank Details</h3>
                        <form action="{{ route('seller.balance.bank') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <x-input-label for="bank_name" :value="__('Bank Name')" />
                                <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name" :value="$store->bank_name" placeholder="e.g. BCA, Mandiri" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="bank_account_name" :value="__('Account Holder Name')" />
                                <x-text-input id="bank_account_name" class="block mt-1 w-full" type="text" name="bank_account_name" :value="$store->bank_account_name" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="bank_account_number" :value="__('Account Number')" />
                                <x-text-input id="bank_account_number" class="block mt-1 w-full" type="text" name="bank_account_number" :value="$store->bank_account_number" required />
                            </div>
                            <x-primary-button>
                                {{ __('Save Bank Details') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Withdrawal History</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Date</th>
                                    <th class="py-2 px-4 border-b text-left">Amount</th>
                                    <th class="py-2 px-4 border-b text-left">To Account</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                                        <td class="py-2 px-4 border-b">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ $withdrawal->bank_name }} - {{ $withdrawal->bank_account_number }} ({{ $withdrawal->bank_account_name }})
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <span class="px-2 py-1 rounded text-xs 
                                                @if($withdrawal->status == 'approved') bg-green-100 text-green-800 
                                                @elseif($withdrawal->status == 'rejected') bg-red-100 text-red-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-500">No withdrawal history.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
