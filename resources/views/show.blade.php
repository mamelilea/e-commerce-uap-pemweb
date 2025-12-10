<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

    <div class="p-4 border rounded-lg shadow">
        <p class="text-lg">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p class="text-gray-600 mt-2">{{ $product->description }}</p>
    </div>

    <a href="{{ route('dashboard') }}" class="text-blue-600 underline mt-4 inline-block">
        ← Kembali ke Dashboard
    </a>
</x-app-layout>