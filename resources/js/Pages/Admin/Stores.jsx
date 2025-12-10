import React, { useState } from "react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Check, X, Search, Store as StoreIcon } from "lucide-react";

export default function Stores({ stores, filters }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || "");
    const currentStatus = filters.status || "all";

    const handleSearch = (e) => {
        if (e.key === "Enter") {
            router.get(
                route("admin.stores"),
                { search: searchTerm, status: currentStatus },
                { preserveState: true }
            );
        }
    };

    const handleFilterChange = (status) => {
        router.get(
            route("admin.stores"),
            { status: status, search: searchTerm },
            { preserveState: true }
        );
    };

    const handleApprove = (id, name) => {
        if (confirm(`Verifikasi toko "${name}"?`)) {
            router.patch(
                route("admin.stores.approve", id),
                {},
                {
                    preserveScroll: true,
                }
            );
        }
    };

    const handleReject = (id, name) => {
        if (
            confirm(`Tolak pengajuan toko "${name}"? Data toko akan dihapus.`)
        ) {
            router.delete(route("admin.stores.reject", id), {
                preserveScroll: true,
            });
        }
    };

    return (
        <AdminLayout title="Manajemen Toko">
            <Head title="Kelola Toko" />

            <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div className="relative w-full md:w-96">
                    <div
                        className="absolute inset-y-0 left-0 flex items-center pointer-events-none z-10"
                        style={{ paddingLeft: "0.6rem" }}
                    >
                        <Search className="h-5 w-5 text-gray-400" />
                    </div>

                    <input
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        onKeyDown={handleSearch}
                        style={{ paddingLeft: "2.5rem" }}
                        className="block w-full pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#00B207] focus:ring-[#00B207] sm:text-sm transition duration-150 ease-in-out h-10 shadow-sm"
                        placeholder="Cari nama toko atau pemilik..."
                    />
                </div>

                <div className="flex bg-gray-200 p-1 rounded-lg h-10 items-center">
                    <button
                        onClick={() => handleFilterChange("all")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "all"
                                ? "bg-white text-[#1A1A1A] shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Semua
                    </button>
                    <button
                        onClick={() => handleFilterChange("pending")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "pending"
                                ? "bg-white text-orange-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Pending
                    </button>
                    <button
                        onClick={() => handleFilterChange("active")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "active"
                                ? "bg-white text-green-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Aktif
                    </button>
                </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">Info Toko</th>
                                <th className="px-6 py-4">Pemilik</th>
                                <th className="px-6 py-4">Lokasi</th>
                                <th className="px-6 py-4">Status</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {stores.data.length > 0 ? (
                                stores.data.map((store) => (
                                    <tr
                                        key={store.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0">
                                                    {store.logo ? (
                                                        <img
                                                            src={`/storage/${store.logo}`}
                                                            alt=""
                                                            className="w-full h-full object-cover rounded-lg"
                                                        />
                                                    ) : (
                                                        <StoreIcon className="w-5 h-5" />
                                                    )}
                                                </div>
                                                <div>
                                                    <div className="font-bold text-[#1A1A1A]">
                                                        {store.name}
                                                    </div>
                                                    <div className="text-xs text-gray-500">
                                                        ID: #{store.id}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {store.user?.name || "Unknown"}
                                            <div className="text-xs text-gray-400">
                                                {store.phone}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {store.city || "-"}
                                        </td>
                                        <td className="px-6 py-4">
                                            {store.is_verified ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    Terverifikasi
                                                </span>
                                            ) : (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600 animate-pulse">
                                                    Pending
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            {!store.is_verified ? (
                                                <div className="flex items-center justify-center gap-2">
                                                    {/* TOMBOL APPROVE */}
                                                    <button
                                                        onClick={() =>
                                                            handleApprove(
                                                                store.id,
                                                                store.name
                                                            )
                                                        }
                                                        className="p-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition"
                                                        title="Verifikasi Toko Ini"
                                                    >
                                                        <Check className="w-4 h-4" />
                                                    </button>

                                                    {/* TOMBOL REJECT */}
                                                    <button
                                                        onClick={() =>
                                                            handleReject(
                                                                store.id,
                                                                store.name
                                                            )
                                                        }
                                                        className="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition"
                                                        title="Tolak"
                                                    >
                                                        <X className="w-4 h-4" />
                                                    </button>
                                                </div>
                                            ) : (
                                                <span className="text-xs text-gray-400 italic">
                                                    No Action
                                                </span>
                                            )}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td
                                        colSpan="5"
                                        className="px-6 py-10 text-center text-gray-400"
                                    >
                                        Tidak ada data toko ditemukan.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    Showing {stores.from} to {stores.to} of {stores.total}{" "}
                    entries
                    <div className="flex gap-2">
                        {stores.links.map((link, index) => {
                            return link.url ? (
                                <Link
                                    key={index}
                                    href={link.url}
                                    className={`px-3 py-1 rounded border ${
                                        link.active
                                            ? "bg-[#00B207] text-white border-[#00B207]"
                                            : "bg-white border-gray-300 hover:bg-gray-50"
                                    }`}
                                    dangerouslySetInnerHTML={{
                                        __html: link.label,
                                    }}
                                />
                            ) : (
                                <span
                                    key={index}
                                    className="px-3 py-1 rounded border bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed"
                                    dangerouslySetInnerHTML={{
                                        __html: link.label,
                                    }}
                                />
                            );
                        })}
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
