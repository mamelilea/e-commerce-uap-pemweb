import React from "react";
import { Head, useForm, Link } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import { Store, MapPin, Phone, Save } from "lucide-react";

export default function JoinSeller() {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        phone: "",
        address: "",
        city: "",
        postal_code: "",
        about: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post(route("join-seller.store"));
    };

    return (
        <MainLayout title="Daftar Jadi Seller">
            <div className="bg-[#F4F6F5] py-12 min-h-screen flex justify-center items-center">
                <div className="max-w-3xl w-full px-4">
                    <div className="text-center mb-10">
                        <h1 className="text-3xl font-bold font-poppins text-[#1A1A1A]">
                            Mulai Berjualan di FreshMart
                        </h1>
                        <p className="text-gray-500 mt-2">
                            Lengkapi data tokomu dan raih jutaan pembeli hari
                            ini.
                        </p>
                    </div>

                    <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <h3 className="text-lg font-bold text-[#1A1A1A] mb-4 flex items-center gap-2 border-b pb-2">
                                    <Store className="w-5 h-5 text-[#00B207]" />
                                    Identitas Toko
                                </h3>
                                <div className="grid grid-cols-1 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Toko
                                        </label>
                                        <input
                                            type="text"
                                            value={data.name}
                                            onChange={(e) =>
                                                setData("name", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Contoh: Sayur Segar Pak Budi"
                                        />
                                        {errors.name && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.name}
                                            </div>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Deskripsi Singkat
                                        </label>
                                        <textarea
                                            rows="3"
                                            value={data.about}
                                            onChange={(e) =>
                                                setData("about", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Ceritakan keunggulan tokomu..."
                                        ></textarea>
                                        {errors.about && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.about}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 className="text-lg font-bold text-[#1A1A1A] mb-4 flex items-center gap-2 border-b pb-2">
                                    <MapPin className="w-5 h-5 text-[#00B207]" />
                                    Alamat & Kontak
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="md:col-span-2">
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Nomor Telepon / WA
                                        </label>
                                        <input
                                            type="text"
                                            value={data.phone}
                                            onChange={(e) =>
                                                setData("phone", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
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
                                        <input
                                            type="text"
                                            value={data.address}
                                            onChange={(e) =>
                                                setData(
                                                    "address",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Nama Jalan, RT/RW, No. Rumah"
                                        />
                                        {errors.address && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.address}
                                            </div>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Kota
                                        </label>
                                        <input
                                            type="text"
                                            value={data.city}
                                            onChange={(e) =>
                                                setData("city", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
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
                                                setData(
                                                    "postal_code",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207]"
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

                            <div className="pt-4">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full py-4 bg-[#00B207] text-white rounded-full font-bold text-lg hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center justify-center gap-2"
                                >
                                    {processing
                                        ? "Mendaftarkan..."
                                        : "Daftar Sekarang"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
