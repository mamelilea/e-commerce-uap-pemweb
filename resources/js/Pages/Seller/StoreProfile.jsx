import React, { useState } from "react";
import SellerLayout from "@/Layouts/SellerLayout";
import { Head, useForm, usePage } from "@inertiajs/react";
import { Store, Upload, Save, MapPin, Phone, FileText } from "lucide-react";

export default function StoreProfile({ store }) {
    const initialLogo = store?.logo ? `/storage/${store.logo}` : null;
    const [logoPreview, setLogoPreview] = useState(initialLogo);

    const { data, setData, post, processing, errors } = useForm({
        name: store?.name || "",
        phone: store?.phone || "",
        about: store?.about || "",
        address: store?.address || "",
        city: store?.city || "",
        postal_code: store?.postal_code || "",
        logo: null,
    });

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData("logo", file);
            setLogoPreview(URL.createObjectURL(file));
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post(route("seller.store.update"));
    };

    return (
        <SellerLayout title="Profil Toko">
            <Head title="Profil Toko" />

            <form
                onSubmit={submit}
                className="grid grid-cols-1 lg:grid-cols-3 gap-8"
            >
                <div className="lg:col-span-1 space-y-6">
                    <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 className="font-bold text-[#1A1A1A] mb-4 flex items-center gap-2">
                            <Store className="w-5 h-5 text-[#00B207]" />
                            Identitas Toko
                        </h3>

                        <div className="mb-6 text-center">
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Logo Toko
                            </label>
                            <div className="relative w-20 h-20 mx-auto rounded-full border-2 border-dashed border-gray-300 hover:border-[#00B207] flex items-center justify-center overflow-hidden bg-gray-50 group cursor-pointer transition">
                                {logoPreview ? (
                                    <img
                                        src={logoPreview}
                                        alt="Logo Preview"
                                        className="w-full h-full object-cover"
                                    />
                                ) : (
                                    <Upload className="w-4 h-8 text-gray-400 group-hover:text-[#00B207]" />
                                )}
                                <input
                                    type="file"
                                    className="absolute inset-0 opacity-0 cursor-pointer"
                                    onChange={handleImageChange}
                                    accept="image/*"
                                />
                            </div>
                            <p className="text-xs text-gray-400 mt-2">
                                Klik untuk upload (Max 2MB)
                            </p>
                            {errors.logo && (
                                <div className="text-red-500 text-xs mt-1">
                                    {errors.logo}
                                </div>
                            )}
                        </div>

                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Nama Toko
                            </label>
                            <input
                                type="text"
                                value={data.name}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                                className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                placeholder="Contoh: Sayur Segar Pak Budi"
                            />
                            {errors.name && (
                                <div className="text-red-500 text-xs mt-1">
                                    {errors.name}
                                </div>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                                <FileText className="w-3 h-3" /> Deskripsi
                                Singkat
                            </label>
                            <textarea
                                rows="4"
                                value={data.about}
                                onChange={(e) =>
                                    setData("about", e.target.value)
                                }
                                className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                placeholder="Ceritakan sedikit tentang toko Anda..."
                            ></textarea>
                            {errors.about && (
                                <div className="text-red-500 text-xs mt-1">
                                    {errors.about}
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div className="lg:col-span-2 space-y-6">
                    <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 className="font-bold text-[#1A1A1A] mb-4 flex items-center gap-2">
                            <MapPin className="w-5 h-5 text-[#00B207]" />
                            Alamat & Kontak
                        </h3>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                                    <Phone className="w-3 h-3" /> Nomor Telepon
                                    / WA
                                </label>
                                <input
                                    type="text"
                                    value={data.phone}
                                    onChange={(e) =>
                                        setData("phone", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="0812xxxx"
                                />
                                {errors.phone && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.phone}
                                    </div>
                                )}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat Lengkap
                                </label>
                                <textarea
                                    rows="2"
                                    value={data.address}
                                    onChange={(e) =>
                                        setData("address", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="Jl. Mawar No. 10..."
                                ></textarea>
                                {errors.address && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.address}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Kota / Kabupaten
                                </label>
                                <input
                                    type="text"
                                    value={data.city}
                                    onChange={(e) =>
                                        setData("city", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="Jakarta Selatan"
                                />
                                {errors.city && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.city}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Kode Pos
                                </label>
                                <input
                                    type="text"
                                    value={data.postal_code}
                                    onChange={(e) =>
                                        setData("postal_code", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                    placeholder="12345"
                                />
                                {errors.postal_code && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.postal_code}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>

                    <div className="flex justify-end mt-6 pb-6">
                        {" "}
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-6 py-2.5 bg-[#00B207] text-white rounded-full font-bold text-sm hover:bg-green-700 transition shadow-md hover:shadow-lg shadow-green-100 flex items-center gap-2"
                        >
                            <Save className="w-4 h-4" />
                            {processing ? "Menyimpan..." : "Simpan Profil Toko"}
                        </button>
                    </div>
                </div>
            </form>
        </SellerLayout>
    );
}
