import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link, router, usePage, useForm } from "@inertiajs/react";
import {
    Star,
    Heart,
    Share2,
    ShoppingBag,
    Minus,
    Plus,
    ChevronLeft,
    ChevronRight,
    Store,
    MapPin,
    ImageIcon,
} from "lucide-react";

export default function Detail({
    product,
    storeRating,
    relatedProducts,
    canReview,
}) {
    const { auth } = usePage().props;

    const [currentImageIndex, setCurrentImageIndex] = useState(0);
    const [quantity, setQuantity] = useState(1);

    const { data, setData, post, processing, reset, errors } = useForm({
        product_id: product.id,
        rating: 5,
        review: "",
    });

    const images =
        product.product_images.length > 0
            ? product.product_images
            : [{ image: null }];

    const formatRupiah = (num) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(num);
    const formatDate = (date) =>
        new Date(date).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });

    const handleNextImage = () => {
        setCurrentImageIndex((prev) =>
            prev === images.length - 1 ? 0 : prev + 1
        );
    };

    const handlePrevImage = () => {
        setCurrentImageIndex((prev) =>
            prev === 0 ? images.length - 1 : prev - 1
        );
    };

    const handleQuantity = (type) => {
        if (type === "plus" && quantity < product.stock)
            setQuantity(quantity + 1);
        if (type === "minus" && quantity > 1) setQuantity(quantity - 1);
    };

    const handleBuy = () => {
        if (!auth.user) return router.visit(route("login"));

        router.post(route("cart.store"), {
            product_id: product.id,
            qty: quantity,
        });
    };

    const submitReview = (e) => {
        e.preventDefault();
        post(route("reviews.store"), {
            onSuccess: () => router.reload({ only: ['product'] }),
            preserveScroll: true,
        });
    };

    return (
        <MainLayout title={product.name}>
            <Head title={product.name} />

            <div className="bg-[#F4F6F5] py-4">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-gray-500 flex items-center gap-2">
                    <Link href="/" className="hover:text-[#00B207]">
                        Home
                    </Link>
                    <span>/</span>
                    <Link
                        href={route("products.list")}
                        className="hover:text-[#00B207]"
                    >
                        Category
                    </Link>
                    <span>/</span>
                    <span className="text-[#00B207] font-medium truncate max-w-[200px]">
                        {product.name}
                    </span>
                </div>
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                    <div className="relative">
                        <div className="aspect-square bg-white rounded-2xl border border-gray-100 flex items-center justify-center overflow-hidden relative group">
                            {images[currentImageIndex].image ? (
                                <img
                                    src={`/storage/${images[currentImageIndex].image}`}
                                    alt={product.name}
                                    className="w-full h-full object-contain p-4 transition-transform duration-500 hover:scale-110"
                                />
                            ) : (
                                <div className="text-gray-300">
                                    No Image Available
                                </div>
                            )}

                            {images.length > 1 && (
                                <>
                                    <button
                                        onClick={handlePrevImage}
                                        className="absolute left-4 p-2 rounded-full bg-white shadow-md hover:bg-[#00B207] hover:text-white transition opacity-0 group-hover:opacity-100"
                                    >
                                        <ChevronLeft className="w-6 h-6" />
                                    </button>
                                    <button
                                        onClick={handleNextImage}
                                        className="absolute right-4 p-2 rounded-full bg-white shadow-md hover:bg-[#00B207] hover:text-white transition opacity-0 group-hover:opacity-100"
                                    >
                                        <ChevronRight className="w-6 h-6" />
                                    </button>
                                </>
                            )}
                        </div>

                        {images.length > 1 && (
                            <div className="flex gap-4 mt-4 overflow-x-auto pb-2">
                                {images.map((img, idx) => (
                                    <button
                                        key={idx}
                                        onClick={() =>
                                            setCurrentImageIndex(idx)
                                        }
                                        className={`w-20 h-20 rounded-lg border-2 flex-shrink-0 overflow-hidden ${
                                            currentImageIndex === idx
                                                ? "border-[#00B207]"
                                                : "border-transparent"
                                        }`}
                                    >
                                        <img
                                            src={`/storage/${img.image}`}
                                            className="w-full h-full object-cover"
                                        />
                                    </button>
                                ))}
                            </div>
                        )}
                    </div>

                    <div>
                        <h1 className="text-3xl lg:text-4xl font-bold text-[#1A1A1A] font-poppins mb-2">
                            {product.name}
                        </h1>

                        <div className="flex items-center gap-4 text-sm mb-6 border-b border-gray-100 pb-6">
                            <div className="flex items-center gap-1 text-yellow-400">
                                {[...Array(5)].map((_, i) => (
                                    <Star
                                        key={i}
                                        className={`w-4 h-4 ${
                                            i <
                                            Math.round(
                                                product.product_reviews_avg_rating
                                            )
                                                ? "fill-current"
                                                : "text-gray-300"
                                        }`}
                                    />
                                ))}
                                <span className="text-[#1A1A1A] ml-2 font-medium">
                                    {product.product_reviews_count} Reviews
                                </span>
                            </div>
                            <span className="text-gray-300">|</span>
                            <span className="text-gray-600">
                                Sold:{" "}
                                <strong className="text-[#1A1A1A]">
                                    {product.transaction_details_sum_qty || 0}
                                </strong>
                            </span>
                            <span className="text-gray-300">|</span>
                            <span
                                className={`font-medium ${
                                    product.stock > 0
                                        ? "text-[#00B207]"
                                        : "text-red-500"
                                }`}
                            >
                                {product.stock > 0
                                    ? `In Stock (${product.stock})`
                                    : "Out of Stock"}
                            </span>
                        </div>

                        <div className="flex items-center justify-between mb-6">
                            <div className="text-3xl font-bold text-[#00B207]">
                                {formatRupiah(product.price)}
                            </div>
                            <div className="flex items-center gap-4">
                                <button className="p-2 rounded-full bg-gray-50 hover:bg-[#00B207] hover:text-white transition text-[#1A1A1A]">
                                    <Share2 className="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <div className="mb-8">
                            <h3 className="font-bold text-[#1A1A1A] mb-2">
                                Description
                            </h3>
                            <p className="text-gray-500 leading-relaxed text-sm whitespace-pre-line">
                                {product.description}
                            </p>
                        </div>

                        <div className="flex flex-col sm:flex-row gap-4 mb-8">
                            <div className="flex items-center border border-gray-200 rounded-full px-4 py-2 w-max">
                                <button
                                    onClick={() => handleQuantity("minus")}
                                    className="p-1 hover:text-[#00B207]"
                                >
                                    <Minus className="w-4 h-4" />
                                </button>
                                <span className="mx-4 font-bold text-[#1A1A1A] w-4 text-center">
                                    {quantity}
                                </span>
                                <button
                                    onClick={() => handleQuantity("plus")}
                                    className="p-1 hover:text-[#00B207]"
                                >
                                    <Plus className="w-4 h-4" />
                                </button>
                            </div>

                            <button
                                onClick={handleBuy}
                                disabled={product.stock < 1}
                                className="flex-1 bg-[#00B207] text-white py-3 rounded-full font-bold shadow-lg hover:bg-green-700 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <ShoppingBag className="w-5 h-5" />
                                {product.stock > 0 ? "Buy Now" : "Out of Stock"}
                            </button>

                            <button className="px-5 py-3 rounded-full border border-gray-200 bg-green-50 text-[#00B207] hover:bg-green-100 transition">
                                <Heart className="w-5 h-5" />
                            </button>
                        </div>

                        <div className="text-xs text-gray-500">
                            Category:{" "}
                            <span className="text-[#1A1A1A] font-medium">
                                {product.product_category?.name}
                            </span>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-12 border-t border-gray-100 pt-10">
                    <div className="lg:col-span-1">
                        <div className="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <div className="flex items-center gap-4 mb-4">
                                <div className="w-14 h-14 rounded-full bg-gray-100 overflow-hidden border border-gray-200">
                                    {product.store.logo ? (
                                        <img
                                            src={`/storage/${product.store.logo}`}
                                            alt={product.store.name}
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <Store className="w-full h-full p-3 text-gray-400" />
                                    )}
                                </div>
                                <div>
                                    <h4 className="font-bold text-[#1A1A1A] text-lg">
                                        {product.store.name}
                                    </h4>
                                    <div className="flex items-center gap-1 text-yellow-400 text-sm">
                                        <Star className="w-3 h-3 fill-current" />
                                        <span className="text-gray-600 font-medium">
                                            {storeRating} Rating
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p className="text-sm text-gray-500 mb-4 line-clamp-3">
                                {product.store.about ||
                                    "Toko ini menjual produk segar berkualitas tinggi langsung dari petani terpercaya."}
                            </p>

                            <div className="flex items-center gap-2 text-xs text-gray-400 mb-4">
                                <MapPin className="w-3 h-3" />
                                {product.store.city}
                            </div>

                            <Link
                                href={route("store.show", product.store.name)}
                                className="text-center w-full py-2 border border-[#00B207] text-[#00B207] rounded-full font-bold text-sm hover:bg-[#00B207] hover:text-white transition block"
                            >
                                Visit Store
                            </Link>
                        </div>
                    </div>

                    <div className="lg:col-span-2">
                        <h3 className="text-xl font-bold text-[#1A1A1A] mb-6 font-poppins">
                            Customer Reviews
                        </h3>

                        {canReview && (
                            <div className="bg-gray-50 p-6 rounded-xl border border-gray-100 mb-8">
                                <h4 className="font-bold text-[#1A1A1A] mb-4">
                                    Tulis Ulasan Anda
                                </h4>
                                <form onSubmit={submitReview}>
                                    <div className="mb-4">
                                        <label className="block text-xs font-medium text-gray-500 mb-2">
                                            Rating
                                        </label>
                                        <div className="flex gap-2">
                                            {[1, 2, 3, 4, 5].map((star) => (
                                                <button
                                                    key={star}
                                                    type="button"
                                                    onClick={() =>
                                                        setData("rating", star)
                                                    }
                                                    className={`transition hover:scale-110 ${
                                                        data.rating >= star
                                                            ? "text-yellow-400"
                                                            : "text-gray-300"
                                                    }`}
                                                >
                                                    <Star className="w-6 h-6 fill-current" />
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                    <div className="mb-4">
                                        <label className="block text-xs font-medium text-gray-500 mb-2">
                                            Ulasan
                                        </label>
                                        <textarea
                                            rows="3"
                                            value={data.review}
                                            onChange={(e) =>
                                                setData(
                                                    "review",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:ring-[#00B207] focus:border-[#00B207]"
                                            placeholder="Bagaimana kualitas produk ini?"
                                        ></textarea>
                                        {errors.review && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.review}
                                            </div>
                                        )}
                                    </div>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="px-6 py-2 bg-[#00B207] text-white rounded-full text-sm font-bold hover:bg-green-700 transition shadow-md"
                                    >
                                        {processing
                                            ? "Mengirim..."
                                            : "Kirim Ulasan"}
                                    </button>
                                </form>
                            </div>
                        )}

                        {product.product_reviews.length > 0 ? (
                            <div className="space-y-6">
                                {product.product_reviews.map((review) => (
                                    <div
                                        key={review.id}
                                        className="border-b border-gray-50 pb-6 last:border-none"
                                    >
                                        <div className="flex justify-between items-start mb-2">
                                            <div className="flex items-center gap-3">
                                                <div className="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500 overflow-hidden">
                                                    {review.user?.avatar ? (
                                                        <img
                                                            src={
                                                                review.user
                                                                    .avatar
                                                            }
                                                            className="w-full h-full object-cover"
                                                        />
                                                    ) : (
                                                        review.user?.name
                                                            .charAt(0)
                                                            .toUpperCase()
                                                    )}
                                                </div>
                                                <div>
                                                    <h5 className="font-bold text-[#1A1A1A] text-sm">
                                                        {review.user?.name}
                                                    </h5>
                                                    <div className="flex text-yellow-400">
                                                        {[...Array(5)].map(
                                                            (_, i) => (
                                                                <Star
                                                                    key={i}
                                                                    className={`w-3 h-3 ${
                                                                        i <
                                                                        review.rating
                                                                            ? "fill-current"
                                                                            : "text-gray-200"
                                                                    }`}
                                                                />
                                                            )
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            <span className="text-xs text-gray-400">
                                                {formatDate(review.created_at)}
                                            </span>
                                        </div>
                                        <p className="text-gray-600 text-sm leading-relaxed mt-2 pl-12">
                                            {review.review}
                                        </p>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p className="text-gray-400">
                                    Belum ada ulasan untuk produk ini.
                                </p>
                            </div>
                        )}
                    </div>
                </div>

                {relatedProducts.length > 0 && (
                    <div className="mt-16 border-t border-gray-100 pt-10">
                        <h3 className="text-2xl font-bold text-[#1A1A1A] font-poppins mb-6 text-center">
                            Related Products
                        </h3>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                            {relatedProducts.map((item) => (
                                <Link
                                    key={item.id}
                                    href={route("product.detail", item.slug)}
                                    className="group bg-white border border-gray-100 rounded-xl p-4 hover:border-[#00B207] hover:shadow-lg transition flex flex-col h-full"
                                >
                                    <div className="aspect-square bg-gray-50 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                                        {item.product_images &&
                                        item.product_images.length > 0 ? (
                                            <img
                                                src={`/storage/${item.product_images[0].image}`}
                                                className="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform"
                                            />
                                        ) : (
                                            <ImageIcon className="w-12 h-12 text-gray-300" />
                                        )}
                                    </div>
                                    <h3 className="font-medium text-[#1A1A1A] group-hover:text-[#00B207] line-clamp-1 mb-1">
                                        {item.name}
                                    </h3>
                                    <p className="font-bold text-[#1A1A1A]">
                                        {formatRupiah(item.price)}
                                    </p>
                                </Link>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </MainLayout>
    );
}