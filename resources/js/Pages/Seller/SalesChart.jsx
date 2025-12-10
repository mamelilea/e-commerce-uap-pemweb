import React, { useState } from "react";
import {
    AreaChart,
    Area,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    ResponsiveContainer,
} from "recharts";
import { router } from "@inertiajs/react";

export default function SalesChart({ data, currentFilter }) {
    const [loading, setLoading] = useState(false);

    const filters = [
        { label: "Hari Ini", value: "day" },
        { label: "Minggu Ini", value: "week" },
        { label: "Bulan Ini", value: "month" },
        { label: "Tahun Ini", value: "year" },
    ];

    const handleFilterChange = (filterValue) => {
        if (filterValue === currentFilter) return;

        setLoading(true);
        router.get(
            route("seller.dashboard"),
            { period: filterValue },
            {
                preserveState: true,
                preserveScroll: true,
                only: ["chartData", "currentFilter"],
                onFinish: () => setLoading(false),
            }
        );
    };

    const formatRupiah = (value) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(value);
    };

    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return (
                <div className="bg-white p-3 border border-gray-100 shadow-xl rounded-xl text-sm">
                    <p className="font-medium text-gray-500 mb-1">{label}</p>
                    <p className="font-bold text-[#173B1A]">
                        {formatRupiah(payload[0].value)}
                    </p>
                </div>
            );
        }
        return null;
    };

    return (
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div className="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h3 className="text-lg font-bold text-gray-900">
                        Grafik Penjualan
                    </h3>
                    <p className="text-sm text-gray-500">
                        Analisis pendapatan toko Anda
                    </p>
                </div>

                <div className="flex bg-gray-100 p-1 rounded-lg">
                    {filters.map((filter) => (
                        <button
                            key={filter.value}
                            onClick={() => handleFilterChange(filter.value)}
                            disabled={loading}
                            className={`px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200 ${
                                currentFilter === filter.value
                                    ? "bg-white text-[#173B1A] shadow-sm"
                                    : "text-gray-500 hover:text-[#173B1A]"
                            } ${loading ? "opacity-50 cursor-wait" : ""}`}
                        >
                            {filter.label}
                        </button>
                    ))}
                </div>
            </div>

            <div className="h-[350px] w-full">
                <ResponsiveContainer width="100%" height="100%">
                    <AreaChart
                        data={data}
                        margin={{ top: 10, right: 0, left: -20, bottom: 0 }}
                    >
                        <defs>
                            <linearGradient
                                id="colorSales"
                                x1="0"
                                y1="0"
                                x2="0"
                                y2="1"
                            >
                                <stop
                                    offset="5%"
                                    stopColor="#93FF00"
                                    stopOpacity={0.2}
                                />
                                <stop
                                    offset="95%"
                                    stopColor="#93FF00"
                                    stopOpacity={0}
                                />
                            </linearGradient>
                        </defs>
                        <CartesianGrid
                            strokeDasharray="3 3"
                            vertical={false}
                            stroke="#f3f4f6"
                        />
                        <XAxis
                            dataKey="name"
                            axisLine={false}
                            tickLine={false}
                            tick={{ fill: "#9ca3af", fontSize: 11 }}
                            dy={10}
                        />
                        <YAxis
                            axisLine={false}
                            tickLine={false}
                            tick={{ fill: "#9ca3af", fontSize: 11 }}
                            tickFormatter={(value) =>
                                value >= 1000000
                                    ? `${value / 1000000}jt`
                                    : value >= 1000
                                    ? `${value / 1000}k`
                                    : value
                            }
                        />
                        <Tooltip
                            content={<CustomTooltip />}
                            cursor={{ stroke: "#93FF00", strokeWidth: 1 }}
                        />
                        <Area
                            type="monotone"
                            dataKey="total"
                            stroke="#173B1A"
                            strokeWidth={2}
                            fillOpacity={1}
                            fill="url(#colorSales)"
                        />
                    </AreaChart>
                </ResponsiveContainer>
            </div>
        </div>
    );
}
