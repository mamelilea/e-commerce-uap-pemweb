import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link, usePage } from "@inertiajs/react";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm";
import { User, Lock, LogOut } from "lucide-react";

export default function Edit({ mustVerifyEmail, status }) {
    const { auth } = usePage().props;
    const [activeTab, setActiveTab] = useState("profile");

    return (
        <MainLayout title="Pengaturan Akun">
            <Head title="Pengaturan Akun" />

            <div className="py-12 bg-[#F9FBF9] min-h-screen">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="flex items-center gap-4 mb-8 px-4 sm:px-0">
                        <div className="p-3 bg-[#173B1A] rounded-2xl shadow-lg">
                            <User className="w-8 h-8 text-[#93FF00]" />
                        </div>
                        <div>
                            <h1 className="text-2xl font-bold text-[#173B1A]">
                                Pengaturan Akun
                            </h1>
                            <p className="text-gray-500">
                                Kelola informasi pribadi dan keamanan akunmu.
                            </p>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        <div className="lg:col-span-3">
                            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                                <div className="p-6 text-center border-b border-gray-50">
                                    <div className="w-20 h-20 bg-[#173B1A] text-[#93FF00] rounded-full mx-auto flex items-center justify-center text-3xl font-bold mb-3 border-4 border-[#e9ffcc]">
                                        {auth.user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <h3 className="font-bold text-gray-900 truncate">
                                        {auth.user.name}
                                    </h3>
                                    <p className="text-sm text-gray-400 truncate">
                                        {auth.user.email}
                                    </p>
                                </div>
                                <nav className="p-3 space-y-1">
                                    <button
                                        onClick={() => setActiveTab("profile")}
                                        className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all ${
                                            activeTab === "profile"
                                                ? "bg-[#173B1A] text-white shadow-md"
                                                : "text-gray-600 hover:bg-gray-50"
                                        }`}
                                    >
                                        <User className="w-5 h-5" />
                                        <span className="font-medium">
                                            Edit Profil
                                        </span>
                                    </button>
                                    <button
                                        onClick={() => setActiveTab("password")}
                                        className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all ${
                                            activeTab === "password"
                                                ? "bg-[#173B1A] text-white shadow-md"
                                                : "text-gray-600 hover:bg-gray-50"
                                        }`}
                                    >
                                        <Lock className="w-5 h-5" />
                                        <span className="font-medium">
                                            Kata Sandi
                                        </span>
                                    </button>
                                    <div className="border-t border-gray-100 my-2 pt-2">
                                        <Link
                                            href={route("logout")}
                                            method="post"
                                            as="button"
                                            className="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all"
                                        >
                                            <LogOut className="w-5 h-5" />
                                            <span className="font-medium">
                                                Keluar
                                            </span>
                                        </Link>
                                    </div>
                                </nav>
                            </div>
                        </div>

                        <div className="lg:col-span-9 space-y-6">
                            {activeTab === "profile" && (
                                <div className="bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                                    <div className="absolute top-0 right-0 w-32 h-32 bg-[#93FF00] opacity-10 rounded-bl-full pointer-events-none"></div>

                                    <div className="relative">
                                        <h2 className="text-lg font-bold text-[#173B1A] mb-1">
                                            Informasi Profil
                                        </h2>
                                        <p className="text-sm text-gray-500 mb-6">
                                            Perbarui detail profil dan alamat
                                            email akun Anda.
                                        </p>

                                        <UpdateProfileInformationForm
                                            mustVerifyEmail={mustVerifyEmail}
                                            status={status}
                                            className="max-w-xl"
                                        />
                                    </div>
                                </div>
                            )}

                            {activeTab === "password" && (
                                <div className="bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                                    <h2 className="text-lg font-bold text-[#173B1A] mb-1">
                                        Update Kata Sandi
                                    </h2>
                                    <p className="text-sm text-gray-500 mb-6">
                                        Pastikan akun Anda menggunakan kata
                                        sandi yang panjang dan acak agar tetap
                                        aman.
                                    </p>

                                    <UpdatePasswordForm className="max-w-xl" />
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
