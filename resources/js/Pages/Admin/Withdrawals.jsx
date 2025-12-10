import React from "react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Check, X, Search, Wallet } from "lucide-react";

export default function Withdrawals({ withdrawals }) {
    const formatRupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(number);
    };

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    };

    const handleApprove = (id) => {
        if (
            confirm(
                "Setujui penarikan saldo ini? Saldo toko akan otomatis terpotong."
            )
        ) {
            router.patch(
                route("admin.withdrawals.approve", id),
                {},
                { preserveScroll: true }
            );
        }
    };

    const handleReject = (id) => {
        if (confirm("Tolak permintaan penarikan ini?")) {
            router.patch(
                route("admin.withdrawals.reject", id),
                {},
                { preserveScroll: true }
            );
        }
    };

    return (
        <AdminLayout title="Penarikan Saldo">
            <Head title="Penarikan Saldo" />

            <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div className="relative w-full md:w-96">
                    <div
                        className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10"
                        style={{ paddingLeft: "0.6rem" }}
                    >
                        <Search className="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="text"
                        style={{ paddingLeft: "2.5rem" }}
                        className="block w-full pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#00B207] focus:ring-[#00B207] sm:text-sm transition duration-150 ease-in-out h-10 shadow-sm"
                        placeholder="Cari toko atau ID transaksi..."
                    />
                </div>

                <div className="flex bg-gray-200 p-1 rounded-lg h-10 items-center">
                    <button className="px-4 h-full text-xs font-bold rounded-md shadow-sm bg-white text-[#1A1A1A]">
                        Semua
                    </button>
                    <button className="px-4 h-full text-xs font-bold text-gray-500 hover:text-gray-700">
                        Pending
                    </button>
                    <button className="px-4 h-full text-xs font-bold text-gray-500 hover:text-gray-700">
                        Selesai
                    </button>
                </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">Nama Toko</th>
                                <th className="px-6 py-4">Jumlah Penarikan</th>
                                <th className="px-6 py-4">Bank Tujuan</th>
                                <th className="px-6 py-4">Tanggal</th>
                                <th className="px-6 py-4">Status</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {withdrawals.data.length > 0 ? (
                                withdrawals.data.map((wd) => (
                                    <tr
                                        key={wd.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4 font-bold text-[#1A1A1A]">
                                            {wd.store_balance?.store?.name ||
                                                "Unknown Store"}
                                        </td>
                                        <td className="px-6 py-4 font-bold text-[#00B207]">
                                            {formatRupiah(wd.amount)}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            <div className="font-medium">
                                                {wd.bank_name}
                                            </div>
                                            <div className="text-xs text-gray-400">
                                                {wd.bank_account_number} -{" "}
                                                {wd.bank_account_name}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-gray-500">
                                            {formatDate(wd.created_at)}
                                        </td>
                                        <td className="px-6 py-4">
                                            {wd.status === "pending" ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">
                                                    Pending
                                                </span>
                                            ) : wd.status === "approved" ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    Berhasil
                                                </span>
                                            ) : (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                    Ditolak
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            {wd.status === "pending" && (
                                                <div className="flex items-center justify-center gap-2">
                                                    <button
                                                        onClick={() =>
                                                            handleApprove(wd.id)
                                                        }
                                                        className="p-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition"
                                                        title="Setujui Transfer"
                                                    >
                                                        <Check className="w-4 h-4" />
                                                    </button>
                                                    <button
                                                        onClick={() =>
                                                            handleReject(wd.id)
                                                        }
                                                        className="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition"
                                                        title="Tolak"
                                                    >
                                                        <X className="w-4 h-4" />
                                                    </button>
                                                </div>
                                            )}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="6">
                                        <div className="flex flex-col items-center justify-center py-16 text-center">
                                            <div className="bg-gray-50 p-4 rounded-full mb-3">
                                                <Wallet className="w-10 h-10 text-gray-300" />
                                            </div>
                                            <h4 className="text-gray-900 font-medium mb-1">
                                                Tidak Ada Data
                                            </h4>
                                            <p className="text-gray-500 text-sm">
                                                Belum ada permintaan penarikan
                                                saldo.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    Showing {withdrawals.from ?? 0} to {withdrawals.to ?? 0} of{" "}
                    {withdrawals.total ?? 0} entries
                    <div className="flex gap-2">
                        {withdrawals.links &&
                            withdrawals.links.map((link, index) =>
                                link.url ? (
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
                                )
                            )}
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
