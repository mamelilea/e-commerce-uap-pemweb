import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link, router } from "@inertiajs/react";
import {
    Package,
    ChevronRight,
    Store,
    Clock,
    Truck,
    Calendar,
} from "lucide-react";

export default function Index({ orders, currentFilter }) {
    const formatRupiah = (num) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(num);
    const formatDate = (date) =>
        new Date(date).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });

    const handleFilter = (filterType) => {
        router.get(
            route("my-order"),
            { filter: filterType },
            { preserveState: true, preserveScroll: true }
        );
    };

    const getStatusBadge = (order) => {
        if (order.payment_status === "done") {
            return (
                <span className="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold flex items-center gap-1">
                    <Package className="w-3 h-3" /> Selesai
                </span>
            );
        }
        if (order.payment_status === "unpaid" && order.address_id !== "cod") {
            return (
                <span className="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold flex items-center gap-1">
                    <Clock className="w-3 h-3" /> Menunggu Konfirmasi
                </span>
            );
        }
        if (order.tracking_number) {
            return (
                <span className="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold flex items-center gap-1">
                    <Truck className="w-3 h-3" /> Dikirim
                </span>
            );
        }
        if (order.payment_status === "paid" || order.address_id === "cod") {
            return (
                <span className="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold flex items-center gap-1">
                    <Package className="w-3 h-3" /> Diproses
                </span>
            );
        }
        return (
            <span className="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">
                Unknown
            </span>
        );
    };

    const tabs = [
        { id: "all", label: "Semua Order" },
        { id: "week", label: "Minggu Ini" },
        { id: "month", label: "Bulan Ini" },
        { id: "year", label: "Tahun Ini" },
    ];

    return (
        <MainLayout title="Pesanan Saya">
            <Head title="Pesanan Saya" />

            <div className="bg-[#F4F6F5] min-h-screen py-10">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                        <h1 className="text-2xl font-bold text-[#1A1A1A] font-poppins flex items-center gap-2">
                            <Package className="w-6 h-6 text-[#00B207]" />
                            Pesanan Saya
                        </h1>

                        <div className="flex bg-white p-1 rounded-lg shadow-sm overflow-x-auto">
                            {tabs.map((tab) => (
                                <button
                                    key={tab.id}
                                    onClick={() => handleFilter(tab.id)}
                                    className={`px-4 py-2 text-xs font-bold rounded-md whitespace-nowrap transition-all ${
                                        currentFilter === tab.id
                                            ? "bg-[#00B207] text-white shadow-md"
                                            : "text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                                    }`}
                                >
                                    {tab.label}
                                </button>
                            ))}
                        </div>
                    </div>

                    {orders.length > 0 ? (
                        <div className="space-y-4">
                            {orders.map((order) => (
                                <Link
                                    key={order.id}
                                    href={route("my-order.detail", order.code)}
                                    className="block bg-white rounded-xl shadow-sm border border-gray-100 hover:border-[#00B207] transition overflow-hidden group"
                                >
                                    <div className="px-6 py-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                                        <div className="flex items-center gap-2 text-sm text-gray-600">
                                            <Store className="w-4 h-4" />
                                            <span className="font-bold">
                                                {order.store.name}
                                            </span>
                                            <span className="text-gray-400">
                                                •
                                            </span>
                                            <span className="flex items-center gap-1">
                                                <Calendar className="w-3 h-3" />{" "}
                                                {formatDate(order.created_at)}
                                            </span>
                                        </div>
                                        {getStatusBadge(order)}
                                    </div>

                                    <div className="p-6 flex items-center gap-4">
                                        <div className="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                            {order.transaction_details[0]
                                                ?.product
                                                ?.product_images?.[0] && (
                                                <img
                                                    src={`/storage/${order.transaction_details[0].product.product_images[0].image}`}
                                                    className="w-full h-full object-cover"
                                                />
                                            )}
                                        </div>
                                        <div className="flex-1">
                                            <h3 className="font-bold text-[#1A1A1A] text-sm md:text-base line-clamp-1">
                                                {
                                                    order.transaction_details[0]
                                                        ?.product?.name
                                                }
                                                {order.transaction_details
                                                    .length > 1 && (
                                                    <span className="text-gray-400 font-normal ml-1">
                                                        +
                                                        {order
                                                            .transaction_details
                                                            .length - 1}{" "}
                                                        lainnya
                                                    </span>
                                                )}
                                            </h3>
                                            <p className="text-xs text-gray-500 mt-1">
                                                Total Belanja
                                            </p>
                                            <p className="font-bold text-[#00B207]">
                                                {formatRupiah(
                                                    order.grand_total
                                                )}
                                            </p>
                                        </div>
                                        <ChevronRight className="w-5 h-5 text-gray-300 group-hover:text-[#00B207] transition" />
                                    </div>
                                </Link>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200">
                            <Package className="w-16 h-16 text-gray-200 mx-auto mb-4" />
                            <h3 className="text-lg font-bold text-gray-900">
                                Tidak Ada Pesanan
                            </h3>
                            <p className="text-gray-500 text-sm mt-1 mb-6">
                                Tidak ada riwayat pesanan pada periode ini.
                            </p>
                            <button
                                onClick={() => handleFilter("all")}
                                className="px-6 py-2 border border-gray-300 rounded-full text-sm font-bold hover:bg-gray-50 transition"
                            >
                                Reset Filter
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </MainLayout>
    );
}
