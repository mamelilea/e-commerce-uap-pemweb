@extends('layouts.customer')

@section('title', 'Buka Toko Gratis')

@section('content')
<div class="min-h-screen bg-white flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Buka Toko Gratis
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Jangkau jutaan pembeli di seluruh Indonesia
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
            <form class="space-y-6" action="{{ route('seller.store') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Toko
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Contoh: Toko Bagus">
                    </div>
                </div>

                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">
                        Domain Toko
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                            tokopedia.com/
                        </span>
                        <input type="text" name="domain" id="domain" required class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-gray-300" placeholder="tokobagus">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Hanya huruf dan angka, tanpa spasi.</p>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Nomor Telepon
                    </label>
                    <div class="mt-1">
                        <input id="phone" name="phone" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            Kota
                        </label>
                        <div class="mt-1">
                            <input id="city" name="city" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">
                            Kode Pos
                        </label>
                        <div class="mt-1">
                            <input id="postal_code" name="postal_code" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        Alamat Lengkap
                    </label>
                    <div class="mt-1">
                        <textarea id="address" name="address" rows="3" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Buka Toko Gratis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
