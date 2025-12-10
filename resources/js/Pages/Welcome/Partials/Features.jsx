import React from "react";
import { Truck, Headphones, ShoppingBag, Package } from "lucide-react";

export default function Features() {
    const features = [
        {
            title: "Free Delivery",
            desc: "Free shipping on every order",
            Icon: Truck,
        },
        {
            title: "Customer Support 24/7",
            desc: "Quick access to support services",
            Icon: Headphones,
        },
        {
            title: "100% Secure Payment",
            desc: "Your payment is 100% safe",
            Icon: ShoppingBag,
        },
        {
            title: "Money-Back Guarantee",
            desc: "30-Day Money-Back Guarantee",
            Icon: Package,
        },
    ];

    return (
        <section className="bg-white py-12 border-b border-gray-100">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="bg-white rounded-lg p-8 shadow-lg border border-gray-50">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                        {features.map((item, index) => (
                            <div
                                key={index}
                                className="flex items-center gap-4 px-4 py-2 hover:scale-105 transition duration-300 group"
                            >
                                <div className="p-0">
                                    <item.Icon className="w-8 h-8 text-[#00B207] stroke-[1.5]" />
                                </div>
                                <div>
                                    <h3 className="font-bold text-[#1A1A1A] text-sm font-poppins group-hover:text-[#00B207] transition-colors">
                                        {item.title}
                                    </h3>
                                    <p className="text-gray-400 text-xs mt-1 leading-relaxed">
                                        {item.desc}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
