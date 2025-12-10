import React from "react";
import Navbar from "@/Components/Navbar";
import Footer from "@/Components/Footer";
import { Head } from "@inertiajs/react";

export default function MainLayout({ children, title }) {
    return (
        <div className="min-h-screen flex flex-col bg-white font-sans text-gray-900">
            {title && <Head title={title} />}
            <Navbar />
            <main className="flex-grow">{children}</main>
            <Footer />
        </div>
    );
}
