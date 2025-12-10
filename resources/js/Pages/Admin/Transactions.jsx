import React from "react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, router, Link } from "@inertiajs/react";
import { CheckCircle, Clock, Search } from "lucide-react";

export default function Transactions({ transactions }) {
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
            hour: "2-digit",
            minute: "2-digit",
        });

    const confirmPayment = (id) => {
        if (
            confirm(
                "Pastikan dana sudah masuk ke Mutasi Rekening. Konfirmasi pembayaran ini?"
            )
        ) {
            router.patch(route("admin.transactions.confirm", id));
        }
    };

    return (
        <AdminLayout title="Verifikasi Pembayaran">
            <Head title="Verifikasi Pembayaran" />

            <div className="mb-6 flex justify-between items-center">
                <h1 className="text-2xl font-bold text-gray-800">
                    Verifikasi Pembayaran Masuk
                </h1>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table className="w-full text-left">
                    <thead className="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b border-gray-100">
                        <tr>
                            <th className="px-6 py-4">Kode / Tanggal</th>
                            <th className="px-6 py-4">Pembeli</th>
                            <th className="px-6 py-4">Total Bayar</th>
                            <th className="px-6 py-4">Metode</th>
                            <th className="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100 text-sm">
                        {transactions.data.length > 0 ? (
                            transactions.data.map((trx) => (
                                <tr
                                    key={trx.id}
                                    className="hover:bg-gray-50/50"
                                >
                                    <td className="px-6 py-4">
                                        <div className="font-bold text-[#1A1A1A]">
                                            {trx.code}
                                        </div>
                                        <div className="text-xs text-gray-500">
                                            {formatDate(trx.created_at)}
                                        </div>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div className="font-medium text-[#1A1A1A]">
                                            {trx.buyer?.user?.name}
                                        </div>
                                        <div className="text-xs text-gray-500">
                                            Toko: {trx.store?.name}
                                        </div>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div className="font-bold text-[#00B207]">
                                            {formatRupiah(trx.grand_total)}
                                        </div>
                                    </td>
                                    <td className="px-6 py-4">
                                        <span className="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase">
                                            {trx.address_id}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-center">
                                        <button
                                            onClick={() =>
                                                confirmPayment(trx.id)
                                            }
                                            className="inline-flex items-center gap-2 px-4 py-2 bg-[#00B207] text-white rounded-lg hover:bg-green-700 transition text-xs font-bold shadow-sm"
                                        >
                                            <CheckCircle className="w-4 h-4" />{" "}
                                            Verifikasi
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td
                                    colSpan="5"
                                    className="px-6 py-12 text-center text-gray-400"
                                >
                                    <div className="flex flex-col items-center">
                                        <CheckCircle className="w-12 h-12 text-gray-200 mb-2" />
                                        <p>Semua pembayaran aman terkendali.</p>
                                    </div>
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>

                <div className="p-4 border-t border-gray-100 flex justify-center gap-2">
                    {transactions.links.map((link, index) =>
                        link.url ? (
                            <Link
                                key={index}
                                href={link.url}
                                className={`px-3 py-1 rounded border text-xs ${
                                    link.active
                                        ? "bg-[#00B207] text-white border-[#00B207]"
                                        : "bg-white"
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ) : null
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
