import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Head, useForm } from "@inertiajs/react";
import { MapPin, Truck, CreditCard, Store, CheckCircle } from "lucide-react";

export default function Index({ groupedItems, cartTotal, user }) {
    const { data, setData, post, processing, errors } = useForm({
        name: user.name,
        email: user.email,
        phone: user.phone_number || "",
        address: "",
        city: "",
        postal_code: "",
        note: "",
        courier: "JNE Regular|15000",
        payment_method: "cod",
        data_correct: false,
    });

    const couriers = [
        {
            id: "JNE Regular|15000",
            name: "JNE Regular",
            cost: 15000,
            etd: "3-5 Hari",
        },
        {
            id: "JNE Express|25000",
            name: "JNE Express",
            cost: 25000,
            etd: "1-2 Hari",
        },
        {
            id: "Sicepat Halu|10000",
            name: "Sicepat Halu",
            cost: 10000,
            etd: "5-7 Hari",
        },
    ];

    const payments = [
        { id: "qris", name: "QRIS (Instant)", icon: "📱" },
        { id: "va", name: "Bank Transfer (VA)", icon: "🏦" },
        { id: "cod", name: "Cash On Delivery (COD)", icon: "💵" },
    ];

    const formatRupiah = (num) =>
        new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(num);

    const selectedCourierCost = parseInt(data.courier.split("|")[1]);
    const totalShipping = selectedCourierCost * groupedItems.length;
    const tax = cartTotal * 0.11;
    const grandTotal = cartTotal + tax + totalShipping;

    const submit = (e) => {
        e.preventDefault();
        if (!data.data_correct) {
            alert("Mohon centang 'Data benar' sebelum melanjutkan.");
            return;
        }
        post(route("checkout.store"));
    };

    return (
        <MainLayout title="Checkout">
            <Head title="Checkout" />

            <div className="bg-white min-h-screen py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 className="text-2xl font-bold text-[#1A1A1A] mb-8 font-poppins flex items-center gap-2">
                        <CheckCircle className="w-6 h-6 text-[#00B207]" />
                        Penyelesaian Pesanan
                    </h1>

                    <form
                        onSubmit={submit}
                        className="flex flex-col lg:flex-row gap-8"
                    >
                        <div className="flex-1 space-y-6">
                            <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 className="font-bold text-lg text-[#1A1A1A] mb-4 flex items-center gap-2">
                                    <MapPin className="w-5 h-5 text-[#00B207]" />{" "}
                                    Alamat Pengiriman
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="md:col-span-2">
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Nama Penerima
                                        </label>
                                        <input
                                            type="text"
                                            value={data.name}
                                            onChange={(e) =>
                                                setData("name", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Masukkan nama"
                                        />
                                    </div>
                                    <div className="md:col-span-2">
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Alamat Lengkap
                                        </label>
                                        <input
                                            type="text"
                                            value={data.address}
                                            onChange={(e) =>
                                                setData(
                                                    "address",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Nama Jalan, No. Rumah, RT/RW"
                                        />
                                        {errors.address && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.address}
                                            </div>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Kota
                                        </label>
                                        <input
                                            type="text"
                                            value={data.city}
                                            onChange={(e) =>
                                                setData("city", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="Jakarta Selatan"
                                        />
                                        {errors.city && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.city}
                                            </div>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Kode Pos
                                        </label>
                                        <input
                                            type="text"
                                            value={data.postal_code}
                                            onChange={(e) =>
                                                setData(
                                                    "postal_code",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="12345"
                                        />
                                        {errors.postal_code && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.postal_code}
                                            </div>
                                        )}
                                    </div>
                                    <div className="md:col-span-2">
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Nomor Handphone
                                        </label>
                                        <input
                                            type="text"
                                            value={data.phone}
                                            onChange={(e) =>
                                                setData("phone", e.target.value)
                                            }
                                            className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                            placeholder="0812xxxx"
                                        />
                                        {errors.phone && (
                                            <div className="text-red-500 text-xs mt-1">
                                                {errors.phone}
                                            </div>
                                        )}
                                    </div>
                                    <div className="md:col-span-2">
                                        <label className="block text-xs font-bold text-gray-500 mb-1">
                                            Email
                                        </label>
                                        <input
                                            type="email"
                                            value={data.email}
                                            readOnly
                                            className="w-full rounded-lg border-gray-300 text-sm bg-gray-100 text-gray-500"
                                        />
                                    </div>
                                </div>
                                <div className="mt-4 flex items-center">
                                    <input
                                        id="data-correct"
                                        type="checkbox"
                                        checked={data.data_correct}
                                        onChange={(e) =>
                                            setData(
                                                "data_correct",
                                                e.target.checked
                                            )
                                        }
                                        className="h-4 w-4 text-[#00B207] focus:ring-[#00B207] border-gray-300 rounded"
                                    />
                                    <label
                                        htmlFor="data-correct"
                                        className="ml-2 block text-sm text-gray-700"
                                    >
                                        Data yang saya masukkan sudah benar
                                    </label>
                                </div>
                            </div>

                            <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 className="font-bold text-lg text-[#1A1A1A] mb-4">
                                    Informasi Tambahan
                                </h3>
                                <label className="block text-xs font-bold text-gray-500 mb-2">
                                    Catatan (Optional)
                                </label>
                                <textarea
                                    rows="3"
                                    value={data.note}
                                    onChange={(e) =>
                                        setData("note", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 text-sm focus:border-[#00B207] focus:ring-[#00B207]"
                                    placeholder="Catatan untuk penjual atau kurir"
                                ></textarea>
                            </div>

                            <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 className="font-bold text-lg text-[#1A1A1A] mb-4 flex items-center gap-2">
                                    <Truck className="w-5 h-5 text-[#00B207]" />{" "}
                                    Opsi Pengiriman
                                </h3>
                                <div className="space-y-3">
                                    {couriers.map((courier) => (
                                        <label
                                            key={courier.id}
                                            className={`flex items-center justify-between p-4 border rounded-xl cursor-pointer transition ${
                                                data.courier === courier.id
                                                    ? "border-[#00B207] bg-green-50"
                                                    : "border-gray-200 hover:border-gray-300"
                                            }`}
                                        >
                                            <div className="flex items-center gap-3">
                                                <input
                                                    type="radio"
                                                    name="courier"
                                                    value={courier.id}
                                                    checked={
                                                        data.courier ===
                                                        courier.id
                                                    }
                                                    onChange={(e) =>
                                                        setData(
                                                            "courier",
                                                            e.target.value
                                                        )
                                                    }
                                                    className="text-[#00B207] focus:ring-[#00B207]"
                                                />
                                                <div>
                                                    <div className="font-bold text-[#1A1A1A] text-sm">
                                                        {courier.name}
                                                    </div>
                                                    <div className="text-xs text-gray-500">
                                                        Estimasi: {courier.etd}
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="font-bold text-[#1A1A1A] text-sm">
                                                {formatRupiah(courier.cost)}
                                            </div>
                                        </label>
                                    ))}
                                </div>
                            </div>

                            <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 className="font-bold text-lg text-[#1A1A1A] mb-4 flex items-center gap-2">
                                    <CreditCard className="w-5 h-5 text-[#00B207]" />{" "}
                                    Metode Pembayaran
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    {payments.map((pay) => (
                                        <label
                                            key={pay.id}
                                            className={`flex flex-col items-center justify-center p-4 border rounded-xl cursor-pointer transition text-center h-24 ${
                                                data.payment_method === pay.id
                                                    ? "border-[#00B207] bg-green-50"
                                                    : "border-gray-200 hover:border-gray-300"
                                            }`}
                                        >
                                            <input
                                                type="radio"
                                                name="payment"
                                                value={pay.id}
                                                checked={
                                                    data.payment_method ===
                                                    pay.id
                                                }
                                                onChange={(e) =>
                                                    setData(
                                                        "payment_method",
                                                        e.target.value
                                                    )
                                                }
                                                className="hidden"
                                            />
                                            <span className="text-2xl mb-1">
                                                {pay.icon}
                                            </span>
                                            <span className="font-bold text-[#1A1A1A] text-xs">
                                                {pay.name}
                                            </span>
                                        </label>
                                    ))}
                                </div>
                            </div>
                        </div>

                        <div className="lg:w-[400px]">
                            <div className="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm sticky top-24">
                                <h3 className="font-bold text-lg text-[#1A1A1A] mb-6">
                                    Order Summary
                                </h3>

                                <div className="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                    {groupedItems.map((group, idx) => (
                                        <div
                                            key={idx}
                                            className="border-b border-gray-50 pb-3 last:border-none"
                                        >
                                            <div className="flex items-center gap-2 text-xs font-bold text-gray-500 mb-2">
                                                <Store className="w-3 h-3" />{" "}
                                                {group.store.name}
                                            </div>
                                            {group.items.map((item, i) => (
                                                <div
                                                    key={i}
                                                    className="flex justify-between items-start mb-2"
                                                >
                                                    <div className="text-sm text-gray-700 w-3/4 truncate">
                                                        {item.qty}x{" "}
                                                        {item.product.name}
                                                    </div>
                                                    <div className="text-sm font-medium text-[#1A1A1A]">
                                                        {formatRupiah(
                                                            item.subtotal
                                                        )}
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    ))}
                                </div>

                                <div className="space-y-3 border-t border-gray-100 pt-4 mb-6">
                                    <div className="flex justify-between text-sm text-gray-600">
                                        <span>Subtotal Produk</span>
                                        <span>{formatRupiah(cartTotal)}</span>
                                    </div>
                                    <div className="flex justify-between text-sm text-gray-600">
                                        <span>
                                            Total Ongkir ({groupedItems.length}{" "}
                                            Toko)
                                        </span>
                                        <span>
                                            {formatRupiah(totalShipping)}
                                        </span>
                                    </div>
                                    <div className="flex justify-between text-sm text-gray-600">
                                        <span>PPN (11%)</span>
                                        <span className="text-orange-600">
                                            +{formatRupiah(tax)}
                                        </span>
                                    </div>
                                    <div className="flex justify-between text-lg font-bold text-[#1A1A1A] pt-2 border-t border-dashed border-gray-200">
                                        <span>Total Bayar</span>
                                        <span className="text-[#00B207]">
                                            {formatRupiah(grandTotal)}
                                        </span>
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full py-3.5 bg-[#00B207] text-white rounded-full font-bold shadow-lg hover:bg-green-700 transition transform hover:-translate-y-1 disabled:opacity-50"
                                >
                                    {processing
                                        ? "Processing..."
                                        : "Buat Pesanan"}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </MainLayout>
    );
}
