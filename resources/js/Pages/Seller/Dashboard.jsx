import React from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, Link } from "@inertiajs/react";
import { Package, ShoppingBag, DollarSign, AlertTriangle } from "lucide-react";
import SalesChart from "./SalesChart";

export default function Dashboard({ store, stats, chartData, currentFilter }) {
    if (!store) {
        return (
            <SellerLayout title="Dashboard Seller">
                <Head title="Seller Dashboard" />
                <div className="bg-white rounded-xl p-8 text-center shadow-sm border border-gray-100">
                    <div className="mx-auto w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-4">
                        <AlertTriangle className="w-8 h-8" />
                    </div>
                    <h2 className="text-xl font-bold text-gray-900 mb-2">
                        Toko Belum Dibuat
                    </h2>
                    <p className="text-gray-500 mb-6 max-w-md mx-auto">
                        Halo! Anda sudah terdaftar sebagai Seller, tapi belum
                        memiliki profil toko. Silakan lengkapi data toko Anda
                        agar bisa mulai berjualan.
                    </p>
                    <Link
                        href={route("seller.store")}
                        className="px-6 py-3 bg-[#00B207] text-white rounded-full font-bold hover:bg-green-700 transition"
                    >
                        Buat Toko Sekarang
                    </Link>
                </div>
            </SellerLayout>
        );
    }

    return (
        <SellerLayout title="Dashboard Seller">
            <Head title="Seller Dashboard" />

            {!store.is_verified && (
                <div className="bg-orange-50 border-l-4 border-orange-500 p-4 mb-8 rounded-r-lg">
                    <div className="flex">
                        <div className="flex-shrink-0">
                            <AlertTriangle className="h-5 w-5 text-orange-500" />
                        </div>
                        <div className="ml-3">
                            <p className="text-sm text-orange-700">
                                <span className="font-bold">
                                    Menunggu Verifikasi:
                                </span>{" "}
                                Toko Anda sedang ditinjau oleh Admin. Anda bisa
                                upload produk, tapi produk belum akan muncul di
                                pencarian pembeli sampai diverifikasi.
                            </p>
                        </div>
                    </div>
                </div>
            )}

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div className="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        <Package className="w-6 h-6" />
                    </div>
                    <div>
                        <p className="text-sm text-gray-500">Total Produk</p>
                        <h3 className="text-2xl font-bold text-gray-900">
                            {stats?.total_products || 0}
                        </h3>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div className="p-3 bg-orange-100 text-orange-600 rounded-lg">
                        <ShoppingBag className="w-6 h-6" />
                    </div>
                    <div>
                        <p className="text-sm text-gray-500">Pesanan Baru</p>
                        <h3 className="text-2xl font-bold text-gray-900">
                            {stats?.pending_orders || 0}
                        </h3>
                    </div>
                </div>
                <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div className="p-3 bg-green-100 text-green-600 rounded-lg">
                        <DollarSign className="w-6 h-6" />
                    </div>
                    <div>
                        <p className="text-sm text-gray-500">Total Penjualan</p>
                        <h3 className="text-2xl font-bold text-gray-900">
                            Rp {stats?.total_sales || 0}
                        </h3>
                    </div>
                </div>
            </div>

            {store.is_verified ? (
                <SalesChart data={chartData} currentFilter={currentFilter} />
            ) : (
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
                    <p>
                        Grafik penjualan akan aktif setelah toko diverifikasi.
                    </p>
                </div>
            )}
        </SellerLayout>
    );
}
