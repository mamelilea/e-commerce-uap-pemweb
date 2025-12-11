<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetCake | Home</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .logo-font { font-family: 'Parisienne', cursive; }
    </style>
</head>

<body class="bg-pink-50">

<!-- NAVBAR / HEADER -->
<header class="fixed top-0 w-full z-50 bg-pink-700/30 backdrop-blur-lg shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <h1 class="text-5xl font-bold text-pink-600 logo-font tracking-wide">
            SweetCake
        </h1>

        <!-- Search Bar -->
        <div class="hidden md:flex items-center w-1/3 bg-pink-50 border border-pink-200 rounded-full px-4 py-2 shadow-sm">
            <i class="fas fa-search text-pink-400"></i>
            <input 
                type="text" 
                placeholder="Cari kue favoritmu..." 
                class="w-full bg-transparent focus:outline-none px-3 text-pink-700"
            >
        </div>

        <!-- NAVIGATION -->
        <nav class="hidden md:flex space-x-8 font-semibold text-pink-800">
            <a href="#home" class="hover:text-pink-500 transition">Home</a>
            <a href="#products" class="hover:text-pink-500 transition">Produk</a>
            <a href="#cart" class="hover:text-pink-500 transition">Keranjang</a>
        </nav>

        <!-- ICON USER -->
        <div class="flex items-center text-pink-600 text-2xl space-x-6">

            @auth
                <a href="{{ route('profile.edit') }}"
                   class="hover:text-pink-400 transition"
                   title="Profile">
                    <i class="fas fa-user"></i>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="hover:text-pink-400 transition"
                   title="Login">
                    <i class="fas fa-user"></i>
                </a>
            @endauth

        </div>

        <!-- MOBILE ICON -->
        <div class="md:hidden text-2xl text-pink-700">
            <i class="fas fa-bars"></i>
        </div>

    </div>
</header>

<!-- ================= HERO ================= -->
<section id="home" class="pt-36 pb-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <div>
            <h1 class="text-5xl md:text-6xl font-bold text-pink-700 leading-tight">
                Fresh <span class="text-pink-500">Cakes</span> Everyday 🍰
            </h1>
            <p class="text-pink-700 mt-4 text-lg">
                Kue dibuat setiap hari dengan bahan premium, rasa lembut, dan tampilan elegan.
            </p>
            <a href="#products"
               class="inline-block mt-6 bg-pink-500 text-white px-8 py-3 rounded-full shadow-lg hover:bg-pink-600 transition">
                Explore Products
            </a>
        </div>

        <img src="{{ asset('image/home.jpg') }}"
             class="rounded-xl drop-shadow-xl w-full h-80 object-cover">
    </div>
</section>
<!-- ================= ALL PRODUCTS ================= -->
<section id="products" class="py-20 bg-white">
    <h2 class="text-center text-4xl font-bold text-pink-700">
        Kategori <span class="text-pink-500">Kue</span>
    </h2>

    <p class="text-center text-pink-600 mt-2">
        Fresh, Sweet, and Made With Love
    </p>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 mt-10">

        {{-- Category 1 --}}
        <a href="category" class="block">
            <div class="text-center bg-white p-4 rounded-xl shadow hover:scale-105 duration-300 cursor-pointer">
                <img src="{{ asset('image/cake 2.jpg') }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
                <h3 class="font-semibold">Birthday Cake</h3>
            </div>
        </a>

        {{-- Category 2 --}}
        <a href="#" class="block">
            <div class="text-center bg-white p-4 rounded-xl shadow hover:scale-105 duration-300 cursor-pointer">
                <img src="{{ asset('image/Cookies 1.jpeg') }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
                <h3 class="font-semibold">Cookies</h3>
            </div>
        </a>

        {{-- Category 3 --}}
        <a href="#" class="block">
            <div class="text-center bg-white p-4 rounded-xl shadow hover:scale-105 duration-300 cursor-pointer">
                <img src="{{ asset('image/Cupcake 1.jpeg') }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
                <h3 class="font-semibold">Cupcake</h3>
            </div>
        </a>

        {{-- Category 4 --}}
        <a href="#" class="block">
            <div class="text-center bg-white p-4 rounded-xl shadow hover:scale-105 duration-300 cursor-pointer">
                <img src="{{ asset('image/Pastry 1.jpeg') }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
                <h3 class="font-semibold">Pastry</h3>
            </div>
        </a>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="w-full bg-pink-200 py-10 mt-16">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-3xl font-bold text-pink-700">SweetCake.</h1>
        <p class="text-pink-700 mt-2">Made with love and sweetness</p>
        <p class="mt-6 text-pink-800">&copy; 2025 SweetCake — All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>