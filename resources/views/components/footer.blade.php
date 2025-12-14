@props(['simple' => false])

@if($simple)
<footer class="border-t border-white/10 bg-[#0a0a0a] py-6 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center bg-[#0a0a0a]">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} Y2K Accessories. All rights reserved. Made by Kelompok 10.
        </p>
    </div>
</footer>
@else
<footer class="border-t border-white/10 bg-[#0a0a0a] pt-12 pb-8 mt-auto relative font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Brand & About -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-white text-black font-black text-sm grid place-items-center tracking-tighter">
                        Y2K
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">Y2K Accessories</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Menyediakan aksesoris Y2K estetik berkualitas tinggi untuk menunjang gaya unikmu. Tampil beda, tampil berani.
                </p>
                <div class="flex gap-4 pt-2">
                    <!-- Instagram -->
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.407-.06 4.123-.06h.08v.001zm6.597 3.807c1-.048 1.06-.05 1.148-.05.535 0 .937.166 1.25.479.312.312.48.718.48 1.253 0 .536-.168.94-.483 1.254-.313.313-.718.48-1.25.48-.532 0-.938-.167-1.25-.48-.314-.313-.48-.718-.48-1.25s.166-.941.48-1.25c.312-.312.715-.479 1.25-.479h.001l-.145-.008zm-6.597 1.839a6.666 6.666 0 100 13.332 6.666 6.666 0 000-13.332z m0 2.16a4.506 4.506 0 110 9.012 4.506 4.506 0 010-9.012z" clip-rule="evenodd" /></svg>
                    </a>
                    
                    <!-- X (Twitter) -->
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">X</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>

                    <!-- Facebook -->
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>

            <!-- Links Sections -->
            <div>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Belanja</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Semua Produk</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Terlaris</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Koleksi Baru</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Diskon</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Bantuan</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Cara Pesan</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Pengiriman</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Newsletter</h3>
                <p class="text-sm text-gray-400 mb-4">Dapatkan info promo dan produk terbaru.</p>
                <form class="space-y-2">
                    <input type="email" placeholder="Alamat Email Anda" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white text-sm focus:outline-none focus:border-white/30 focus:ring-1 focus:ring-white/30 transition-all">
                    <button type="button" class="w-full bg-white text-black font-bold text-sm py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-600">
                &copy; {{ date('Y') }} Y2K Accessories. All rights reserved. Made by Kelompok 10.
            </p>

            <!-- Scroll to Top Button -->
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="group flex items-center gap-2 text-xs font-bold text-white hover:text-gray-300 transition-colors px-4 py-2 rounded-full border border-white/10 hover:bg-white/5">
                <span>KEMBALI KE ATAS</span>
                <svg class="w-4 h-4 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            </button>
        </div>
    </div>
</footer>
@endif
