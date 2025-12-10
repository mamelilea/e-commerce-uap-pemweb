import React, { useState } from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, useForm, Link } from "@inertiajs/react";
import {
    Wallet,
    ArrowUpRight,
    History,
    X,
    Save,
    AlertCircle,
} from "lucide-react";

export default function Finance({ balance, withdrawals }) {
    const [isWithdrawOpen, setIsWithdrawOpen] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        amount: "",
        bank_name: "",
        bank_account_number: "",
        bank_account_name: "",
    });

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
            hour: "2-digit",
            minute: "2-digit",
        });
    };

    const submitWithdraw = (e) => {
        e.preventDefault();
        post(route("seller.balance.withdraw"), {
            onSuccess: () => {
                setIsWithdrawOpen(false);
                reset();
            },
        });
    };

    return (
        <SellerLayout title="Keuangan Toko">
            <Head title="Keuangan" />

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div className="lg:col-span-2 bg-[#1A1A1A] rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
                    <div className="absolute top-0 right-0 p-8 opacity-10">
                        <Wallet className="w-32 h-32 text-white" />
                    </div>

                    <div className="relative z-10">
                        <p className="text-gray-400 font-medium mb-2 flex items-center gap-2">
                            <Wallet className="w-5 h-5" /> Saldo Aktif
                        </p>
                        <h2 className="text-4xl lg:text-5xl font-bold font-poppins mb-6">
                            {formatRupiah(balance)}
                        </h2>

                        <button
                            onClick={() => setIsWithdrawOpen(true)}
                            className="inline-flex items-center gap-2 px-6 py-3 bg-[#00B207] text-white rounded-full font-bold hover:bg-green-600 transition shadow-lg shadow-green-900/50"
                        >
                            <ArrowUpRight className="w-5 h-5" />
                            Tarik Saldo
                        </button>
                    </div>
                </div>

                <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
                    <h3 className="font-bold text-[#1A1A1A] mb-4 flex items-center gap-2">
                        <AlertCircle className="w-5 h-5 text-orange-500" />
                        Info Penarikan
                    </h3>
                    <ul className="space-y-3 text-sm text-gray-500">
                        <li className="flex items-start gap-2">
                            <span className="w-1.5 h-1.5 bg-gray-300 rounded-full mt-1.5"></span>
                            Minimal penarikan saldo adalah Rp 10.000.
                        </li>
                        <li className="flex items-start gap-2">
                            <span className="w-1.5 h-1.5 bg-gray-300 rounded-full mt-1.5"></span>
                            Proses verifikasi admin maksimal 1x24 jam kerja.
                        </li>
                        <li className="flex items-start gap-2">
                            <span className="w-1.5 h-1.5 bg-gray-300 rounded-full mt-1.5"></span>
                            Pastikan data rekening yang Anda masukkan benar.
                        </li>
                    </ul>
                </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="p-6 border-b border-gray-100 flex items-center gap-3">
                    <History className="w-5 h-5 text-gray-400" />
                    <h3 className="font-bold text-[#1A1A1A]">
                        Riwayat Penarikan
                    </h3>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">ID Transaksi</th>
                                <th className="px-6 py-4">Tanggal</th>
                                <th className="px-6 py-4">Bank Tujuan</th>
                                <th className="px-6 py-4">Jumlah</th>
                                <th className="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {withdrawals.data.length > 0 ? (
                                withdrawals.data.map((wd) => (
                                    <tr
                                        key={wd.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4 text-gray-500">
                                            #{wd.id}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {formatDate(wd.created_at)}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            <div className="font-bold text-[#1A1A1A]">
                                                {wd.bank_name}
                                            </div>
                                            <div className="text-xs text-gray-400">
                                                {wd.bank_account_number}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 font-bold text-[#1A1A1A]">
                                            {formatRupiah(wd.amount)}
                                        </td>
                                        <td className="px-6 py-4">
                                            {wd.status === "pending" ? (
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">
                                                    Pending
                                                </span>
                                            ) : wd.status === "approved" ? (
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    Berhasil
                                                </span>
                                            ) : (
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                    Ditolak
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
                                        Belum ada riwayat penarikan.
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

            {isWithdrawOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                    <div className="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 className="font-bold text-lg text-[#1A1A1A]">
                                Tarik Saldo
                            </h3>
                            <button
                                onClick={() => setIsWithdrawOpen(false)}
                                className="text-gray-400 hover:text-gray-600 transition"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form
                            onSubmit={submitWithdraw}
                            className="p-6 space-y-4"
                        >
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Jumlah Penarikan (Rp)
                                </label>
                                <input
                                    type="number"
                                    value={data.amount}
                                    onChange={(e) =>
                                        setData("amount", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="Min. 10.000"
                                />
                                <p className="text-xs text-gray-400 mt-1">
                                    Saldo tersedia: {formatRupiah(balance)}
                                </p>
                                {errors.amount && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.amount}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Bank / E-Wallet
                                </label>
                                <input
                                    type="text"
                                    value={data.bank_name}
                                    onChange={(e) =>
                                        setData("bank_name", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="Contoh: BCA, Mandiri, GoPay"
                                />
                                {errors.bank_name && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.bank_name}
                                    </div>
                                )}
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor Rekening
                                    </label>
                                    <input
                                        type="text"
                                        value={data.bank_account_number}
                                        onChange={(e) =>
                                            setData(
                                                "bank_account_number",
                                                e.target.value
                                            )
                                        }
                                        className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                        placeholder="1234xxxx"
                                    />
                                    {errors.bank_account_number && (
                                        <div className="text-red-500 text-xs mt-1">
                                            {errors.bank_account_number}
                                        </div>
                                    )}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Atas Nama
                                    </label>
                                    <input
                                        type="text"
                                        value={data.bank_account_name}
                                        onChange={(e) =>
                                            setData(
                                                "bank_account_name",
                                                e.target.value
                                            )
                                        }
                                        className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                        placeholder="Nama Pemilik"
                                    />
                                    {errors.bank_account_name && (
                                        <div className="text-red-500 text-xs mt-1">
                                            {errors.bank_account_name}
                                        </div>
                                    )}
                                </div>
                            </div>

                            <div className="pt-4">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full py-3 bg-[#00B207] text-white rounded-full font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center justify-center gap-2"
                                >
                                    {processing
                                        ? "Memproses..."
                                        : "Kirim Permintaan"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </SellerLayout>
    );
}
