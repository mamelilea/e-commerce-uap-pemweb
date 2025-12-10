import React from "react";
import { useForm, usePage, Link } from "@inertiajs/react";
import { Transition } from "@headlessui/react";
import { CheckCircle2 } from "lucide-react";

export default function UpdateProfileInformationForm({
    mustVerifyEmail,
    status,
    className = "",
}) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } =
        useForm({
            name: user.name,
            email: user.email,
        });

    const submit = (e) => {
        e.preventDefault();
        patch(route("profile.update"));
    };

    return (
        <section className={className}>
            <form onSubmit={submit} className="space-y-6">
                <div>
                    <label
                        htmlFor="name"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Nama Lengkap
                    </label>
                    <input
                        id="name"
                        className="w-full rounded-xl border-gray-300 focus:border-[#93FF00] focus:ring-[#93FF00] shadow-sm transition-colors py-2.5 px-4"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        required
                        autoComplete="name"
                    />
                    {errors.name && (
                        <p className="mt-1 text-sm text-red-600">
                            {errors.name}
                        </p>
                    )}
                </div>

                <div>
                    <label
                        htmlFor="email"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        className="w-full rounded-xl border-gray-300 focus:border-[#93FF00] focus:ring-[#93FF00] shadow-sm transition-colors py-2.5 px-4"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        required
                        autoComplete="username"
                    />
                    {errors.email && (
                        <p className="mt-1 text-sm text-red-600">
                            {errors.email}
                        </p>
                    )}

                    {mustVerifyEmail && user.email_verified_at === null && (
                        <div className="mt-2 bg-orange-50 p-3 rounded-lg border border-orange-100">
                            <p className="text-sm text-gray-800">
                                Alamat email Anda belum diverifikasi.
                                <Link
                                    href={route("verification.send")}
                                    method="post"
                                    as="button"
                                    className="ml-1 underline text-sm text-orange-600 hover:text-orange-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                                >
                                    Klik di sini untuk mengirim ulang email
                                    verifikasi.
                                </Link>
                            </p>

                            {status === "verification-link-sent" && (
                                <div className="mt-2 font-medium text-sm text-green-600">
                                    Tautan verifikasi baru telah dikirim ke
                                    alamat email Anda.
                                </div>
                            )}
                        </div>
                    )}
                </div>

                <div className="flex items-center gap-4 pt-2">
                    <button
                        type="submit"
                        disabled={processing}
                        className="px-6 py-3 bg-[#173B1A] text-white font-bold rounded-full hover:bg-[#1f4d23] hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-[#93FF00] focus:ring-offset-2 disabled:opacity-50"
                    >
                        {processing ? "Menyimpan..." : "Simpan Perubahan"}
                    </button>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-green-600 flex items-center gap-2">
                            <CheckCircle2 className="w-4 h-4" /> Tersimpan.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
