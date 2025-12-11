@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-20 px-6 grid md:grid-cols-2 gap-10">

    <!-- IMAGE -->
    <img src="{{ $product->images->first()->url ?? asset('image/noimg.jpg') }}"
         class="rounded-xl shadow-xl w-full h-96 object-cover">

    <!-- INFO -->
    <div>
        <h1 class="text-5xl font-bold text-pink-700">{{ $product->name }}</h1>

        <p class="text-xl text-pink-600 mt-4 font-semibold">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>

        <p class="mt-6 text-gray-700 leading-relaxed">
            {{ $product->description }}
        </p>

        <button class="mt-6 px-8 py-3 bg-pink-500 text-white rounded-full shadow-lg hover:bg-pink-600">
            Tambah ke Keranjang
        </button>
    </div>

</div>
@endsection
