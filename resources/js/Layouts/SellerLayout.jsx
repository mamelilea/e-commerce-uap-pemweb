import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import {
    LayoutDashboard,
    Package,
    ShoppingBag,
    Store,
    Wallet,
    LogOut,
    Menu,
    X,
    ChevronDown,
} from "lucide-react";

export default function SellerLayout({ children, title }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const navigation = [
        {
            name: "Dashboard",
            href: route("seller.dashboard"),
            routeName: "seller.dashboard",
            icon: LayoutDashboard,
        },
        {
            name: "Produk Saya",
            href: route("seller.products.index"),
            routeName: "seller.products",
            icon: Package,
        },
        {
            name: "Pesanan",
            href: route("seller.orders.index"),
            routeName: "seller.orders",
            icon: ShoppingBag,
        },
        {
            name: "Profil Toko",
            href: route("seller.store"),
            routeName: "seller.store",
            icon: Store,
        },
        {
            name: "Keuangan",
            href: route("seller.balance"),
            routeName: "seller.balance",
            icon: Wallet,
        },
    ];

    const getInitials = (name) => (name ? name.charAt(0).toUpperCase() : "S");

    return (
        <div className="min-h-screen bg-[#F8F9FA] font-sans flex text-[#1A1A1A]">
            <aside
                className={`fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 transition-transform duration-300 transform ${
                    sidebarOpen ? "translate-x-0" : "-translate-x-full"
                } lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-sm`}
            >
                <div className="flex items-center justify-center h-20 border-b border-gray-50">
                    <Link
                        href="/"
                        className="font-poppins text-2xl font-bold tracking-wide flex items-center gap-2"
                    >
                        <span className="text-[#1A1A1A]">
                            Fresh<span className="text-[#00B207]">Mart</span>
                        </span>
                        <span className="text-[10px] uppercase bg-green-100 text-green-700 px-2 py-0.5 rounded-full tracking-wider font-bold">
                            Seller
                        </span>
                    </Link>
                </div>

                <nav className="flex-1 mt-6 px-4 space-y-2 overflow-y-auto">
                    {navigation.map((item) => {
                        const isActive = route().current(item.routeName + "*");

                        return (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={`flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group ${
                                    isActive
                                        ? "bg-[#00B207] text-white font-semibold shadow-md shadow-green-200"
                                        : "text-gray-500 hover:bg-green-50 hover:text-green-700"
                                }`}
                            >
                                <item.icon
                                    className={`w-5 h-5 ${
                                        isActive
                                            ? "text-white"
                                            : "text-gray-400 group-hover:text-green-600"
                                    }`}
                                />
                                <span className="text-sm">{item.name}</span>
                            </Link>
                        );
                    })}
                </nav>

                <div className="p-4 border-t border-gray-50">
                    <div className="flex items-center gap-3 p-3 rounded-xl bg-gray-50 mb-2">
                        <div className="w-9 h-9 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm">
                            {getInitials(auth.user.name)}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-bold text-gray-800 truncate">
                                {auth.user.name}
                            </p>
                            <p className="text-xs text-gray-500 truncate">
                                Seller Account
                            </p>
                        </div>
                    </div>
                    <Link
                        href={route("logout")}
                        method="post"
                        as="button"
                        className="flex items-center justify-center gap-2 w-full py-2 text-red-500 hover:bg-red-50 rounded-lg transition text-xs font-bold uppercase tracking-wider"
                    >
                        <LogOut className="w-4 h-4" />
                        Keluar
                    </Link>
                </div>
            </aside>

            <div className="flex-1 flex flex-col min-w-0 overflow-hidden h-screen">
                <header className="lg:hidden bg-white shadow-sm h-16 flex items-center px-4 justify-between z-40">
                    <span className="font-bold text-lg text-green-700">
                        Seller Center
                    </span>
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        className="p-2 text-gray-600 hover:bg-gray-100 rounded-md"
                    >
                        {sidebarOpen ? <X /> : <Menu />}
                    </button>
                </header>

                <main className="flex-1 overflow-y-auto p-6 lg:p-8">
                    <div className="max-w-7xl mx-auto">
                        <div className="mb-6">
                            <h1 className="text-2xl font-bold font-poppins text-[#1A1A1A]">
                                {title}
                            </h1>
                        </div>
                        {children}
                    </div>
                </main>
            </div>

            {sidebarOpen && (
                <div
                    className="fixed inset-0 bg-black/20 z-40 lg:hidden backdrop-blur-sm"
                    onClick={() => setSidebarOpen(false)}
                ></div>
            )}
        </div>
    );
}
