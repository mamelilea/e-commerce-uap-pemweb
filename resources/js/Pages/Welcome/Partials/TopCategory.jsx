import React from "react";
import SectionTitle from "./SectionTitle";

export default function TopCategory({ categories, handleAccess }) {
    return (
        <section className="py-20 bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <SectionTitle title="Top Category" />

                <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                    {categories.length > 0 ? (
                        categories.map((cat, index) => (
                            <div
                                key={index}
                                onClick={(e) =>
                                    handleAccess(
                                        e,
                                        route("products.list", {
                                            category: cat.slug,
                                        })
                                    )
                                }
                                className="bg-gray-50 rounded-xl p-6 text-center hover:bg-white hover:shadow-lg hover:border hover:border-[#00B207] hover:-translate-y-1 transition duration-300 cursor-pointer border border-transparent"
                            >
                                <div className="h-20 mb-4 flex items-center justify-center">
                                    <img
                                        src={`/${cat.image}`}
                                        alt={cat.name}
                                        className="h-full object-contain"
                                    />
                                </div>
                                <h3 className="font-semibold text-lg text-[#1A1A1A]">
                                    {cat.name}
                                </h3>

                                <p className="text-gray-400 text-xs mt-1">
                                    {cat.products_count} Products
                                </p>
                            </div>
                        ))
                    ) : (
                        <div className="col-span-4 text-center text-gray-400">
                            Kategori belum tersedia.
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}
