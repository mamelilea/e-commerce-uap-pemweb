import React, { useState } from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, useForm, Link, router } from "@inertiajs/react";
import { Package, Save, ArrowLeft, Upload, X, Trash2 } from "lucide-react";

export default function Edit({ product, categories }) {
    const { data, setData, post, processing, errors } = useForm({
        name: product.name,
        product_category_id: product.product_category_id,
        price: product.price,
        stock: product.stock,
        weight: product.weight,
        condition: product.condition,
        description: product.description,
        images: [],
    });

    const [newImagePreviews, setNewImagePreviews] = useState([]);

    const handleImageChange = (e) => {
        const files = Array.from(e.target.files);
        setData("images", [...data.images, ...files]);

        const newPreviews = files.map((file) => URL.createObjectURL(file));
        setNewImagePreviews([...newImagePreviews, ...newPreviews]);
    };

    const removeNewImage = (index) => {
        const updatedImages = [...data.images];
        updatedImages.splice(index, 1);
        setData("images", updatedImages);

        const updatedPreviews = [...newImagePreviews];
        updatedPreviews.splice(index, 1);
        setNewImagePreviews(updatedPreviews);
    };

    const deleteExistingImage = (imageId) => {
        if (confirm("Hapus gambar ini?")) {
            router.delete(route("seller.products.image.destroy", imageId), {
                preserveScroll: true,
            });
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post(route("seller.products.update", product.id));
    };

    return (
        <SellerLayout title="Edit Produk">
            <Head title="Edit Produk" />

            <div className="flex items-center gap-4 mb-6">
                <Link
                    href={route("seller.products.index")}
                    className="p-2 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-600"
                >
                    <ArrowLeft className="w-5 h-5" />
                </Link>
                <div>
                    <h1 className="text-xl font-bold text-[#1A1A1A]">
                        Edit Produk
                    </h1>
                    <p className="text-sm text-gray-500">
                        Perbarui informasi produk Anda.
                    </p>
                </div>
            </div>

            <form
                onSubmit={submit}
                className="grid grid-cols-1 lg:grid-cols-3 gap-8"
            >
                <div className="lg:col-span-2 space-y-6">
                    <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 className="font-bold text-[#1A1A1A] mb-4 flex items-center gap-2">
                            <Package className="w-5 h-5 text-[#00B207]" />
                            Informasi Produk
                        </h3>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Nama Produk
                            </label>
                            <input
                                type="text"
                                value={data.name}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                                className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                            />
                            {errors.name && (
                                <div className="text-red-500 text-xs mt-1">
                                    {errors.name}
                                </div>
                            )}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Kategori
                            </label>
                            <select
                                value={data.product_category_id}
                                onChange={(e) =>
                                    setData(
                                        "product_category_id",
                                        e.target.value
                                    )
                                }
                                className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                            >
                                {categories.map((cat) => (
                                    <option key={cat.id} value={cat.id}>
                                        {cat.name}
                                    </option>
                                ))}
                            </select>
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Deskripsi Produk
                            </label>
                            <textarea
                                rows="6"
                                value={data.description}
                                onChange={(e) =>
                                    setData("description", e.target.value)
                                }
                                className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                            ></textarea>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Kondisi Produk
                            </label>
                            <div className="flex gap-4">
                                <label className="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="condition"
                                        value="new"
                                        checked={data.condition === "new"}
                                        onChange={(e) =>
                                            setData("condition", e.target.value)
                                        }
                                        className="text-[#00B207] focus:ring-[#00B207]"
                                    />
                                    <span className="text-sm">Baru (New)</span>
                                </label>
                                <label className="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="condition"
                                        value="second"
                                        checked={data.condition === "second"}
                                        onChange={(e) =>
                                            setData("condition", e.target.value)
                                        }
                                        className="text-[#00B207] focus:ring-[#00B207]"
                                    />
                                    <span className="text-sm">
                                        Bekas (Second)
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="lg:col-span-1 space-y-6">
                    <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 className="font-bold text-[#1A1A1A] mb-4">
                            Detail Penjualan
                        </h3>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Harga (Rp)
                                </label>
                                <input
                                    type="number"
                                    value={data.price}
                                    onChange={(e) =>
                                        setData("price", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Stok
                                </label>
                                <input
                                    type="number"
                                    value={data.stock}
                                    onChange={(e) =>
                                        setData("stock", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Berat (Gram)
                                </label>
                                <input
                                    type="number"
                                    value={data.weight}
                                    onChange={(e) =>
                                        setData("weight", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                />
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 className="font-bold text-[#1A1A1A] mb-4">
                            Foto Produk
                        </h3>

                        <div className="grid grid-cols-3 gap-2 mb-4">
                            {product.product_images.map((img) => (
                                <div
                                    key={img.id}
                                    className="relative w-full h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 group"
                                >
                                    <img
                                        src={`/storage/${img.image}`}
                                        alt="Product"
                                        className="w-full h-full object-cover"
                                    />
                                    <button
                                        type="button"
                                        onClick={() =>
                                            deleteExistingImage(img.id)
                                        }
                                        className="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition shadow-sm hover:bg-red-600"
                                        title="Hapus Gambar Ini"
                                    >
                                        <Trash2 className="w-3 h-3" />
                                    </button>
                                </div>
                            ))}

                            {newImagePreviews.map((src, index) => (
                                <div
                                    key={`new-${index}`}
                                    className="relative w-full h-20 bg-green-50 rounded-lg overflow-hidden border border-green-200 group"
                                >
                                    <img
                                        src={src}
                                        alt="Preview Baru"
                                        className="w-full h-full object-cover opacity-80"
                                    />
                                    <button
                                        type="button"
                                        onClick={() => removeNewImage(index)}
                                        className="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition"
                                    >
                                        <X className="w-3 h-3" />
                                    </button>
                                </div>
                            ))}

                            <label className="w-full h-20 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#00B207] hover:bg-green-50 transition">
                                <Upload className="w-5 h-5 text-gray-400" />
                                <span className="text-[10px] text-gray-500 mt-1">
                                    Add Img
                                </span>
                                <input
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    onChange={handleImageChange}
                                    className="hidden"
                                />
                            </label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full py-3 bg-[#00B207] text-white rounded-full font-bold text-sm hover:bg-green-700 transition shadow-md hover:shadow-lg shadow-green-100 flex items-center justify-center gap-2"
                    >
                        <Save className="w-4 h-4" />
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </SellerLayout>
    );
}
