import { useEffect, useState } from "react";
import AuthLayout from "@/Layouts/AuthLayout";
import InputError from "@/Components/InputError";
import { Head, Link, useForm } from "@inertiajs/react";
import { Eye, EyeOff } from "lucide-react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "", 
        email: "",
        password: "",
        password_confirmation: "",
        terms: false,
    });

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route("register"));
    };

    return (
        <AuthLayout title="Create Account">
            <Head title="Register" />

            <form onSubmit={submit} className="space-y-6">
                <div>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        className="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#00B207] focus:ring-0 text-[#1A1A1A] placeholder-gray-400 transition"
                        placeholder="Full Name"
                        autoComplete="name"
                        required
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

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
                        required
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="relative">
                    <input
                        id="password"
                        type={showPassword ? "text" : "password"}
                        name="password"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        className="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#00B207] focus:ring-0 text-[#1A1A1A] placeholder-gray-400 transition pr-12"
                        placeholder="Password"
                        autoComplete="new-password"
                        required
                    />
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

                <div className="relative">
                    <input
                        id="password_confirmation"
                        type={showConfirmPassword ? "text" : "password"}
                        name="password_confirmation"
                        value={data.password_confirmation}
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        className="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#00B207] focus:ring-0 text-[#1A1A1A] placeholder-gray-400 transition pr-12"
                        placeholder="Confirm Password"
                        autoComplete="new-password"
                        required
                    />
                    <button
                        type="button"
                        onClick={() =>
                            setShowConfirmPassword(!showConfirmPassword)
                        }
                        className="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                    >
                        {showConfirmPassword ? (
                            <EyeOff className="w-5 h-5" />
                        ) : (
                            <Eye className="w-5 h-5" />
                        )}
                    </button>
                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="flex items-center">
                    <label className="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            name="terms"
                            checked={data.terms}
                            onChange={(e) => setData("terms", e.target.checked)}
                            className="rounded border-gray-300 text-[#00B207] focus:ring-[#00B207]"
                            required
                        />
                        <span className="ml-2 text-sm text-gray-500">
                            Accept all terms & Conditions
                        </span>
                    </label>
                </div>

                <div>
                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-[#00B207] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00B207] transition disabled:opacity-50 uppercase tracking-wider"
                    >
                        Create Account
                    </button>
                </div>

                <div className="text-center text-sm text-gray-500">
                    Already have account{" "}
                    <Link
                        href={route("login")}
                        className="font-bold text-[#1A1A1A] hover:text-[#00B207] transition"
                    >
                        Login
                    </Link>
                </div>
            </form>
        </AuthLayout>
    );
}
