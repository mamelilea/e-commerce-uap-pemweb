import React, { useRef } from "react";
import { useForm } from "@inertiajs/react";
import { Transition } from "@headlessui/react";
import { CheckCircle2 } from "lucide-react";

export default function UpdatePasswordForm({ className = "" }) {
    const passwordInput = useRef();
    const currentPasswordInput = useRef();

    const {
        data,
        setData,
        errors,
        put,
        reset,
        processing,
        recentlySuccessful,
    } = useForm({
        current_password: "",
        password: "",
        password_confirmation: "",
    });

    const updatePassword = (e) => {
        e.preventDefault();

        put(route("password.update"), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.password) {
                    reset("password", "password_confirmation");
                    passwordInput.current.focus();
                }

                if (errors.current_password) {
                    reset("current_password");
                    currentPasswordInput.current.focus();
                }
            },
        });
    };

    return (
        <section className={className}>
            <form onSubmit={updatePassword} className="space-y-6">
                <div>
                    <label
                        htmlFor="current_password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Kata Sandi Saat Ini
                    </label>
                    <input
                        id="current_password"
                        ref={currentPasswordInput}
                        value={data.current_password}
                        onChange={(e) =>
                            setData("current_password", e.target.value)
                        }
                        type="password"
                        className="w-full rounded-xl border-gray-300 focus:border-[#93FF00] focus:ring-[#93FF00] shadow-sm transition-colors py-2.5 px-4"
                        autoComplete="current-password"
                    />
                    {errors.current_password && (
                        <p className="mt-1 text-sm text-red-600">
                            {errors.current_password}
                        </p>
                    )}
                </div>

                <div>
                    <label
                        htmlFor="password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Kata Sandi Baru
                    </label>
                    <input
                        id="password"
                        ref={passwordInput}
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        type="password"
                        className="w-full rounded-xl border-gray-300 focus:border-[#93FF00] focus:ring-[#93FF00] shadow-sm transition-colors py-2.5 px-4"
                        autoComplete="new-password"
                    />
                    {errors.password && (
                        <p className="mt-1 text-sm text-red-600">
                            {errors.password}
                        </p>
                    )}
                </div>

                <div>
                    <label
                        htmlFor="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Konfirmasi Kata Sandi
                    </label>
                    <input
                        id="password_confirmation"
                        value={data.password_confirmation}
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        type="password"
                        className="w-full rounded-xl border-gray-300 focus:border-[#93FF00] focus:ring-[#93FF00] shadow-sm transition-colors py-2.5 px-4"
                        autoComplete="new-password"
                    />
                    {errors.password_confirmation && (
                        <p className="mt-1 text-sm text-red-600">
                            {errors.password_confirmation}
                        </p>
                    )}
                </div>

                <div className="flex items-center gap-4 pt-2">
                    <button
                        type="submit"
                        disabled={processing}
                        className="px-6 py-3 bg-[#173B1A] text-white font-bold rounded-full hover:bg-[#1f4d23] hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-[#93FF00] focus:ring-offset-2 disabled:opacity-50"
                    >
                        {processing ? "Menyimpan..." : "Update Password"}
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
