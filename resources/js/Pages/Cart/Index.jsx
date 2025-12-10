import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Trash2, Minus, Plus, ShoppingBag, Store } from "lucide-react";

export default function Index({ carts, continueUrl }) {
    const formatRupiah = (num) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(num);

    const subtotal = carts.reduce(
        (acc, item) => acc + item.product.price * item.qty,
        0
    );
    const tax = subtotal * 0.11;
    const total = subtotal + tax;

    const updateQty = (id, type) => {
        router.patch(
            route("cart.update", id),
            { type },
            { preserveScroll: true }
        );
    };

    const removeItem = (id) => {
        if (confirm("Hapus produk ini dari keranjang?")) {
            router.delete(route("cart.destroy", id));
        }
    };

    return (
        <MainLayout title="Keranjang Belanja">
            <Head title="Keranjang Belanja" />

            <div className="bg-[#F4F6F5] min-h-screen py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 className="text-2xl font-bold text-[#1A1A1A] mb-8 font-poppins flex items-center gap-2">
                        <ShoppingBag className="w-6 h-6 text-[#00B207]" />
                        Keranjang Belanja Anda
                    </h1>

                    {carts.length > 0 ? (
                        <div className="flex flex-col lg:flex-row gap-8">
                            <div className="flex-1 space-y-4">
                                {carts.map((item) => (
                                    <div
                                        key={item.id}
                                        className="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-4 items-center"
                                    >
                                        <div className="w-24 h-24 bg-gray-50 rounded-lg flex-shrink-0 overflow-hidden border border-gray-100">
                                            {item.product
                                                .product_images?.[0] ? (
                                                <img
                                                    src={`/storage/${item.product.product_images[0].image}`}
                                                    className="w-full h-full object-cover"
                                                />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-gray-300 text-xs">
                                                    No Img
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 text-xs text-gray-500 mb-1">
                                                <Store className="w-3 h-3" />
                                                {item.product.store?.name}
                                            </div>
                                            <Link
                                                href={route(
                                                    "product.detail",
                                                    item.product.slug
                                                )}
                                                className="font-bold text-[#1A1A1A] text-lg hover:text-[#00B207] transition line-clamp-1"
                                            >
                                                {item.product.name}
                                            </Link>
                                            <div className="font-bold text-[#00B207] mt-1">
                                                {formatRupiah(
                                                    item.product.price
                                                )}
                                            </div>
                                        </div>

                                        <div className="flex flex-col items-end gap-4">
                                            <div className="flex items-center border border-gray-200 rounded-full px-3 py-1">
                                                <button
                                                    onClick={() =>
                                                        updateQty(
                                                            item.id,
                                                            "minus"
                                                        )
                                                    }
                                                    className="p-1 hover:text-[#00B207] disabled:opacity-50"
                                                    disabled={item.qty <= 1}
                                                >
                                                    <Minus className="w-4 h-4" />
                                                </button>
                                                <span className="mx-3 font-bold text-[#1A1A1A] text-sm w-4 text-center">
                                                    {item.qty}
                                                </span>
                                                <button
                                                    onClick={() =>
                                                        updateQty(
                                                            item.id,
                                                            "plus"
                                                        )
                                                    }
                                                    className="p-1 hover:text-[#00B207] disabled:opacity-50"
                                                    disabled={
                                                        item.qty >=
                                                        item.product.stock
                                                    }
                                                >
                                                    <Plus className="w-4 h-4" />
                                                </button>
                                            </div>
                                            <button
                                                onClick={() =>
                                                    removeItem(item.id)
                                                }
                                                className="text-gray-400 hover:text-red-500 transition"
                                            >
                                                <Trash2 className="w-5 h-5" />
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="lg:w-96">
                                <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                                    <h3 className="font-bold text-lg text-[#1A1A1A] mb-4">
                                        Ringkasan Belanja
                                    </h3>

                                    <div className="space-y-3 mb-6 border-b border-gray-100 pb-6">
                                        <div className="flex justify-between text-gray-600 text-sm">
                                            <span>
                                                Subtotal ({carts.length} barang)
                                            </span>
                                            <span className="font-medium">
                                                {formatRupiah(subtotal)}
                                            </span>
                                        </div>
                                        <div className="flex justify-between text-gray-600 text-sm">
                                            <span>PPN (11%)</span>
                                            <span className="font-medium text-orange-600">
                                                +{formatRupiah(tax)}
                                            </span>
                                        </div>
                                    </div>

                                    <div className="flex justify-between items-center mb-6">
                                        <span className="font-bold text-[#1A1A1A] text-lg">
                                            Total Belanja
                                        </span>
                                        <span className="font-bold text-[#00B207] text-xl">
                                            {formatRupiah(total)}
                                        </span>
                                    </div>

                                    <Link
                                        href={route("checkout.index")}
                                        className="block w-full py-3.5 bg-[#00B207] text-white text-center rounded-full font-bold shadow-lg hover:bg-green-700 transition transform hover:-translate-y-1"
                                    >
                                        Checkout ({carts.length})
                                    </Link>

                                    <Link
                                        href={continueUrl}
                                        className="block text-center text-sm text-gray-500 mt-4 hover:text-[#00B207]"
                                    >
                                        Lanjut Belanja
                                    </Link>
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div className="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200">
                            <ShoppingBag className="w-16 h-16 text-gray-200 mx-auto mb-4" />
                            <h3 className="text-lg font-bold text-gray-900">
                                Keranjang Kosong
                            </h3>
                            <p className="text-gray-500 text-sm mt-1 mb-6">
                                Wah, keranjangmu masih sepi nih. Yuk isi dengan
                                produk segar!
                            </p>
                            <Link
                                href={continueUrl}
                                className="px-8 py-3 bg-[#00B207] text-white rounded-full font-bold hover:bg-green-700 transition"
                            >
                                Mulai Belanja
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </MainLayout>
    );
}
