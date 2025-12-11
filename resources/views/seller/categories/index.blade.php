@extends('seller.layouts.layout')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">Daftar Kategori Produk</h1>

<a href="{{ route('seller.categories.create') }}" 
   class="bg-pink-600 text-white px-4 py-2 rounded-lg">
   + Tambah Kategori
</a>

<table class="w-full mt-6 bg-white rounded-xl shadow">
    <thead>
        <tr class="border-b bg-pink-100">
            <th class="p-3 text-left">Nama Kategori</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="p-3">Cake</td>
            <td class="p-3">
                <a href="#" class="text-blue-500">Edit</a> |
                <a href="#" class="text-red-500">Hapus</a>
            </td>
        </tr>
    </tbody>
</table>

@endsection



