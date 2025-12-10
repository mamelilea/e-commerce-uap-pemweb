@extends('layouts.app') // Menggunakan layout yang sudah diubah ke @yield('content')

@section('title', 'Detail Toko: ' . $store->name)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
        
        {{-- =========================================== --}}
        {{-- BAGIAN PROFIL TOKO --}}
        {{-- =========================================== --}}
        <div class="flex flex-col md:flex-row items-start md:items-center mb-8 pb-6 border-b border-gray-200">
            
            {{-- FOTO TOKO --}}
            <div class="w-24 h-24 md:w-32 md:h-32 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0 mb-4 md:mb-0">
                @if ($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo {{ $store->name }}" class="w-full h-full object-cover">
                @else
                    {{-- Placeholder jika tidak ada logo --}}
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L14 14m0 0l4-4m-4 4V7m0 7h7"></path></svg>
                @endif
            </div>

            <div class="md:ml-6 flex-grow">
                {{-- NAMA TOKO --}}
                <h1 class="text-4xl font-extrabold text-[#1A1A1A]">{{ $store->name }}</h1>
                
                {{-- RATING TOKO (Placeholder Bintang) --}}
                <div class="flex items-center mt-2 text-yellow-500">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    @endfor
                    <span class="ml-2 text-sm font-semibold text-gray-700">4.5</span>
                    <span class="ml-1 text-sm text-gray-500">(150 Ulasan)</span>
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    {{-- TANGGAL TOKO DIBUAT --}}
                    <p class="mb-1"><span class="font-semibold">Bergabung Sejak:</span> {{ $store->created_at->format('d M Y') }}</p>
                    <p><span class="font-semibold">Pemilik:</span> {{ $store->user->name }}</p>
                </div>
            </div>
        </div>

        {{-- DESKRIPSI TOKO --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2 text-[#00B207]">Deskripsi Toko</h2>
            <p class="text-gray-700">{{ $store->about ?? 'Toko ini belum menambahkan deskripsi.' }}</p>
        </div>


        {{-- =========================================== --}}
        {{-- CARD PRODUK TOKO --}}
        {{-- =========================================== --}}
        @php
            // Menghitung jumlah produk dengan aman untuk menghindari error 'count() on null'
            $productCount = $store->products ? $store->products->count() : 0;
        @endphp

        <h2 class="text-2xl font-bold mb-6 text-gray-900 border-t pt-6">
            Daftar Produk ({{ $productCount }})
        </h2>
        
        {{-- Pengecekan: Pastikan relasi produk ada DAN jumlahnya lebih dari 0 --}}
        @if ($store->products && $store->products->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                
                @foreach ($store->products as $product)
                    <a href="{{ route('product.detail', $product->slug) }}" class="block border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                        
                        {{-- GAMBAR PRODUK --}}
                        <div class="h-32 bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if ($product->product_images && $product->product_images->first())
                                <img src="{{ asset('storage/' . $product->product_images->first()->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full transform hover:scale-105 transition duration-300">
                            @else
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L14 14m0 0l4-4m-4 4V7m0 7h7"></path></svg>
                            @endif
                        </div>
                        
                        {{-- INFO PRODUK --}}
                        <div class="p-3">
                            <h3 class="font-medium text-gray-800 line-clamp-1 hover:text-[#00B207]">{{ $product->name }}</h3>
                            <p class="text-lg font-bold text-[#00B207] mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <span class="text-xs text-gray-500">Stok: {{ $product->stock }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Toko ini belum memiliki produk yang terdaftar.</p>
            </div>
        @endif

    </div>
</div>
@endsection