import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import SectionTitle from "../Welcome/Partials/SectionTitle";
import { Head, Link, router } from "@inertiajs/react";
import {
    Search,
    ShoppingBag,
    Store,
    ImageIcon,
    ChevronLeft,
    ChevronRight,
} from "lucide-react";

export default function Index({ products, categoryName, filters }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || "");

    const handleSearch = (e) => {
        if (e.key === "Enter") {
            router.get(
                route("products.list"),
                {
                    category: filters.category,
                    search: searchTerm,
                },
                { preserveState: true }
            );
        }
    };

    const handleSearchClick = () => {
        router.get(
            route("products.list"),
            {
                category: filters.category,
                search: searchTerm,
            },
            { preserveState: true }
        );
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(number);
    };

    return (
        <MainLayout title={categoryName}>
            <Head title={categoryName} />

            <div className="bg-white py-4 border-b border-gray-100 mb-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-sm text-gray-500 flex items-center gap-2">
                        <Link
                            href="/"
                            className="hover:text-[#00B207] transition-colors"
                        >
                            Home
                        </Link>
                        <span className="text-gray-300">/</span>
                        <span className="text-[#00B207] font-medium">
                            {categoryName}
                        </span>
                    </div>
                </div>
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
                <div className="text-center mb-10">
                    <SectionTitle title={categoryName} />
                </div>

                <div className="flex justify-center mb-12">
                    <div className="relative w-full max-w-xl group">
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            onKeyDown={handleSearch}
                            className="w-full pl-6 pr-32 py-3.5 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-[#00B207] focus:ring-1 focus:ring-[#00B207] transition-all text-sm placeholder-gray-400 text-gray-700 shadow-sm group-hover:bg-white"
                            placeholder="Search products..."
                        />
                        <button
                            onClick={handleSearchClick}
                            className="absolute right-1.5 top-1.5 bottom-1.5 px-8 bg-[#00B207] text-white rounded-full font-bold text-xs tracking-wider hover:bg-green-700 transition shadow-md"
                        >
                            SEARCH
                        </button>
                    </div>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    {products.data.length > 0 ? (
                        products.data.map((item) => {
                            const rating = Math.round(
                                item.product_reviews_avg_rating || 0
                            );
                            const reviewCount = item.product_reviews_count || 0;

                            return (
                                <div
                                    key={item.id}
                                    className="group bg-white border border-gray-100 rounded-2xl p-4 hover:border-[#00B207] hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 relative flex flex-col h-full"
                                >
                                    <Link
                                        href={route(
                                            "product.detail",
                                            item.slug
                                        )}
                                        className="block"
                                    >
                                        <div className="aspect-square bg-gray-50 rounded-xl mb-4 flex items-center justify-center relative overflow-hidden group-hover:bg-white transition-colors">
                                            {item.product_images &&
                                            item.product_images.length > 0 ? (
                                                <img
                                                    src={`/storage/${item.product_images[0].image}`}
                                                    alt={item.name}
                                                    className="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-500 ease-out"
                                                />
                                            ) : (
                                                <ImageIcon className="w-12 h-12 text-gray-300" />
                                            )}

                                            {item.condition === "new" && (
                                                <div className="absolute top-3 right-3 bg-green-500/10 text-green-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-green-100">
                                                    New
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex-grow flex flex-col">
                                            <h3 className="text-[#1A1A1A] font-medium group-hover:text-[#00B207] transition-colors cursor-pointer text-sm md:text-base line-clamp-2 mb-2 leading-snug">
                                                {item.name}
                                            </h3>

                                            <div className="mt-auto">
                                                <div className="flex items-center justify-between mb-3">
                                                    <p className="font-bold text-[#1A1A1A] text-lg">
                                                        {formatRupiah(
                                                            item.price
                                                        )}
                                                    </p>
                                                    <div className="flex items-center gap-0.5">
                                                        {[...Array(5)].map(
                                                            (_, i) => (
                                                                <svg
                                                                    key={i}
                                                                    className={`w-3 h-3 ${
                                                                        i <
                                                                        rating
                                                                            ? "text-yellow-400"
                                                                            : "text-gray-300"
                                                                    } fill-current`}
                                                                    viewBox="0 0 20 20"
                                                                >
                                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                                </svg>
                                                            )
                                                        )}
                                                        <span className="text-xs text-gray-400 font-medium ml-1">
                                                            ({reviewCount})
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </Link>

                                    <div className="flex justify-between items-center pt-3 border-t border-gray-50 group-hover:border-gray-100 transition-colors mt-auto">
                                        <div className="flex items-center gap-2 text-gray-400 group-hover:text-gray-600 transition-colors">
                                            <Store className="w-3.5 h-3.5" />
                                            <span className="text-xs font-medium truncate max-w-[100px]">
                                                {item.store?.name || "Shop"}
                                            </span>
                                        </div>

                                        <button className="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-[#1A1A1A] hover:bg-[#00B207] hover:text-white transition-all shadow-sm group-hover:shadow-md active:scale-95">
                                            <ShoppingBag className="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            );
                        })
                    ) : (
                        <div className="col-span-full flex flex-col items-center justify-center py-24 text-center">
                            <div className="bg-gray-50 p-6 rounded-full mb-4">
                                <Search className="w-12 h-12 text-gray-300" />
                            </div>
                            <h3 className="text-lg font-bold text-gray-900">
                                Produk Tidak Ditemukan
                            </h3>
                            <p className="text-gray-500 text-sm mt-1 max-w-md mx-auto">
                                Kami tidak dapat menemukan produk yang cocok
                                dengan pencarian Anda. Coba kata kunci lain atau
                                jelajahi kategori berbeda.
                            </p>
                            <Link
                                href="/"
                                className="mt-6 px-6 py-2.5 bg-[#00B207] text-white rounded-full font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-100"
                            >
                                Kembali ke Beranda
                            </Link>
                        </div>
                    )}
                </div>

                {products.links.length > 3 && (
                    <div className="flex justify-center gap-2">
                        {products.links.map((link, index) => {
                            const isPrev = link.label.includes("Previous");
                            const isNext = link.label.includes("Next");
                            const label = link.label
                                .replace("&laquo;", "")
                                .replace("&raquo;", "");

                            if (!link.url && !link.active) return null;

                            return (
                                <Link
                                    key={index}
                                    href={link.url || "#"}
                                    className={`w-10 h-10 flex items-center justify-center rounded-full transition-all font-bold text-sm ${
                                        link.active
                                            ? "bg-[#00B207] text-white shadow-lg shadow-green-200 scale-105"
                                            : "bg-white border border-gray-100 text-gray-600 hover:border-[#00B207] hover:text-[#00B207]"
                                    } ${
                                        !link.url
                                            ? "opacity-50 cursor-not-allowed hover:border-gray-100 hover:text-gray-600"
                                            : ""
                                    }`}
                                >
                                    {isPrev ? (
                                        <ChevronLeft className="w-4 h-4" />
                                    ) : isNext ? (
                                        <ChevronRight className="w-4 h-4" />
                                    ) : (
                                        label
                                    )}
                                </Link>
                            );
                        })}
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
