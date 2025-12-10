import React from "react";
import { Link } from "@inertiajs/react";

export default function AuthLayout({ children, title }) {
    return (
        <div className="min-h-screen flex flex-col justify-center items-center bg-[#F4F6F5] py-12 sm:px-6 lg:px-8 font-sans">
            <div className="sm:mx-auto sm:w-full sm:max-w-[480px]">
                <div className="bg-white py-10 px-6 shadow-[0px_8px_40px_rgba(0,0,0,0.08)] rounded-2xl sm:px-12 border border-gray-100">
                    <h2 className="text-center text-3xl font-bold text-[#1A1A1A] font-poppins mb-8">
                        {title}
                    </h2>

                    {children}
                </div>
            </div>
        </div>
    );
}
