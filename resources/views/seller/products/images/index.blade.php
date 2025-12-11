@extends('layouts.seller')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">
    Gambar Produk: <span class="text-gray-700">Nama Produk</span>
</h1>

<a href="{{ route('seller.products.images.create') }}" 
   class="bg-pink-600 text-white px-4 py-2 rounded-lg">
   + Tambah Gambar
</a>

<table class="w-full mt-6 bg-white rounded-xl shadow">
    <thead>
        <tr class="border-b bg-pink-100">
            <th class="p-3">Gambar</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="p-3">
                <img src="https://via.placeholder.com/100" class="rounded-lg">
            </td>
            <td class="p-3">
                <a href="#" class="text-blue-500">Edit</a> |
                <a href="#" class="text-red-500">Hapus</a>
            </td>
        </tr>
    </tbody>
</table>

@endsection



 



