@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 grid md:grid-cols-2 gap-10">

    {{-- GAMBAR PRODUK --}}
    <div>
        <img 
            src="{{ $product->images->isNotEmpty() 
                    ? asset('image/'.$product->images[0]->image_path) 
                    : asset('image/default.jpg') }}"
            class="w-full h-96 object-cover rounded-xl shadow-lg"
        >
    </div>

    {{-- DETAIL PRODUK --}}
    <div>
        <h1 class="text-4xl font-bold text-pink-700">
            {{ $product->name }}
        </h1>

        {{-- KATEGORI --}}
        <p class="mt-2 text-gray-600">
            <span class="font-semibold text-pink-700">Kategori:</span>
            {{ $product->category->name ?? 'Tidak ada kategori' }}
        </p>

        {{-- HARGA --}}
        <p class="mt-4 text-3xl font-bold text-pink-600">
            Rp {{ number_format($product->price) }}
        </p>

        {{-- DESKRIPSI --}}
        <p class="mt-4 text-gray-700 leading-relaxed">
            {{ $product->description }}
        </p>

        {{-- ULASAN (Dummy sementara) --}}
        <div class="mt-6 bg-pink-50 p-4 rounded-xl shadow-sm">
            <h3 class="font-semibold text-pink-700 text-lg mb-2">Ulasan</h3>
            <p class="text-gray-700 italic">Belum ada ulasan.</p>
        </div>

        {{-- TOMBOL BELI --}}
        <a href="{{ route('checkout.index', $product->id) }}"
           class="mt-6 inline-block bg-pink-500 text-white px-8 py-3 rounded-full shadow hover:bg-pink-600 transition">
            Beli Sekarang
        </a>
    </div>
</div>
@endsection