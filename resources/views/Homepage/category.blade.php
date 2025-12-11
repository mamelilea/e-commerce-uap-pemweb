@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-20 px-6">

    <h1 class="text-4xl font-bold text-pink-700 mb-6">
        {{ $category->name }}
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($products as $product)
        <a href="{{ route('product.show', $product->slug) }}"
           class="block bg-white p-4 rounded-xl shadow hover:scale-105 duration-300">

            <img src="{{ $product->images->first()->url ?? asset('image/noimg.jpg') }}"
                 class="w-full h-40 object-cover rounded-lg mb-3">

            <h3 class="font-semibold text-pink-700">{{ $product->name }}</h3>

            <p class="text-pink-500 font-bold mt-2">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        </a>
        @endforeach

    </div>

</div>
@endsection
