@extends('layouts.seller')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">Edit Kategori</h1>

<form action="#" method="POST" class="bg-white p-6 rounded-xl shadow max-w-xl">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="font-semibold">Nama Kategori</label>
        <input type="text" value="Cake" class="w-full border rounded p-2">
    </div>

    <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
        Update
    </button>
</form>

@endsection


 



