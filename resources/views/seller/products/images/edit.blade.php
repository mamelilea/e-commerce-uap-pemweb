@extends('layouts.seller')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">
    Edit Gambar Produk
</h1>

<form action="#" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-xl shadow max-w-xl">

    @csrf
    @method('PUT')

    <div class="mb-4">
        <p class="font-semibold mb-2">Gambar Saat Ini:</p>
        <img src="https://via.placeholder.com/150" class="rounded-lg mb-3">
    </div>

    <div class="mb-4">
        <label class="font-semibold">Ganti Gambar</label>
        <input type="file" name="image" class="w-full border rounded p-2">
    </div>

    <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
        Update
    </button>

</form>

@endsection




