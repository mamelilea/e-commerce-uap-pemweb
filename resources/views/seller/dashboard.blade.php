<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->store->is_suspended)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Store Suspended</p>
                            <p>Your store has been suspended by the administrator. All store activities are currently disabled.</p>
                        </div>
                    @elseif(!Auth::user()->store->is_verified)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Pending Verification</p>
                            <p>Your store is currently awaiting verification from the admin. Some features may be limited.</p>
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold mb-4">Welcome back, {{ Auth::user()->store->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h4 class="text-blue-800 font-medium">Total Products</h4>
                            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <h4 class="text-green-800 font-medium">Total Orders</h4>
                            <p class="text-3xl font-bold text-green-900 mt-2">{{ $totalOrders }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                            <h4 class="text-purple-800 font-medium">Store Balance</h4>
                            <p class="text-3xl font-bold text-purple-900 mt-2">Rp {{ number_format($storeBalance->balance, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold mb-4">Quick Actions</h4>
                        <div class="flex gap-4">
                            <a href="{{ route('seller.products.create') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Add New Product</a>
                            <a href="{{ route('seller.orders.index') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">Manage Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
