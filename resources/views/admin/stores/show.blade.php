@extends('layouts.admin')

@section('title', 'Review Store')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Review Store: {{ $store->name }}</h1>
            <p class="text-gray-600">Verify store information before approval</p>
        </div>
        <a href="{{ route('admin.stores.index') }}" class="btn-outline">← Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Store Information --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Store Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Store Name</label>
                        <p class="text-gray-900 font-bold">{{ $store->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">About</label>
                        <p class="text-gray-700">{{ $store->about }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Phone</label>
                            <p class="text-gray-900">{{ $store->phone }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">City</label>
                            <p class="text-gray-900">{{ $store->city }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Address</label>
                        <p class="text-gray-700">{{ $store->address }}</p>
                        <p class="text-gray-600">Postal Code: {{ $store->postal_code }}</p>
                    </div>

                    @if($store->logo)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Store Logo</label>
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="mt-2 w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Owner Information</h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Name</label>
                        <p class="text-gray-900 font-bold">{{ $store->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-900">{{ $store->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Member Since</label>
                        <p class="text-gray-700">{{ $store->user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Verification Status</h3>
                
                @if($store->is_verified)
                    <div class="bg-success-50 border border-success-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-2 text-success-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="font-bold">Verified</span>
                        </div>
                        <p class="text-sm text-success-600 mt-2">This store has been verified</p>
                    </div>
                @else
                    <div class="bg-warning-50 border border-warning-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-2 text-warning-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            <span class="font-bold">Pending Verification</span>
                        </div>
                        <p class="text-sm text-warning-600 mt-2">Awaiting admin approval</p>
                    </div>

                    <div class="space-y-3">
                        <form action="{{ route('admin.stores.approve', $store->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-success w-full">
                                ✓ Approve Store
                            </button>
                        </form>

                        <form action="{{ route('admin.stores.reject', $store->id) }}" method="POST" onsubmit="return confirm('Reject this store registration?')">
                            @csrf
                            <button type="submit" class="btn-outline w-full text-danger-500 border-danger-500 hover:bg-danger-50">
                                ✕ Reject Store
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-bold text-gray-700 mb-2">Registration Details</h4>
                <div class="text-xs text-gray-600 space-y-1">
                    <p>Registered: {{ $store->created_at->format('d M Y, H:i') }}</p>
                    <p>{{ $store->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
