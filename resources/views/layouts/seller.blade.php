<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard - SweetCake</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-pink-50">

    <div class="flex">
       
        <aside class="w-64 bg-pink-200 h-screen p-4">
            <h2 class="text-xl font-bold mb-4">SweetCake Seller</h2>

            <ul class="space-y-3">
                <li><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('seller.register') }}">Registrasi Toko</a></li>
                <li><a href="{{ route('seller.products.index') }}">Produk</a></li>
                <li><a href="{{ route('seller.categories.index') }}">Kategori</a></li>
                <li><a href="{{ route('seller.orders.index') }}">Pesanan</a></li>
                <li><a href="{{ route('seller.balance.index') }}">Saldo</a></li>
                <li><a href="{{ route('seller.withdraw.index') }}">Penarikan</a></li>
            </ul>
        </aside>

    
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
