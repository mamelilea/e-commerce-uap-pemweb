import { Link } from "@inertiajs/react";
import {
    Facebook,
    Instagram,
    Twitter,
    MapPin,
    Phone,
    Mail,
} from "lucide-react";

export default function Footer() {
    return (
        <footer className="bg-black pt-16 pb-8 font-sans border-t border-[#2C5E31]">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                    <div className="space-y-6">
                        <Link
                            href="/"
                            className="font-poppins text-3xl font-bold tracking-wide block"
                        >
                            <span className="text-white">Fresh</span>
                            <span className="text-[#93FF00]">Mart</span>
                        </Link>
                        <p className="text-gray-300 text-sm leading-relaxed">
                            Platform belanja sayur dan buah segar langsung dari
                            petani lokal dengan kualitas terbaik untuk keluarga
                            Anda.
                        </p>
                        <div className="flex gap-4">
                            {[Facebook, Twitter, Instagram].map(
                                (Icon, index) => (
                                    <a
                                        key={index}
                                        href="#"
                                        className="w-10 h-10 rounded-full bg-[#2C5E31] flex items-center justify-center text-white hover:bg-[#93FF00] hover:text-[#173B1A] transition-all duration-300"
                                    >
                                        <Icon className="w-5 h-5" />
                                    </a>
                                )
                            )}
                        </div>
                    </div>

                    <div>
                        <h4 className="text-white font-bold text-lg mb-6 font-poppins">
                            Menu Utama
                        </h4>
                        <ul className="space-y-4 text-sm text-gray-300">
                            <li>
                                <Link
                                    href="/"
                                    className="hover:text-[#93FF00] transition-colors flex items-center gap-2"
                                >
                                    Beranda
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href={route("products.list")}
                                    className="hover:text-[#93FF00] transition-colors flex items-center gap-2"
                                >
                                    Semua Produk
                                </Link>
                            </li>
                            <li>
                                <a
                                    href="/#about"
                                    className="hover:text-[#93FF00] transition-colors flex items-center gap-2"
                                >
                                    Tentang Kami
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 className="text-white font-bold text-lg mb-6 font-poppins">
                            Akun Saya
                        </h4>
                        <ul className="space-y-4 text-sm text-gray-300">
                            <li>
                                <Link
                                    href={route("profile.edit")}
                                    className="hover:text-[#93FF00] transition-colors"
                                >
                                    Pengaturan Profil
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href={route("my-order")}
                                    className="hover:text-[#93FF00] transition-colors"
                                >
                                    Riwayat Pesanan
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href={route("cart.index")}
                                    className="hover:text-[#93FF00] transition-colors"
                                >
                                    Keranjang Belanja
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 className="text-white font-bold text-lg mb-6 font-poppins">
                            Hubungi Kami
                        </h4>
                        <ul className="space-y-4 text-sm text-gray-300">
                            <li className="flex items-start gap-3">
                                <MapPin className="w-5 h-5 text-[#93FF00] flex-shrink-0" />
                                <span>
                                    Jl. Organik Raya No. 123, Jakarta Selatan,
                                    Indonesia
                                </span>
                            </li>
                            <li className="flex items-center gap-3">
                                <Mail className="w-5 h-5 text-[#93FF00] flex-shrink-0" />
                                <a
                                    href="mailto:hello@freshmart.com"
                                    className="hover:text-white"
                                >
                                    hello@freshmart.com
                                </a>
                            </li>
                            <li className="flex items-center gap-3">
                                <Phone className="w-5 h-5 text-[#93FF00] flex-shrink-0" />
                                <span>+62 812-3456-7890</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div className="border-t border-[#2C5E31] pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p className="text-gray-400 text-sm">
                        &copy; {new Date().getFullYear()} FreshMart. All Rights
                        Reserved.
                    </p>
                    <div className="flex gap-6 text-sm text-gray-400">
                        <a
                            href="#"
                            className="hover:text-[#93FF00] transition-colors"
                        >
                            Privacy Policy
                        </a>
                        <a
                            href="#"
                            className="hover:text-[#93FF00] transition-colors"
                        >
                            Terms of Service
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
