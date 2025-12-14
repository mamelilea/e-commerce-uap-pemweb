<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Seller Portal - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #09090b; /* Zinc 950 */
            color: #e4e4e7; /* Zinc 200 */
        }
        
        .glass-panel {
            background-color: #18181b; /* Zinc 900 */
            border: 1px solid #27272a; /* Zinc 800 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .input-dark {
            background-color: #27272a; /* Zinc 800 */
            border: 1px solid #3f3f46; /* Zinc 700 */
            color: #fff;
        }
        
        .input-dark:focus {
            border-color: #6366f1; /* Indigo 500 */
            ring-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .step-number {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    
    <!-- Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] -right-[10%] w-[500px] h-[500px] rounded-full bg-indigo-900/20 blur-[100px]"></div>
        <div class="absolute bottom-[-10%] -left-[10%] w-[500px] h-[500px] rounded-full bg-blue-900/20 blur-[100px]"></div>
    </div>

    <!-- Minimal Header -->
    <header class="py-6 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                   <span class="text-black font-black text-xs tracking-tighter">Y2K</span>
                </div>
                <div>
                    <h1 class="font-bold text-white text-lg tracking-tight">Y2K Accessories</h1>
                    <p class="text-xs text-zinc-500 font-medium tracking-wide uppercase">ring • necklace • bracelet • sunglasses • charms</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-zinc-400 hover:text-white transition-colors">
                Batalkan Membuat Toko
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl">
            
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Daftarkan Toko Anda</h2>
                <p class="mt-3 text-lg text-zinc-400">
                    Bergabunglah sebagai mitra resmi dan mulai kelola bisnis Y2K Accessories Anda secara profesional.
                </p>
            </div>

            <div class="glass-panel rounded-2xl p-8 sm:p-10 relative overflow-hidden">
                <!-- Decorative Top Line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <form method="POST" action="{{ route('store.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Section 1 -->
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="step-number w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm">1</div>
                            <h3 class="text-xl font-semibold text-white">Identitas Brand</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-12">
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-zinc-400">Nama Toko</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all"
                                    placeholder="Contoh: Cyber Aesthetics">
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-zinc-400">Kontak Bisnis</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all"
                                    placeholder="08xxxxxxxxxx">
                                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label for="about" class="block text-sm font-medium text-zinc-400">Deskripsi Singkat</label>
                                <textarea id="about" name="about" rows="3"
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all"
                                    placeholder="Jelaskan konsep unik dari toko Anda...">{{ old('about') }}</textarea>
                                <x-input-error :messages="$errors->get('about')" class="mt-1" />
                            </div>
                            
                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-sm font-medium text-zinc-400 mb-2">Logo Brand</label>
                                <div class="relative w-full h-32 border-2 border-zinc-700 border-dashed rounded-xl bg-zinc-800/50 hover:bg-zinc-800 hover:border-indigo-500 transition-all overflow-hidden group">
                                    
                                    <!-- Prompt Stage -->
                                    <div id="upload-prompt" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                        <svg class="w-8 h-8 mb-2 text-zinc-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-sm text-zinc-400 group-hover:text-zinc-200"><span class="font-semibold">Klik untuk upload</span></p>
                                        <p class="text-xs text-zinc-600 mt-1">SVG, PNG, JPG (Maks. 2MB)</p>
                                    </div>

                                    <!-- Preview Stage -->
                                    <img id="logo-preview" style="display: none;" class="absolute inset-0 w-full h-full object-cover" />

                                    <!-- Visual Overlay on Hover (Optional, for edit hint) -->
                                    <div id="edit-overlay" style="display: none;" class="absolute inset-0 bg-black/50 items-center justify-center pointer-events-none">
                                        <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </div>

                                    <!-- Actual Input (Invisible Overlay) -->
                                    <input id="logo" name="logo" type="file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" onchange="previewImage(event)" />
                                </div>
                                <x-input-error :messages="$errors->get('logo')" class="mt-1" />
                            </div>

                            <script>
                                function previewImage(event) {
                                    const input = event.target;
                                    const preview = document.getElementById('logo-preview');
                                    const prompt = document.getElementById('upload-prompt');
                                    
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block'; // Force display
                                            if(prompt) prompt.style.display = 'none'; // Force hide prompt
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            </script>
                        </div>
                    </div>

                    <div class="w-full h-px bg-zinc-800 my-8"></div>

                    <!-- Section 2 -->
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="step-number w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm">2</div>
                            <h3 class="text-xl font-semibold text-white">Lokasi Operasional</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-12">
                            <div class="md:col-span-2 space-y-2">
                                <label for="address" class="block text-sm font-medium text-zinc-400">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="2" required
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all"
                                    placeholder="Jalan, Nomor, RT/RW...">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-1" />
                            </div>

                            <div class="space-y-2">
                                <label for="city" class="block text-sm font-medium text-zinc-400">Kota / Kabupaten</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" required
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all">
                                <x-input-error :messages="$errors->get('city')" class="mt-1" />
                            </div>

                            <div class="space-y-2">
                                <label for="postal_code" class="block text-sm font-medium text-zinc-400">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required
                                    class="input-dark w-full rounded-xl px-4 py-3 placeholder-zinc-600 focus:outline-none transition-all">
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-indigo-900/40 transition-all hover:scale-[1.01] hover:shadow-indigo-900/60 active:scale-[0.99]">
                            Daftarkan Toko Saya
                        </button>
                        <p class="text-center text-zinc-500 text-sm mt-4">
                            Dengan mendaftar, Anda menyetujui <a href="#" class="text-indigo-400 hover:underline">Syarat & Ketentuan</a> Mitra Seller.
                        </p>
                    </div>

                </form>
            </div>
            
            <div class="mt-12">
                <x-footer :simple="true" />
            </div>

        </div>
    </main>

</body>
</html>
