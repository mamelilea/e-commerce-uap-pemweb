import React from "react";

export default function SectionTitle({ title }) {
    return (
        <div className="text-center mb-10">
            <h2 className="text-3xl font-bold font-poppins text-[#1A1A1A] mb-2">
                {title}
            </h2>
            <div className="flex items-center justify-center gap-1.5">
                <span className="w-3 h-1 rounded-full bg-[#00B207] opacity-30"></span>
                <span className="w-12 h-1 rounded-full bg-[#00B207]"></span>
                <span className="w-3 h-1 rounded-full bg-[#00B207] opacity-30"></span>
            </div>
        </div>
    );
}
