import React from "react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Users, Store, AlertCircle, Wallet, Check, X } from "lucide-react";

export default function Dashboard({ stats, pendingStores }) {
    const formatRupiah = (num) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(num);
    const formatDate = (date) =>
        new Date(date).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "short",
            year: "numeric",
        });

    const handleApprove = (id) => {
        if (confirm("Setujui toko ini?"))
            router.patch(route("admin.stores.approve", id));
    };

    const handleReject = (id) => {
        if (confirm("Tolak pengajuan toko ini?"))
            router.delete(route("admin.stores.reject", id));
    };

    return (
        <AdminLayout title="Dashboard Overview">
            <Head title="Admin Dashboard" />

            <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p className="text-gray-500 text-sm mb-1">
                            Total Pengguna
                        </p>
                        <h3 className="text-2xl font-bold text-[#1A1A1A]">
                            {stats.total_users}
                        </h3>
                        <span className="text-xs text-gray-400">
                            User terdaftar
                        </span>
                    </div>
                    <div className="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[#1A1A1A]">
                        <Users size={24} />
                    </div>
                </div>

                <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p className="text-gray-500 text-sm mb-1">
                            Toko Terverifikasi
                        </p>
                        <h3 className="text-2xl font-bold text-[#1A1A1A]">
                            {stats.active_stores}
                        </h3>
                        <span className="text-xs text-gray-400">
                            Aktif berjualan
                        </span>
                    </div>
                    <div className="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[#1A1A1A]">
                        <Store size={24} />
                    </div>
                </div>

                <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p className="text-gray-500 text-sm mb-1">
                            Pending Verifikasi
                        </p>
                        <h3 className="text-2xl font-bold text-[#1A1A1A]">
                            {stats.pending_stores}
                        </h3>
                        <span className="text-xs text-gray-400">
                            Butuh tindakan
                        </span>
                    </div>
                    <div className="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[#1A1A1A]">
                        <AlertCircle size={24} />
                    </div>
                </div>

                <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p className="text-gray-500 text-sm mb-1">
                            Total Saldo Sistem
                        </p>
                        <h3 className="text-xl font-bold text-[#1A1A1A]">
                            {formatRupiah(stats.total_balance)}
                        </h3>
                        <span className="text-xs text-gray-400">
                            Akumulasi saldo toko
                        </span>
                    </div>
                    <div className="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-[#1A1A1A]">
                        <Wallet size={24} />
                    </div>
                </div>
            </div>

            <div className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div className="p-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 className="font-bold text-lg text-[#1A1A1A]">
                            Permintaan Verifikasi Terbaru
                        </h3>
                        <p className="text-sm text-gray-500">
                            {pendingStores.length} toko menunggu persetujuan
                            Anda.
                        </p>
                    </div>
                    <Link
                        href={route("admin.stores")}
                        className="text-sm font-bold text-[#00B207] hover:underline"
                    >
                        Lihat Semua
                    </Link>
                </div>

                <table className="w-full text-left">
                    <thead className="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                        <tr>
                            <th className="px-6 py-4">Nama Toko</th>
                            <th className="px-6 py-4">Pemilik</th>
                            <th className="px-6 py-4">Tanggal Daftar</th>
                            <th className="px-6 py-4">Status</th>
                            <th className="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100 text-sm">
                        {pendingStores.length > 0 ? (
                            pendingStores.map((store) => (
                                <tr
                                    key={store.id}
                                    className="hover:bg-gray-50/50"
                                >
                                    <td className="px-6 py-4 font-bold text-[#1A1A1A]">
                                        {store.name}
                                    </td>
                                    <td className="px-6 py-4">
                                        {store.user.name}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {formatDate(store.created_at)}
                                    </td>
                                    <td className="px-6 py-4">
                                        <span className="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-bold">
                                            Pending
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 flex justify-center gap-2">
                                        <button
                                            onClick={() =>
                                                handleApprove(store.id)
                                            }
                                            className="w-8 h-8 flex items-center justify-center bg-green-100 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition"
                                            title="Terima"
                                        >
                                            <Check size={16} />
                                        </button>
                                        <button
                                            onClick={() =>
                                                handleReject(store.id)
                                            }
                                            className="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition"
                                            title="Tolak"
                                        >
                                            <X size={16} />
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td
                                    colSpan="5"
                                    className="px-6 py-10 text-center text-gray-400"
                                >
                                    Tidak ada permintaan verifikasi baru.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </AdminLayout>
    );
}
