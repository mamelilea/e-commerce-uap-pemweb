import React, { useState } from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import { Search, Package, Truck, X, Save } from "lucide-react";

export default function Index({ orders, filters }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || "");
    const currentStatus = filters.status || "all";

    const [isResiOpen, setIsResiOpen] = useState(false);
    const [selectedOrder, setSelectedOrder] = useState(null);

    const { data, setData, patch, processing, reset, errors } = useForm({
        tracking_number: "",
    });

    const handleSearch = (e) => {
        if (e.key === "Enter") {
            router.get(
                route("seller.orders.index"),
                { search: searchTerm, status: currentStatus },
                { preserveState: true }
            );
        }
    };

    const handleFilterChange = (status) => {
        router.get(
            route("seller.orders.index"),
            { status: status, search: searchTerm },
            { preserveState: true }
        );
    };

    const openResiModal = (order) => {
        setSelectedOrder(order);
        setData("tracking_number", order.tracking_number || "");
        setIsResiOpen(true);
    };

    const submitResi = (e) => {
        e.preventDefault();
        patch(route("seller.orders.resi", selectedOrder.id), {
            onSuccess: () => {
                setIsResiOpen(false);
                setSelectedOrder(null);
                reset();
            },
        });
    };

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
            month: "short",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });
    };

    return (
        <SellerLayout title="Kelola Pesanan">
            <Head title="Kelola Pesanan" />

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
                        placeholder="Cari kode transaksi..."
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
                        onClick={() => handleFilterChange("unpaid")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "unpaid"
                                ? "bg-white text-orange-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Unpaid
                    </button>
                    <button
                        onClick={() => handleFilterChange("processing")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "processing"
                                ? "bg-white text-blue-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Dikemas
                    </button>
                    <button
                        onClick={() => handleFilterChange("shipped")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentStatus === "shipped"
                                ? "bg-white text-green-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Dikirim
                    </button>
                </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">Kode / Tanggal</th>
                                <th className="px-6 py-4">Pembeli</th>
                                <th className="px-6 py-4">Detail Item</th>
                                <th className="px-6 py-4">
                                    Total & Pengiriman
                                </th>
                                <th className="px-6 py-4">Status</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {orders.data.length > 0 ? (
                                orders.data.map((order) => (
                                    <tr
                                        key={order.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4 align-top">
                                            <div className="font-bold text-[#1A1A1A]">
                                                {order.code}
                                            </div>
                                            <div className="text-xs text-gray-500">
                                                {formatDate(order.created_at)}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 align-top">
                                            <div className="font-bold text-[#1A1A1A]">
                                                {order.buyer?.user?.name ||
                                                    "Unknown"}
                                            </div>
                                            <div className="text-xs text-gray-500">
                                                {order.buyer?.phone_number}
                                            </div>
                                            <div className="text-xs text-gray-500 mt-1 line-clamp-2">
                                                {order.address}, {order.city}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 align-top">
                                            <div className="space-y-2">
                                                {order.transaction_details.map(
                                                    (detail) => (
                                                        <div
                                                            key={detail.id}
                                                            className="flex gap-2"
                                                        >
                                                            <div className="w-8 h-8 bg-gray-100 rounded flex-shrink-0 overflow-hidden">
                                                                {detail.product
                                                                    ?.product_images?.[0] && (
                                                                    <img
                                                                        src={`/storage/${detail.product.product_images[0].image}`}
                                                                        className="w-full h-full object-cover"
                                                                    />
                                                                )}
                                                            </div>
                                                            <div>
                                                                <div className="text-xs font-bold text-[#1A1A1A] line-clamp-1">
                                                                    {
                                                                        detail
                                                                            .product
                                                                            ?.name
                                                                    }
                                                                </div>
                                                                <div className="text-xs text-gray-500">
                                                                    x
                                                                    {detail.qty}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    )
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 align-top">
                                            <div className="font-bold text-[#00B207]">
                                                {formatRupiah(
                                                    order.grand_total
                                                )}
                                            </div>
                                            <div className="text-xs text-gray-500 mt-1">
                                                Ekspedisi:{" "}
                                                <span className="font-bold">
                                                    {order.shipping}
                                                </span>
                                            </div>
                                            {order.tracking_number && (
                                                <div className="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded inline-block mt-1">
                                                    Resi:{" "}
                                                    {order.tracking_number}
                                                </div>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 align-top">
                                            {order.payment_status ===
                                            "unpaid" ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600">
                                                    Unpaid
                                                </span>
                                            ) : !order.tracking_number ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600">
                                                    Perlu Dikirim
                                                </span>
                                            ) : (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    Dikirim
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center align-top space-y-2">
                                            {order.payment_status ===
                                                "unpaid" &&
                                                order.address_id !== "cod" && (
                                                    <span
                                                        className="inline-block px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200 cursor-help"
                                                        title="Menunggu Admin memverifikasi pembayaran pembeli"
                                                    >
                                                        Menunggu Admin
                                                    </span>
                                                )}

                                            {(order.payment_status === "paid" ||
                                                order.address_id === "cod") && (
                                                <button
                                                    onClick={() =>
                                                        openResiModal(order)
                                                    }
                                                    className="inline-flex items-center justify-center gap-1 w-full px-3 py-1.5 bg-[#1A1A1A] text-white rounded-lg hover:bg-gray-800 transition text-xs font-bold shadow-sm"
                                                >
                                                    <Truck className="w-3 h-3" />
                                                    {order.tracking_number
                                                        ? "Edit Resi"
                                                        : "Input Resi"}
                                                </button>
                                            )}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="6">
                                        <div className="flex flex-col items-center justify-center py-16 text-center">
                                            <div className="bg-gray-50 p-4 rounded-full mb-3">
                                                <Package className="w-10 h-10 text-gray-300" />
                                            </div>
                                            <h4 className="text-gray-900 font-medium mb-1">
                                                Belum Ada Pesanan
                                            </h4>
                                            <p className="text-gray-500 text-sm">
                                                Pesanan masuk akan muncul di
                                                sini.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    Showing {orders.from ?? 0} to {orders.to ?? 0} of{" "}
                    {orders.total ?? 0} entries
                    <div className="flex gap-2">
                        {orders.links &&
                            orders.links.map((link, index) =>
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

            {isResiOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                    <div className="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 className="font-bold text-lg text-[#1A1A1A]">
                                Update Pengiriman
                            </h3>
                            <button
                                onClick={() => setIsResiOpen(false)}
                                className="text-gray-400 hover:text-gray-600 transition"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={submitResi} className="p-6 space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Nomor Resi / Tracking Number
                                </label>
                                <input
                                    type="text"
                                    value={data.tracking_number}
                                    onChange={(e) =>
                                        setData(
                                            "tracking_number",
                                            e.target.value
                                        )
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="Masukkan nomor resi..."
                                />
                                {errors.tracking_number && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.tracking_number}
                                    </div>
                                )}
                            </div>

                            <div className="pt-4 flex justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => setIsResiOpen(false)}
                                    className="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-[#00B207] rounded-lg text-sm font-bold text-white hover:bg-green-700 flex items-center gap-2"
                                >
                                    {processing ? (
                                        "Menyimpan..."
                                    ) : (
                                        <>
                                            <Save className="w-4 h-4" /> Simpan
                                            Resi
                                        </>
                                    )}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </SellerLayout>
    );
}
