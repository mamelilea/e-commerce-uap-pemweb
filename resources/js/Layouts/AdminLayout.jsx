import React from "react";
import { Link, usePage } from "@inertiajs/react";
import {
    LayoutDashboard,
    Store,
    Users,
    CreditCard,
    LogOut,
    CheckCircle,
} from "lucide-react";

export default function AdminLayout({ children, title }) {
    const { auth } = usePage().props;
    const user = auth.user;

    const isUrl = (...urls) => {
        let currentUrl = window.location.pathname.substr(1);
        if (urls[0] === "") {
            return currentUrl === "";
        }
        return urls.filter((url) => currentUrl.startsWith(url)).length;
    };

    const sidebarMenu = [
        {
            label: "Dashboard",
            href: route("admin.dashboard"),
            icon: <LayoutDashboard size={20} />,
            active: "admin/dashboard",
        },
        {
            label: "Verifikasi Pembayaran",
            href: route("admin.transactions"),
            icon: <CheckCircle size={20} />,
            active: "admin/transactions",
        },
        {
            label: "Verifikasi Toko",
            href: route("admin.stores"),
            icon: <Store size={20} />,
            active: "admin/stores",
        },
        {
            label: "Penarikan Saldo",
            href: route("admin.withdrawals"),
            icon: <CreditCard size={20} />,
            active: "admin/withdrawals",
        },
        {
            label: "Kelola Pengguna",
            href: route("admin.users"),
            icon: <Users size={20} />,
            active: "admin/users",
        },
    ];

    return (
        <div className="flex h-screen bg-[#F4F6F5]">
            <aside className="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full z-10">
                <div className="h-16 flex items-center px-8 border-b border-gray-100">
                    <Link
                        href="/"
                        className="font-poppins text-2xl font-bold tracking-wide"
                    >
                        <span className="text-[#1A1A1A]">Fresh</span>
                        <span className="text-[#00B207]">Mart</span>
                        <span className="text-[10px] ml-1 bg-[#1A1A1A] text-white px-1.5 py-0.5 rounded">
                            ADMIN
                        </span>
                    </Link>
                </div>

                <div className="flex-1 py-6 px-4 space-y-2 overflow-y-auto">
                    {sidebarMenu.map((menu, index) => (
                        <Link
                            key={index}
                            href={menu.href}
                            className={`flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm ${
                                isUrl(menu.active)
                                    ? "bg-[#00B207] text-white shadow-md shadow-green-100"
                                    : "text-gray-500 hover:bg-gray-50 hover:text-[#00B207]"
                            }`}
                        >
                            {menu.icon}
                            {menu.label}
                        </Link>
                    ))}
                </div>

                <div className="p-4 border-t border-gray-100">
                    <div className="bg-[#1A1A1A] rounded-xl p-4 mb-2">
                        <div className="flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                {user.name.charAt(0)}
                            </div>
                            <div className="overflow-hidden">
                                <h4 className="text-white text-sm font-bold truncate">
                                    {user.name}
                                </h4>
                                <p className="text-gray-400 text-xs truncate">
                                    {user.email}
                                </p>
                            </div>
                        </div>
                    </div>
                    <Link
                        href={route("logout")}
                        method="post"
                        as="button"
                        className="flex w-full items-center gap-2 justify-center px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition"
                    >
                        <LogOut size={16} /> Sign Out
                    </Link>
                </div>
            </aside>

            <main className="flex-1 ml-64 p-8 overflow-y-auto">
                <div className="max-w-7xl mx-auto">
                    {title && (
                        <h1 className="text-2xl font-bold text-[#1A1A1A] mb-6 font-poppins">
                            {title}
                        </h1>
                    )}
                    {children}
                </div>
            </main>
        </div>
    );
}
