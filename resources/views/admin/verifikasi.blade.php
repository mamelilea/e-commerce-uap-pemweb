<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-300 leading-tight">
            {{ __('VERIFIKASI TOKO') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white h-auto shadow-sm sm:rounded-lg py-10 px-10 mt-10">

                <h3 class="text-lg font-bold mb-5">Daftar Toko Pending</h3>
                @foreach ($pendingStores as $store)
                    <div class="p-4 border rounded mb-4">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-32 h-32 object-cover rounded">
                            <div>
                                <h3 class="font-bold text-lg">{{ $store->name }}</h3>
                                <p>Pemilik: {{ $store->user->name }}</p>
                                <p>Email: {{ $store->user->email }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-4 justify-end">
                            <form action="{{ route('admin.store.approve', $store->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 px-4 py-2 text-white rounded">Setujui</button>
                            </form>
                            <form action="{{ route('admin.store.reject', $store->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 px-4 py-2 text-white rounded">Tolak</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white h-auto shadow-sm sm:rounded-lg py-10 px-10 mt-10">
                <h3 class="text-lg font-bold mb-5 mt-10">Toko Terverifikasi</h3>
                @foreach ($verifiedStores as $store)
                    <div class="p-4 border rounded mb-4">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-32 h-32 object-cover rounded">
                            <div>
                                <h3 class="font-bold text-lg">{{ $store->name }}</h3>
                                <p>Pemilik: {{ $store->user->name }}</p>
                                <p>Email: {{ $store->user->email }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
