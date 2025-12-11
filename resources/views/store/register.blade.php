@extends('layouts.seller')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">Registrasi Toko</h1>

<form action="#" method="POST" class="bg-white p-6 rounded-xl shadow max-w-lg">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold mb-1">Nama Toko</label>
        <input type="text" class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Deskripsi Toko</label>
        <textarea class="w-full border rounded p-2"></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Alamat Toko</label>
        <input type="text" class="w-full border rounded p-2">
    </div>

    <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
        Simpan
    </button>

</form>

@endsection
