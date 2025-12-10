import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";
import { Menu, X, ChevronDown, User, LogOut } from "lucide-react";

export default function Navbar() {
    const { auth } = usePage().props;
    const user = auth.user;
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [isMobileCategoryOpen, setIsMobileCategoryOpen] = useState(false);
    const [isProfileDropdownOpen, setIsProfileDropdownOpen] = useState(false);

    const categories = [
        { name: "All Category", slug: "/" },
        { name: "Fresh Fruit", slug: "fresh-fruit" },
        { name: "Vegetables", slug: "vegetables" },
        { name: "Fresh Meat", slug: "fresh-meat" },
        { name: "Healthy Drink", slug: "health-drink" },
    ];

    const menus = {
        guest: [
            { label: "HOME", href: "/", type: "link" },
            { label: "ABOUT US", href: "/#about", type: "scroll" },
            { label: "CATEGORY", type: "dropdown" },
        ],
        member: [
            { label: "HOME", href: "/", type: "link" },
            { label: "ABOUT US", href: "/#about", type: "scroll" },
            { label: "CATEGORY", type: "dropdown" },
            {
                label: "MY ORDER",
                href: route("my-order"),
                type: "page",
                active: "my-order",
            },
        ],
        seller: [
            {
                label: "DASHBOARD",
                href: route("seller.dashboard"),
                type: "page",
                active: "seller.dashboard",
            },
            {
                label: "PRODUK",
                href: route("seller.products.index"),
                type: "page",
                active: "seller.products",
            },
            {
                label: "PESANAN",
                href: route("seller.orders.index"),
                type: "page",
                active: "seller.orders",
            },
            {
                label: "TOKO",
                href: route("seller.store"),
                type: "page",
                active: "seller.store",
            },
        ],
        admin: [
            {
                label: "DASHBOARD",
                href: route("admin.dashboard"),
                type: "page",
                active: "admin.dashboard",
            },
            {
                label: "TRANSAKSI",
                href: route("admin.transactions"),
                type: "page",
                active: "admin.transactions",
            },
            {
                label: "VERIFIKASI",
                href: route("admin.stores"),
                type: "page",
                active: "admin.stores",
            },
            {
                label: "PENGGUNA",
                href: route("admin.users"),
                type: "page",
                active: "admin.users",
            },
        ],
    };

    let currentMenus = menus["guest"];

    if (user) {
        let roleKey = user.role;

        if (roleKey === "seller" && !user.store_verified) {
            roleKey = "member";
        }
        if (roleKey === "user") {
            roleKey = "member";
        }

        if (menus[roleKey]) {
            currentMenus = menus[roleKey];
        }
    }

    return (
        <nav className="bg-[#173B1A] sticky top-0 z-50 shadow-md font-sans border-b border-[#2C5E31]">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-20 items-center">
                    <div className="flex-shrink-0 flex items-center">
                        <Link
                            href="/"
                            className="font-poppins text-3xl font-bold tracking-wide"
                        >
                            <span className="text-white">Fresh</span>
                            <span className="text-[#93FF00]">Mart</span>
                        </Link>
                    </div>

                    <div className="hidden md:flex items-center gap-8">
                        <div className="flex space-x-8">
                            {currentMenus.map((item, index) => {
                                if (item.type === "dropdown") {
                                    return (
                                        <div
                                            key={index}
                                            className="relative group h-full flex items-center"
                                        >
                                            <button className="text-white group-hover:text-[#93FF00] px-1 pt-1 text-sm font-medium tracking-wider transition-colors duration-200 uppercase flex items-center gap-1 focus:outline-none">
                                                {item.label}
                                                <ChevronDown className="w-4 h-4 transition-transform group-hover:rotate-180" />
                                            </button>

                                            <div className="absolute top-[30px] left-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                                                <div className="py-2">
                                                    {categories.map((cat) => (
                                                        <Link
                                                            key={cat.slug}
                                                            href={route(
                                                                "products.list",
                                                                {
                                                                    category:
                                                                        cat.slug,
                                                                }
                                                            )}
                                                            className="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-[#173B1A] transition-colors"
                                                        >
                                                            {cat.name}
                                                        </Link>
                                                    ))}
                                                </div>
                                            </div>
                                        </div>
                                    );
                                }

                                const isActive =
                                    item.type === "page" &&
                                    item.active &&
                                    route().current(item.active + "*");
                                return (
                                    <div
                                        key={index}
                                        className="relative group h-full flex items-center"
                                    >
                                        {item.type === "scroll" ? (
                                            <a
                                                href={item.href}
                                                className="text-white hover:text-[#93FF00] px-1 pt-1 text-sm font-medium tracking-wider transition-colors duration-200 uppercase"
                                            >
                                                {item.label}
                                            </a>
                                        ) : (
                                            <Link
                                                href={item.href}
                                                className={`${
                                                    isActive
                                                        ? "text-[#93FF00]"
                                                        : "text-white"
                                                } hover:text-[#93FF00] px-1 pt-1 text-sm font-medium tracking-wider transition-colors duration-200 uppercase`}
                                            >
                                                {item.label}
                                            </Link>
                                        )}
                                        <span
                                            className={`absolute -bottom-2 left-0 w-full h-0.5 bg-[#93FF00] transform transition-transform duration-300 origin-center ${
                                                isActive
                                                    ? "scale-x-100"
                                                    : "scale-x-0 group-hover:scale-x-100"
                                            }`}
                                        ></span>
                                    </div>
                                );
                            })}
                        </div>

                        <div className="flex items-center">
                            {user ? (
                                <div className="flex items-center ml-2 gap-4 pl-6 border-l border-white/10">
                                    <div className="relative">
                                        <button
                                            onClick={() =>
                                                setIsProfileDropdownOpen(
                                                    !isProfileDropdownOpen
                                                )
                                            }
                                            className="flex items-center gap-3 focus:outline-none group"
                                        >
                                            <div className="h-10 w-10 rounded-full bg-[#3E2723] border-2 border-white flex items-center justify-center text-white font-bold font-poppins shadow-md group-hover:border-[#93FF00] transition-colors">
                                                {user.name
                                                    .charAt(0)
                                                    .toUpperCase()}
                                            </div>
                                            <div className="hidden lg:flex flex-col items-start leading-tight">
                                                <span className="text-white font-bold text-sm truncate max-w-[150px] group-hover:text-[#93FF00] transition-colors">
                                                    {user.name}
                                                </span>
                                                <span className="text-[10px] text-gray-400 uppercase tracking-wider">
                                                    {user.role}
                                                </span>
                                            </div>
                                            <ChevronDown
                                                className={`w-4 h-4 text-white transition-transform ${
                                                    isProfileDropdownOpen
                                                        ? "rotate-180"
                                                        : ""
                                                }`}
                                            />
                                        </button>

                                        {isProfileDropdownOpen && (
                                            <div className="absolute right-0 top-full mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden py-1 z-50 transform origin-top-right transition-all">
                                                <div className="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                                    <p className="text-sm font-bold text-[#173B1A] truncate">
                                                        {user.name}
                                                    </p>
                                                    <p className="text-xs text-gray-500 truncate">
                                                        {user.email}
                                                    </p>
                                                </div>

                                                <Link
                                                    href={route("profile.edit")}
                                                    className="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-[#173B1A] transition-colors"
                                                >
                                                    <User className="w-4 h-4" />
                                                    Edit Profile
                                                </Link>

                                                <Link
                                                    href={route("logout")}
                                                    method="post"
                                                    as="button"
                                                    className="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left"
                                                >
                                                    <LogOut className="w-4 h-4" />
                                                    Sign Out
                                                </Link>
                                            </div>
                                        )}
                                    </div>

                                    {auth.cart_count > 0 && (
                                        <Link
                                            href={route("cart.index")}
                                            className="relative ml-2 text-white hover:text-[#93FF00] transition"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                className="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                                />
                                            </svg>
                                            <span className="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full font-bold">
                                                {auth.cart_count}
                                            </span>
                                        </Link>
                                    )}
                                </div>
                            ) : (
                                <div className="flex items-center gap-4 ml-4">
                                    <Link
                                        href={route("login")}
                                        className="text-white hover:text-[#93FF00] font-medium text-sm transition-colors uppercase tracking-wide"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route("register")}
                                        className="bg-[#93FF00] text-[#173B1A] px-6 py-2 rounded-full font-bold text-sm hover:bg-white transition transform hover:-translate-y-0.5 shadow-lg"
                                    >
                                        Register
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="-mr-2 flex items-center md:hidden">
                        <button
                            onClick={() =>
                                setIsMobileMenuOpen(!isMobileMenuOpen)
                            }
                            className="text-white hover:text-[#93FF00] focus:outline-none p-2"
                        >
                            {isMobileMenuOpen ? (
                                <X className="w-6 h-6" />
                            ) : (
                                <Menu className="w-6 h-6" />
                            )}
                        </button>
                    </div>
                </div>
            </div>

            {isMobileMenuOpen && (
                <div className="md:hidden bg-[#1A1A1A] border-t border-[#2C5E31] py-4">
                    <div className="space-y-1 px-4">
                        {currentMenus.map((item, index) => {
                            if (item.type === "dropdown") {
                                return (
                                    <div
                                        key={index}
                                        className="border-b border-white/5"
                                    >
                                        <button
                                            onClick={() =>
                                                setIsMobileCategoryOpen(
                                                    !isMobileCategoryOpen
                                                )
                                            }
                                            className="w-full flex justify-between items-center text-white hover:text-[#93FF00] py-3 font-medium uppercase text-sm"
                                        >
                                            {item.label}
                                            <ChevronDown
                                                className={`w-4 h-4 transition-transform ${
                                                    isMobileCategoryOpen
                                                        ? "rotate-180"
                                                        : ""
                                                }`}
                                            />
                                        </button>
                                        {isMobileCategoryOpen && (
                                            <div className="pl-4 pb-2 space-y-1 bg-[#173B1A]/30 rounded-lg mb-2">
                                                {categories.map((cat) => (
                                                    <Link
                                                        key={cat.slug}
                                                        href={route(
                                                            "products.list",
                                                            {
                                                                category:
                                                                    cat.slug,
                                                            }
                                                        )}
                                                        className="block text-gray-300 hover:text-[#93FF00] py-2 text-sm"
                                                    >
                                                        {cat.name}
                                                    </Link>
                                                ))}
                                            </div>
                                        )}
                                    </div>
                                );
                            }

                            return item.type === "scroll" ? (
                                <a
                                    key={index}
                                    href={item.href}
                                    className="block text-white hover:text-[#93FF00] py-3 font-medium uppercase text-sm border-b border-white/5"
                                >
                                    {item.label}
                                </a>
                            ) : (
                                <Link
                                    key={index}
                                    href={item.href}
                                    className="block text-white hover:text-[#93FF00] py-3 font-medium uppercase text-sm border-b border-white/5"
                                >
                                    {item.label}
                                </Link>
                            );
                        })}

                        {!user && (
                            <div className="mt-6 flex flex-col gap-3">
                                <Link
                                    href={route("login")}
                                    className="block text-center text-white border border-white/30 py-3 rounded-lg font-bold hover:bg-white/5"
                                >
                                    Log In
                                </Link>
                                <Link
                                    href={route("register")}
                                    className="block text-center bg-[#93FF00] text-[#173B1A] py-3 rounded-lg font-bold hover:bg-white"
                                >
                                    Register
                                </Link>
                            </div>
                        )}

                        {user && (
                            <div className="mt-6 border-t border-white/10 pt-4">
                                <div className="flex items-center gap-3 mb-4 px-2">
                                    <div className="h-10 w-10 rounded-full bg-[#3E2723] flex items-center justify-center text-white font-bold">
                                        {user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div className="overflow-hidden">
                                        <p className="text-white font-bold truncate">
                                            {user.name}
                                        </p>
                                        <p className="text-xs text-gray-400 truncate">
                                            {user.email}
                                        </p>
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Link
                                        href={route("profile.edit")}
                                        className="flex items-center gap-2 w-full text-left text-white hover:text-[#93FF00] py-2 px-2 text-sm font-medium transition-colors"
                                    >
                                        <User className="w-4 h-4" />
                                        Edit Profile
                                    </Link>

                                    <Link
                                        href={route("logout")}
                                        method="post"
                                        as="button"
                                        className="flex items-center gap-2 w-full text-left text-red-400 hover:text-red-300 py-2 px-2 text-sm font-bold transition-colors"
                                    >
                                        <LogOut className="w-4 h-4" />
                                        Sign Out
                                    </Link>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </nav>
    );
}
