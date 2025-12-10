import React from "react";
import { Link, usePage } from "@inertiajs/react";
import { Store } from "lucide-react";

export default function BannerBottom() {
    const { auth } = usePage().props;

    let joinUrl = route("join-seller");

    if (auth.user) {
        if (auth.user.role === "seller") joinUrl = route("seller.dashboard");
        if (auth.user.role === "admin") joinUrl = route("admin.dashboard");
    }

    return (
        <section className="py-24 bg-[#F7F7F7]">
            <div className="max-w-5xl mx-auto px-4 text-center">
                <span className="text-[#00B207] font-bold uppercase tracking-wider text-sm mb-6 block">
                    Join with Us
                </span>

                <h2 className="text-3xl md:text-5xl font-bold font-poppins text-[#1A1A1A] mb-6 leading-tight">
                    A healthy life <br />
                    comes from{" "}
                    <span className="text-[#00B207]">good things.</span>
                </h2>

                <p className="font-bold text-lg mb-10 text-gray-600">
                    The best goodness from fruits and nature.
                </p>

                <div className="flex justify-center">
                    <Link
                        href={joinUrl}
                        className="inline-flex items-center gap-3 px-10 py-4 bg-[#1A1A1A] text-white rounded-full font-bold text-lg hover:bg-[#00B207] hover:-translate-y-1 transition-all duration-300 shadow-xl hover:shadow-green-200"
                    >
                        <Store className="w-5 h-5" />
                        {auth.user && auth.user.role === "seller"
                            ? "Go to Dashboard"
                            : "Join with us as a seller"}
                    </Link>
                </div>
            </div>
        </section>
    );
}
