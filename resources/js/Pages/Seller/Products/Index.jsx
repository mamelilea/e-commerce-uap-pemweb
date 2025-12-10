import React, { useState } from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Search, Plus, Package, Edit, Trash2, ImageIcon } from "lucide-react";

export default function Index({ products, filters }) {
    const [searchTerm, setSearchTerm] = useState(filters.search || "");

    const handleSearch = (e) => {
        if (e.key === "Enter") {
            router.get(
                route("seller.products.index"),
                { search: searchTerm },
                { preserveState: true }
            );
        }
    };

    const handleDelete = (id, name) => {
        if (confirm(`Yakin ingin menghapus produk "${name}"?`)) {
            router.delete(route("seller.products.destroy", id));
        }
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(number);
    };

    return (
        <SellerLayout title="Produk Saya">
            <Head title="Kelola Produk" />

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
                        placeholder="Cari nama produk..."
                    />
                </div>

                <Link
                    href={route("seller.products.create")}
                    className="flex items-center gap-2 px-5 py-2.5 bg-[#00B207] text-white rounded-lg font-bold text-sm hover:bg-green-700 transition shadow-md hover:shadow-lg shadow-green-100"
                >
                    <Plus className="w-5 h-5" />
                    Tambah Produk
                </Link>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">Produk</th>
                                <th className="px-6 py-4">Kategori</th>
                                <th className="px-6 py-4">Harga</th>
                                <th className="px-6 py-4">Stok</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {products.data.length > 0 ? (
                                products.data.map((product) => (
                                    <tr
                                        key={product.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-4">
                                                <div className="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                                    {product.product_images &&
                                                    product.product_images
                                                        .length > 0 ? (
                                                        <img
                                                            src={`/storage/${product.product_images[0].image}`}
                                                            alt={product.name}
                                                            className="w-full h-full object-cover"
                                                        />
                                                    ) : (
                                                        <ImageIcon className="w-5 h-5 text-gray-400" />
                                                    )}
                                                </div>
                                                <div>
                                                    <div className="font-bold text-[#1A1A1A] line-clamp-1">
                                                        {product.name}
                                                    </div>
                                                    <div className="text-xs text-gray-500">
                                                        SKU: {product.id}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {product.product_category?.name ||
                                                "-"}
                                        </td>
                                        <td className="px-6 py-4 font-bold text-[#00B207]">
                                            {formatRupiah(product.price)}
                                        </td>
                                        <td className="px-6 py-4">
                                            {product.stock > 0 ? (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                    {product.stock}
                                                </span>
                                            ) : (
                                                <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                    Habis
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex items-center justify-center gap-2">
                                                <Link
                                                    href={route(
                                                        "seller.products.edit",
                                                        product.id
                                                    )}
                                                    className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                    title="Edit"
                                                >
                                                    <Edit className="w-4 h-4" />
                                                </Link>
                                                <button
                                                    onClick={() =>
                                                        handleDelete(
                                                            product.id,
                                                            product.name
                                                        )
                                                    }
                                                    className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus"
                                                >
                                                    <Trash2 className="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="5">
                                        <div className="flex flex-col items-center justify-center py-16 text-center">
                                            <div className="bg-gray-50 p-4 rounded-full mb-3">
                                                <Package className="w-10 h-10 text-gray-300" />
                                            </div>
                                            <h4 className="text-gray-900 font-medium mb-1">
                                                Belum Ada Produk
                                            </h4>
                                            <p className="text-gray-500 text-sm mb-4">
                                                Mulai tambahkan produk jualanmu
                                                sekarang.
                                            </p>
                                            <Link
                                                href={route(
                                                    "seller.products.create"
                                                )}
                                                className="px-4 py-2 bg-[#00B207] text-white rounded-lg text-sm font-bold hover:bg-green-700"
                                            >
                                                Tambah Produk Pertama
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    Showing {products.from ?? 0} to {products.to ?? 0} of{" "}
                    {products.total ?? 0} entries
                    <div className="flex gap-2">
                        {products.links &&
                            products.links.map((link, index) =>
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
        </SellerLayout>
    );
}
