import { useEffect, useState } from "react";
import AuthLayout from "@/Layouts/AuthLayout";
import InputError from "@/Components/InputError";
import { Head, Link, useForm } from "@inertiajs/react";
import { Eye, EyeOff } from "lucide-react"; // Import icon mata

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    // State untuk show/hide password
    const [showPassword, setShowPassword] = useState(false);

    useEffect(() => {
        return () => {
            reset("password");
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route("login"));
    };

    return (
        <AuthLayout title="Sign In">
            <Head title="Log in" />

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-6">
                {/* Email Field */}
                <div>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        className="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#00B207] focus:ring-0 text-[#1A1A1A] placeholder-gray-400 transition"
                        placeholder="Email"
                        autoComplete="username"
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>

                {/* Password Field dengan Toggle Eye */}
                <div className="relative">
                    <input
                        id="password"
                        type={showPassword ? "text" : "password"}
                        name="password"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        className="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#00B207] focus:ring-0 text-[#1A1A1A] placeholder-gray-400 transition pr-12"
                        placeholder="Password"
                        autoComplete="current-password"
                    />
                    {/* Tombol Mata */}
                    <button
                        type="button"
                        onClick={() => setShowPassword(!showPassword)}
                        className="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                    >
                        {showPassword ? (
                            <EyeOff className="w-5 h-5" />
                        ) : (
                            <Eye className="w-5 h-5" />
                        )}
                    </button>
                    <InputError message={errors.password} className="mt-2" />
                </div>

                {/* Remember Me & Forgot Password */}
                <div className="flex items-center justify-between">
                    <label className="flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData("remember", e.target.checked)
                            }
                            className="rounded border-gray-300 text-[#00B207] focus:ring-[#00B207]"
                        />
                        <span className="ml-2 text-sm text-gray-500">
                            Remember me
                        </span>
                    </label>

                    {canResetPassword && (
                        <Link
                            href={route("password.request")}
                            className="text-sm text-gray-500 hover:text-[#00B207] transition"
                        >
                            Forget Password
                        </Link>
                    )}
                </div>

                {/* Login Button */}
                <div>
                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-[#00B207] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00B207] transition disabled:opacity-50 uppercase tracking-wider"
                    >
                        Login
                    </button>
                </div>

                {/* Footer Link */}
                <div className="text-center text-sm text-gray-500">
                    Don't have account?{" "}
                    <Link
                        href={route("register")}
                        className="font-bold text-[#1A1A1A] hover:text-[#00B207] transition"
                    >
                        Register
                    </Link>
                </div>
            </form>
        </AuthLayout>
    );
}
