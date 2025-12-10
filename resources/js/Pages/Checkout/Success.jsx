import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react";
import { CheckCircle, QrCode, ArrowRight } from "lucide-react";

export default function Success({ orderCode, paymentMethod }) {
    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PAY-FRESHMART-${orderCode}`;

    return (
        <MainLayout title="Pesanan Berhasil">
            <div className="min-h-[80vh] flex flex-col items-center justify-center bg-[#F4F6F5] py-20 px-4">
                <div className="bg-white p-8 md:p-12 rounded-3xl shadow-xl max-w-md w-full text-center relative overflow-hidden">
                    <div className="absolute top-0 left-0 w-full h-2 bg-[#00B207]"></div>

                    {paymentMethod === "qris" ? (
                        <div className="mb-6 flex flex-col items-center">
                            <h2 className="text-xl font-bold text-[#1A1A1A] mb-4">
                                Scan untuk Membayar
                            </h2>
                            <div className="p-4 bg-white border-2 border-dashed border-gray-300 rounded-xl mb-4">
                                <img
                                    src={qrUrl}
                                    alt="QRIS Code"
                                    className="w-48 h-48"
                                />
                            </div>
                            <p className="text-sm text-gray-500">
                                Buka aplikasi e-wallet Anda dan scan QR di atas.
                            </p>
                        </div>
                    ) : (
                        <div className="mb-6 flex justify-center">
                            <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <CheckCircle className="w-10 h-10 text-[#00B207]" />
                            </div>
                        </div>
                    )}

                    <h1 className="text-2xl font-bold text-[#1A1A1A] mb-2 font-poppins">
                        Pesanan Diterima!
                    </h1>

                    <p className="text-gray-500 mb-8">
                        Kode Order Group:{" "}
                        <span className="font-mono font-bold text-[#1A1A1A]">
                            {orderCode}
                        </span>
                        <br />
                        {paymentMethod === "cod"
                            ? "Silakan siapkan uang pas saat kurir datang."
                            : "Tunggu konfirmasi dari penjual setelah pembayaran."}
                    </p>

                    <Link
                        href={route("my-order")}
                        className="inline-flex items-center justify-center gap-2 w-full py-3.5 bg-[#1A1A1A] text-white rounded-full font-bold hover:bg-[#00B207] transition"
                    >
                        Cek Status Pesanan <ArrowRight className="w-4 h-4" />
                    </Link>
                </div>
            </div>
        </MainLayout>
    );
}
