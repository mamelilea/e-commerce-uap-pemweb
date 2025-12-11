@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-4xl font-bold text-pink-700 mb-6">
        Kategori: {{ $category->name }}
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($products as $p)
        <div class="bg-white shadow rounded-xl p-3 hover:scale-105 duration-300">
            <img src="{{ asset('image/'.$p->images[0]->image_path) }}" 
                 class="w-full h-40 object-cover rounded-lg">

            <h3 class="font-semibold mt-3">{{ $p->name }}</h3>
            <p class="text-pink-600 font-bold">Rp {{ number_format($p->price) }}</p>

            <a href="{{ route('products.detail', $p->id) }}"
               class="inline-block mt-3 w-full bg-pink-500 text-white p-2 rounded-lg text-center">
               Detail
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection