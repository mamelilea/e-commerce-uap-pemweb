import React from "react";
import { Leaf, Truck, ShieldCheck, ArrowRight } from "lucide-react";
import { Link } from "@inertiajs/react";

export default function AboutSection() {
    return (
        <section
            id="about"
            className="py-24 bg-[#F9FBF9] relative overflow-hidden"
        >
            <div className="absolute top-0 left-0 w-64 h-64 bg-[#93FF00] rounded-full mix-blend-multiply filter blur-3xl opacity-10 -translate-x-1/2 -translate-y-1/2"></div>
            <div className="absolute bottom-0 right-0 w-96 h-96 bg-[#173B1A] rounded-full mix-blend-multiply filter blur-3xl opacity-5 translate-x-1/3 translate-y-1/3"></div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div className="relative">
                        <div className="relative rounded-3xl overflow-hidden shadow-2xl border-[8px] border-white transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                            <img
                                src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop"
                                alt="Fresh Vegetables Market"
                                className="w-full h-[500px] object-cover"
                            />

                            <div className="absolute inset-0 bg-gradient-to-t from-[#173B1A]/60 to-transparent"></div>

                            <div className="absolute bottom-8 left-8 text-white">
                                <p className="font-bold text-2xl">
                                    100% Organic
                                </p>
                                <p className="text-gray-200">
                                    Certified Local Farmers
                                </p>
                            </div>
                        </div>

                        <div className="absolute -bottom-6 -right-6 md:right-8 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 hidden md:block animate-bounce-slow">
                            <div className="flex items-center gap-4">
                                <div className="bg-[#e9ffcc] p-3 rounded-full">
                                    <Leaf className="w-8 h-8 text-[#173B1A]" />
                                </div>
                                <div>
                                    <p className="text-xs text-gray-500 font-bold uppercase tracking-wider">
                                        Quality
                                    </p>
                                    <p className="text-xl font-bold text-[#173B1A]">
                                        Premium Pick
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="space-y-8">
                        <div>
                            <span className="inline-block py-2 px-4 rounded-full bg-[#173B1A]/10 text-[#173B1A] text-sm font-bold tracking-wide uppercase mb-4">
                                🌱 Tentang FreshMart
                            </span>
                            <h2 className="text-4xl md:text-5xl font-bold text-[#173B1A] leading-tight font-poppins">
                                Menghubungkan Anda dengan{" "}
                                <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#173B1A] to-[#4a8a2a]">
                                    Alam Terbaik.
                                </span>
                            </h2>
                        </div>

                        <p className="text-lg text-gray-600 leading-relaxed">
                            FreshMart hadir dengan misi sederhana: memotong
                            rantai distribusi yang panjang agar Anda bisa
                            menikmati hasil panen yang benar-benar segar. Kami
                            bekerja sama langsung dengan petani lokal untuk
                            memastikan setiap sayur dan buah yang sampai di meja
                            Anda masih memiliki nutrisi terbaiknya.
                        </p>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {[
                                {
                                    icon: ShieldCheck,
                                    title: "Quality Control",
                                    desc: "Sortir ketat 3 tahap",
                                },
                                {
                                    icon: Truck,
                                    title: "Express Delivery",
                                    desc: "Panen pagi, kirim sore",
                                },
                            ].map((item, index) => (
                                <div
                                    key={index}
                                    className="flex items-start gap-4 p-4 rounded-xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow"
                                >
                                    <div className="bg-[#93FF00]/20 p-2 rounded-lg">
                                        <item.icon className="w-6 h-6 text-[#173B1A]" />
                                    </div>
                                    <div>
                                        <h4 className="font-bold text-[#173B1A]">
                                            {item.title}
                                        </h4>
                                        <p className="text-sm text-gray-500">
                                            {item.desc}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <div className="pt-4">
                            <Link
                                href={route("products.list")}
                                className="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-[#173B1A] transition-all duration-200 bg-[#93FF00] border border-transparent rounded-full hover:bg-[#173B1A] hover:text-[#93FF00] shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                            >
                                Belanja Sekarang{" "}
                                <ArrowRight className="ml-2 w-5 h-5" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
