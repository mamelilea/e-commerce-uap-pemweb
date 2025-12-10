import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link, useForm, router } from "@inertiajs/react";
import {
    ArrowLeft,
    MapPin,
    Package,
    Truck,
    CheckCircle,
    Clock,
    Star,
    X,
} from "lucide-react";

export default function Detail({ order, existingReviews }) {
    const [reviewModalOpen, setReviewModalOpen] = useState(false);
    const [selectedProduct, setSelectedProduct] = useState(null);

    const { data, setData, post, processing, reset, errors } = useForm({
        product_id: "",
        rating: 5,
        review: "",
    });

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
            hour: "2-digit",
            minute: "2-digit",
        });

    const handleOrderReceived = () => {
        if (
            confirm(
                "Apakah Anda yakin pesanan sudah diterima dengan baik? Dana akan diteruskan ke Penjual."
            )
        ) {
            router.post(
                route("my-order.complete", order.code),
                {},
                {
                    preserveScroll: true,
                    onError: (errors) => {
                        if (errors.error) {
                            alert(errors.error);
                        }
                    },
                }
            );
        }
    };

    const openReviewModal = (product) => {
        setSelectedProduct(product);
        setData("product_id", product.id);
        setData("rating", 5);
        setData("review", "");
        setReviewModalOpen(true);
    };

    const submitReview = (e) => {
        e.preventDefault();
        post(route("reviews.store"), {
            onSuccess: () => {
                setReviewModalOpen(false);
                reset();
            },
        });
    };

    const getProductReview = (productId) => {
        return existingReviews.find((r) => r.product_id === productId);
    };

    let statusContent;

    if (order.payment_status === "done") {
        statusContent = (
            <div className="bg-green-50 border border-green-200 rounded-xl p-6 mb-8 flex gap-4 items-start">
                <div className="bg-green-100 p-3 rounded-full shrink-0">
                    <CheckCircle className="w-6 h-6 text-green-600" />
                </div>
                <div>
                    <h3 className="text-lg font-bold text-green-800 mb-1">
                        Pesanan Selesai
                    </h3>
                    <p className="text-sm text-green-700">
                        Transaksi selesai. Terima kasih telah berbelanja!
                    </p>
                </div>
            </div>
        );
    } else if (
        order.payment_status === "unpaid" &&
        order.address_id !== "cod"
    ) {
        statusContent = (
            <div className="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8 flex gap-4 items-start">
                <div className="bg-yellow-100 p-3 rounded-full shrink-0">
                    <Clock className="w-6 h-6 text-yellow-600" />
                </div>
                <div>
                    <h3 className="text-lg font-bold text-yellow-800 mb-1">
                        Menunggu Konfirmasi Pembayaran
                    </h3>
                    <p className="text-sm text-yellow-700">
                        Kami sedang menunggu Penjual memverifikasi pembayaran
                        Anda.
                    </p>
                </div>
            </div>
        );
    } else if (!order.tracking_number) {
        statusContent = (
            <div className="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 flex gap-4 items-start">
                <div className="bg-blue-100 p-3 rounded-full shrink-0">
                    <Package className="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <h3 className="text-lg font-bold text-blue-800 mb-1">
                        Pembayaran Sukses!
                    </h3>
                    <p className="text-sm text-blue-700">
                        Penjual sedang menyiapkan barang Anda untuk dikirim.
                    </p>
                </div>
            </div>
        );
    } else {
        statusContent = (
            <div className="bg-indigo-50 border border-indigo-200 rounded-xl p-6 mb-8 flex flex-col md:flex-row gap-6 items-start justify-between">
                <div className="flex gap-4">
                    <div className="bg-indigo-100 p-3 rounded-full shrink-0">
                        <Truck className="w-6 h-6 text-indigo-600" />
                    </div>
                    <div>
                        <h3 className="text-lg font-bold text-indigo-800 mb-1">
                            Pesanan Sedang Dikirim
                        </h3>
                        <p className="text-sm text-indigo-700 mb-2">
                            Paket Anda sedang dalam perjalanan.
                        </p>
                        <div className="bg-white px-3 py-1 rounded border border-indigo-200 inline-flex items-center gap-2">
                            <span className="text-xs text-gray-500 uppercase font-bold">
                                Resi:
                            </span>
                            <span className="font-mono font-bold text-[#1A1A1A]">
                                {order.tracking_number}
                            </span>
                        </div>
                    </div>
                </div>

                <button
                    onClick={handleOrderReceived}
                    className="w-full md:w-auto px-6 py-3 bg-[#00B207] hover:bg-green-700 text-white rounded-full font-bold shadow-lg shadow-green-200 transition transform hover:-translate-y-1 flex items-center justify-center gap-2"
                >
                    <CheckCircle className="w-5 h-5" />
                    Pesanan Diterima
                </button>
            </div>
        );
    }

    return (
        <MainLayout title={`Detail Pesanan #${order.code}`}>
            <Head title="Detail Pesanan" />

            <div className="bg-[#F4F6F5] min-h-screen py-10">
                <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <Link
                        href={route("my-order")}
                        className="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#00B207] mb-6 transition"
                    >
                        <ArrowLeft className="w-4 h-4" /> Kembali ke Pesanan
                        Saya
                    </Link>

                    {statusContent}

                    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div className="px-8 py-6 border-b border-gray-100 flex justify-between items-start bg-gray-50/50">
                            <div>
                                <p className="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">
                                    Kode Pesanan
                                </p>
                                <h1 className="text-xl font-bold text-[#1A1A1A] font-mono">
                                    #{order.code}
                                </h1>
                                <p className="text-xs text-gray-400 mt-1">
                                    {formatDate(order.created_at)}
                                </p>
                            </div>
                            <div className="text-right">
                                <p className="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">
                                    Total Pembayaran
                                </p>
                                <h2 className="text-xl font-bold text-[#00B207]">
                                    {formatRupiah(order.grand_total)}
                                </h2>
                            </div>
                        </div>

                        <div className="px-8 py-6 border-b border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 className="text-sm font-bold text-[#1A1A1A] mb-3 flex items-center gap-2">
                                    <MapPin className="w-4 h-4 text-gray-400" />{" "}
                                    Alamat Pengiriman
                                </h4>
                                <p className="text-sm text-gray-600 leading-relaxed">
                                    {order.address}
                                    <br />
                                    {order.city}, {order.postal_code}
                                </p>
                            </div>
                            <div>
                                <h4 className="text-sm font-bold text-[#1A1A1A] mb-3 flex items-center gap-2">
                                    <Truck className="w-4 h-4 text-gray-400" />{" "}
                                    Ekspedisi
                                </h4>
                                <p className="text-sm text-gray-600">
                                    {order.shipping} - {order.shipping_type}
                                    <br />
                                    <span className="text-xs text-gray-400">
                                        Ongkir:{" "}
                                        {formatRupiah(order.shipping_cost)}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div className="px-8 py-6">
                            <h4 className="text-sm font-bold text-[#1A1A1A] mb-4 flex items-center gap-2">
                                <Package className="w-4 h-4 text-gray-400" />{" "}
                                Detail Produk
                            </h4>
                            <div className="space-y-6">
                                {order.transaction_details.map((detail) => {
                                    const review = getProductReview(
                                        detail.product_id
                                    );
                                    return (
                                        <div
                                            key={detail.id}
                                            className="flex flex-col sm:flex-row gap-4 items-start sm:items-center border-b border-gray-50 pb-6 last:border-none last:pb-0"
                                        >
                                            <div className="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shrink-0">
                                                {detail.product
                                                    ?.product_images?.[0] && (
                                                    <img
                                                        src={`/storage/${detail.product.product_images[0].image}`}
                                                        className="w-full h-full object-cover"
                                                    />
                                                )}
                                            </div>
                                            <div className="flex-1">
                                                <h5 className="font-bold text-[#1A1A1A] text-sm line-clamp-1">
                                                    {detail.product?.name}
                                                </h5>
                                                <p className="text-xs text-gray-500 mt-1">
                                                    {detail.qty} x{" "}
                                                    {formatRupiah(detail.price)}
                                                </p>
                                            </div>
                                            <div className="text-right flex flex-col items-end gap-2 min-w-[120px]">
                                                <div className="font-bold text-[#1A1A1A] text-sm">
                                                    {formatRupiah(
                                                        detail.subtotal
                                                    )}
                                                </div>

                                                {order.payment_status ===
                                                    "done" &&
                                                    (review ? (
                                                        <div className="flex items-center gap-1 px-3 py-1 bg-yellow-50 rounded-full">
                                                            <Star className="w-3 h-3 text-yellow-400 fill-current" />
                                                            <span className="text-xs font-bold text-yellow-700">
                                                                {review.rating}
                                                            </span>
                                                        </div>
                                                    ) : (
                                                        <button
                                                            onClick={() =>
                                                                openReviewModal(
                                                                    detail.product
                                                                )
                                                            }
                                                            className="text-xs font-bold text-[#00B207] hover:text-green-700 border border-[#00B207] px-3 py-1 rounded-full hover:bg-green-50 transition"
                                                        >
                                                            Beri Ulasan
                                                        </button>
                                                    ))}
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {reviewModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                    <div className="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 className="font-bold text-lg text-[#1A1A1A]">
                                Ulas Produk
                            </h3>
                            <button
                                onClick={() => setReviewModalOpen(false)}
                                className="text-gray-400 hover:text-gray-600 transition"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={submitReview} className="p-6">
                            <div className="flex gap-4 items-center mb-6">
                                <div className="w-12 h-12 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shrink-0">
                                    {selectedProduct?.product_images?.[0] && (
                                        <img
                                            src={`/storage/${selectedProduct.product_images[0].image}`}
                                            className="w-full h-full object-cover"
                                        />
                                    )}
                                </div>
                                <div className="text-sm font-bold text-[#1A1A1A] line-clamp-2">
                                    {selectedProduct?.name}
                                </div>
                            </div>

                            <div className="mb-4">
                                <label className="block text-xs font-bold text-gray-500 mb-2">
                                    Rating
                                </label>
                                <div className="flex gap-2">
                                    {[1, 2, 3, 4, 5].map((star) => (
                                        <button
                                            key={star}
                                            type="button"
                                            onClick={() =>
                                                setData("rating", star)
                                            }
                                            className={`transition hover:scale-110 ${
                                                data.rating >= star
                                                    ? "text-yellow-400"
                                                    : "text-gray-300"
                                            }`}
                                        >
                                            <Star className="w-8 h-8 fill-current" />
                                        </button>
                                    ))}
                                </div>
                            </div>

                            <div className="mb-6">
                                <label className="block text-xs font-bold text-gray-500 mb-2">
                                    Komentar
                                </label>
                                <textarea
                                    rows="3"
                                    value={data.review}
                                    onChange={(e) =>
                                        setData("review", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 text-sm focus:ring-[#00B207] focus:border-[#00B207]"
                                    placeholder="Bagaimana kualitas produk ini?"
                                ></textarea>
                                {errors.review && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.review}
                                    </div>
                                )}
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full py-3 bg-[#00B207] text-white rounded-full font-bold shadow-md hover:bg-green-700 transition"
                            >
                                {processing ? "Mengirim..." : "Kirim Ulasan"}
                            </button>
                        </form>
                    </div>
                </div>
            )}
        </MainLayout>
    );
}
