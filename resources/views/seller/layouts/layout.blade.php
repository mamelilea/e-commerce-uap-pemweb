<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard - SweetCake</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-pink-50">

    <div class="flex">
        
        {{-- Sidebar --}}
        @include('seller.layouts.navigation')

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
