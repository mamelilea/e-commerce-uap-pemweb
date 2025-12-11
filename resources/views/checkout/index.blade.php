@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-4">Checkout</h1>

    <div class="bg-white rounded-lg shadow p-6">

        <p class="text-xl font-semibold">{{ $product->name }}</p>
        <p class="text-gray-600 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('checkout.process', $product->id) }}" method="POST">
            @csrf
            
            <label class="block mt-3">Nama Lengkap</label>
            <input type="text" name="nama" class="w-full px-3 py-2 border rounded">

            <label class="block mt-3">Alamat Lengkap</label>
            <textarea name="alamat" class="w-full px-3 py-2 border rounded"></textarea>

            <label class="block mt-3">Jenis Pengiriman</label>
            <select name="pengiriman" class="w-full px-3 py-2 border rounded">
                <option value="regular">Regular</option>
                <option value="express">Express</option>
                <option value="instant">Instant</option>
            </select>

            <button class="mt-6 bg-pink-500 text-white px-6 py-3 rounded hover:bg-pink-600">
                Selesaikan Pembelian
            </button>

        </form>
    </div>

</div>
@endsection