import React from "react";
import { Link } from "@inertiajs/react";
import { ArrowRight } from "lucide-react";

export default function Hero() {
    return (
        <section className="relative bg-[#002603] overflow-hidden">
            <div className="absolute inset-0 opacity-70">
                <img
                    src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/a7/79/7b/a-wide-area-with-fresh.jpg?w=900&h=500&s=1"
                    alt="Hero Image"
                    className="w-full h-full object-cover"
                />
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-center min-h-[600px] py-12">
                    <div className="space-y-8 animate-fade-in-up">
                        <span className="text-[#00B207] font-bold tracking-wider uppercase text-sm">
                            Welcome to FreshMart
                        </span>

                        <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                            Fresh & <br />
                            Healthy <br />
                            Organic Food
                        </h1>

                        <div className="space-y-2">
                            <h3 className="text-2xl text-white font-medium">
                                Sale up to{" "}
                                <span className="text-[#FF8A00] font-bold">
                                    30% OFF
                                </span>
                            </h3>
                            <p className="text-gray-400 text-sm max-w-md leading-relaxed">
                                Free shipping on all your order. we deliver, you
                                enjoy
                            </p>
                        </div>

                        <Link
                            href={route("products.list")}
                            className="inline-flex items-center gap-2 px-8 py-4 bg-[#00B207] hover:bg-green-600 text-white rounded-full font-bold transition-all transform hover:scale-105 shadow-lg shadow-green-900/50"
                        >
                            Shop now <ArrowRight className="w-5 h-5" />
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    );
}
