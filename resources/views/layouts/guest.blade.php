@props(['title' => '']) <!-- mendefinisikan prop title -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Figtree', sans-serif;
        }

        .split {
            display: flex;
            height: 100vh;
        }

        .left {
            flex: 0 0 30%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .right {
            flex: 0 0 70%;
            background-color: #0667d0; /* warna biru tetap! */

            background-image: url('{{ asset('img/login-gadget.svg') }}');
            background-repeat: no-repeat;
            background-position: center center; /* biar di tengah */
            background-size: 80%; /* PERKECIL gambar — bisa disesuaikan 40–60% */

            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }

        .logo-container {
            margin-bottom: 1rem;
            text-align: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .form-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            padding: 0.75rem 1rem;
            width: 100%;
            margin-bottom: 1rem;
        }


        .form-container button {
            background-color: #0667d0;
            color: white;
            padding: 0.75rem;
            width: 100%;
            border-radius: 0.5rem;
            font-weight: 600;
            margin-top: 0.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        /* Fix checkbox alignment */
        #remember_me {
            width: 16px !important;
            height: 16px !important;
            margin: 0;
        }

        label[for="remember_me"] {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        label[for="remember_me"] span {
            line-height: 1;
            margin-top: 2px;
        }

        .form-container button:hover {
            background-color: #0554a3;
        }

        .form-container a {
            color: #0667d0;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="split">
        <!-- Kiri: Form + Logo -->
        <div class="left">
            <!-- Logo di atas form -->
            <div class="logo-container">
                <x-application-logo style="width:200px; height:auto;" />
            </div>

            <div class="form-container">
                <!-- Judul halaman (Login / Register) -->
                @if ($title)
                    <div class="form-title">{{ $title }}</div>
                @endif

                {{ $slot }}
            </div>
        </div>

        <!-- Kanan: Placeholder Gambar / Ilustrasi -->
        <div class="right">

        </div>
    </div>
</body>
</html>
