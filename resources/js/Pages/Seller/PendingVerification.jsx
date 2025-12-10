import React from "react";
import { Head, Link } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import { Clock, CheckCircle, ArrowLeft } from "lucide-react";

export default function PendingVerification() {
    return (
        <MainLayout title="Menunggu Verifikasi">
            <div className="min-h-[85vh] flex flex-col items-center justify-center bg-[#F4F6F5] px-4 py-20">
                <div className="p-10 md:p-12 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 max-w-lg w-full text-center relative overflow-hidden">

                    <div className="mb-8 inline-flex items-center justify-center w-24 h-24 bg-orange-50 rounded-full">
                        <Clock className="w-10 h-10 text-orange-500 animate-pulse" />
                    </div>

                    <h1 className="text-2xl font-bold text-[#1A1A1A] mb-4 font-poppins">
                        Verifikasi Sedang Diproses
                    </h1>

                    <p className="text-gray-500 mb-10 leading-relaxed text-sm">
                        Terima kasih telah mendaftar sebagai Seller di{" "}
                        <strong>FreshMart</strong>. Tim Admin kami sedang
                        meninjau data toko Anda. Proses ini biasanya memakan
                        waktu <strong>1x24 jam</strong>.
                    </p>

                    <div className="space-y-4 mb-10">
                        <div className="bg-gray-50 p-4 rounded-xl text-left flex gap-4 items-start border border-gray-100">
                            <div className="mt-0.5">
                                <CheckCircle className="w-5 h-5 text-green-500" />
                            </div>
                            <div>
                                <h4 className="font-bold text-sm text-[#1A1A1A]">
                                    Data Toko Terkirim
                                </h4>
                                <p className="text-xs text-gray-500 mt-0.5">
                                    Data Anda aman dan sedang dalam antrean
                                    verifikasi.
                                </p>
                            </div>
                        </div>

                        <div className="bg-gray-50 p-4 rounded-xl text-left flex gap-4 items-start border border-gray-100">
                            <div className="mt-0.5">
                                <CheckCircle className="w-5 h-5 text-gray-300" />
                            </div>
                            <div>
                                <h4 className="font-bold text-sm text-gray-400">
                                    Persetujuan Admin
                                </h4>
                                <p className="text-xs text-gray-400 mt-0.5">
                                    Anda akan mendapatkan akses dashboard penuh
                                    setelah disetujui.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <Link
                            href="/"
                            className="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#1A1A1A] text-white rounded-full font-bold text-sm hover:bg-[#00B207] transition-all duration-300 shadow-lg hover:shadow-green-200 w-full"
                        >
                            <ArrowLeft className="w-4 h-4" />
                            Kembali Belanja Dulu
                        </Link>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
