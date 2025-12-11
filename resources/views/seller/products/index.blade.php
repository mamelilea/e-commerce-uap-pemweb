@extends('seller.layouts.layout')

@section('content')

<h1 class="text-2xl font-bold text-pink-700 mb-6">Daftar Produk</h1>

<a href="{{ route('seller.products.create') }}" 
   class="bg-pink-600 text-white px-4 py-2 rounded-lg">
   + Tambah Produk
</a>

<table class="w-full mt-6 bg-white rounded-xl shadow">
    <thead>
        <tr class="border-b bg-pink-100">
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Harga</th>
            <th class="p-3 text-left">Kategori</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="p-3">Contoh Produk</td>
            <td class="p-3">Rp 10.000</td>
            <td class="p-3">Cookies</td>
            <td class="p-3">
                <a href="#" class="text-blue-500">Edit</a> |
                <a href="#" class="text-red-500">Hapus</a>
            </td>
        </tr>
    </tbody>
</table>

@endsection
