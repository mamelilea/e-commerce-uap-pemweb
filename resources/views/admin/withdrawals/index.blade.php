@extends('layouts.admin')

@section('title', 'Withdrawal Approvals')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Withdrawal Requests</h1>
        <p class="text-gray-600">Review and approve seller withdrawal requests</p>
    </div>

    @if($withdrawals->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($withdrawals as $withdrawal)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $withdrawal->storeBalance->store->name }}</div>
                        <div class="text-sm text-gray-500">{{ $withdrawal->storeBalance->store->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-lg text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">{{ $withdrawal->bank_name }}</div>
                        <div class="text-sm text-gray-600">{{ $withdrawal->bank_account_number }}</div>
                        <div class="text-xs text-gray-500">{{ $withdrawal->bank_account_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-bold rounded-full
                            {{ $withdrawal->status === 'approved' ? 'bg-success-100 text-success-700' : '' }}
                            {{ $withdrawal->status === 'pending' ? 'bg-warning-100 text-warning-700' : '' }}
                            {{ $withdrawal->status === 'rejected' ? 'bg-danger-100 text-danger-700' : '' }}">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $withdrawal->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        @if($withdrawal->status === 'pending')
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-success-600 hover:text-success-700 font-medium text-sm">
                                    ✓ Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" class="inline" onsubmit="return confirm('Reject this withdrawal? Balance will be returned to seller.')">
                                @csrf
                                <button type="submit" class="text-danger-600 hover:text-danger-700 font-medium text-sm">
                                    ✕ Reject
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $withdrawals->links() }}
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        <h3 class="text-lg font-bold text-gray-700 mb-2">No withdrawal requests</h3>
        <p class="text-gray-500">All withdrawal requests have been processed</p>
    </div>
    @endif
</div>
@endsection
