@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-pink-700 mb-4">Checkout</h1>

    <div class="bg-white shadow p-5 rounded-xl">

        <h2 class="text-xl font-bold">{{ $product->name }}</h2>
        <p class="text-pink-600 font-bold">Rp {{ number_format($product->price) }}</p>

        <form action="{{ route('checkout.process') }}" method="POST" class="mt-5">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <label class="font-semibold">Alamat Pengiriman</label>
            <textarea name="address" class="w-full border p-2 rounded mt-2"></textarea>

            <label class="font-semibold mt-4 block">Jenis Pengiriman</label>
            <select name="shipping" class="w-full border p-2 rounded mt-2">
                <option value="regular">Reguler</option>
                <option value="express">Express</option>
            </select>

            <button class="mt-5 w-full bg-pink-500 text-white py-3 rounded-xl">
                Bayar Sekarang
            </button>
        </form>

    </div>
</div>
@endsection