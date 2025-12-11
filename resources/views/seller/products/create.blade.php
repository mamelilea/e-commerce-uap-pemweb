@extends('layouts.seller')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">Tambah Produk</h1>

<form action="#" method="POST" class="bg-white p-6 rounded-xl shadow max-w-xl">
    @csrf

    <div class="mb-4">
        <label class="font-semibold">Nama Produk</label>
        <input type="text" class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="font-semibold">Harga</label>
        <input type="number" class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="font-semibold">Kategori</label>
        <select class="w-full border rounded p-2">
            <option>Pilih Kategori</option>
        </select>
    </div>

    <button class="bg-pink-600 text-white px-4 py-2 rounded-lg">Simpan</button>

</form>

@endsection



