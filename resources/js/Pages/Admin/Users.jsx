import React, { useState } from "react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import { Search, User, Trash2, Edit, X, Save } from "lucide-react";

export default function Users({ users, filters }) {
    const [searchTerm, setSearchTerm] = useState(filters?.search || "");
    const currentRole = filters?.role || "all";

    const [isEditOpen, setIsEditOpen] = useState(false);
    const [editingUser, setEditingUser] = useState(null);

    const { data, setData, put, processing, reset, errors } = useForm({
        name: "",
        email: "",
        role: "user",
    });

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    };


    const handleSearch = (e) => {
        if (e.key === "Enter") {
            router.get(
                route("admin.users"),
                { search: searchTerm, role: currentRole },
                { preserveState: true }
            );
        }
    };

    const handleFilterChange = (role) => {
        const roleParam = role === "all" ? "" : role;
        router.get(
            route("admin.users"),
            { role: roleParam, search: searchTerm },
            { preserveState: true }
        );
    };

    const handleDelete = (id, name) => {
        if (
            confirm(`Yakin ingin menghapus user "${name}"? Aksi ini permanen.`)
        ) {
            router.delete(route("admin.users.destroy", id), {
                preserveScroll: true,
            });
        }
    };

    const openEditModal = (user) => {
        setEditingUser(user);
        setData({
            name: user.name,
            email: user.email,
            role: user.role,
        });
        setIsEditOpen(true);
    };

    const handleUpdate = (e) => {
        e.preventDefault();
        put(route("admin.users.update", editingUser.id), {
            onSuccess: () => {
                setIsEditOpen(false);
                setEditingUser(null);
                reset();
            },
        });
    };

    return (
        <AdminLayout title="Kelola Pengguna">
            <Head title="Kelola Pengguna" />

            <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div className="relative w-full md:w-96">
                    <div
                        className="absolute inset-y-0 left-0 flex items-center pointer-events-none z-10"
                        style={{ paddingLeft: "0.6rem" }}
                    >
                        <Search className="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        onKeyDown={handleSearch}
                        style={{ paddingLeft: "2.5rem" }}
                        className="block w-full pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#00B207] focus:ring-[#00B207] sm:text-sm transition duration-150 ease-in-out h-10 shadow-sm"
                        placeholder="Cari nama atau email..."
                    />
                </div>

                <div className="flex bg-gray-200 p-1 rounded-lg h-10 items-center">
                    <button
                        onClick={() => handleFilterChange("all")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentRole === "all"
                                ? "bg-white text-[#1A1A1A] shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Semua
                    </button>
                    <button
                        onClick={() => handleFilterChange("seller")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentRole === "seller"
                                ? "bg-white text-purple-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Seller
                    </button>
                    <button
                        onClick={() => handleFilterChange("member")}
                        className={`px-4 h-full text-xs font-bold rounded-md flex items-center transition-all ${
                            currentRole === "user"
                                ? "bg-white text-blue-600 shadow-sm"
                                : "text-gray-500 hover:text-gray-700"
                        }`}
                    >
                        Buyer
                    </button>
                </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <tr>
                                <th className="px-6 py-4">Pengguna</th>
                                <th className="px-6 py-4">Role</th>
                                <th className="px-6 py-4">Tanggal Bergabung</th>
                                <th className="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100 text-sm">
                            {users.data.length > 0 ? (
                                users.data.map((user) => (
                                    <tr
                                        key={user.id}
                                        className="hover:bg-gray-50/50 transition"
                                    >
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shrink-0">
                                                    {user.name
                                                        .charAt(0)
                                                        .toUpperCase()}
                                                </div>
                                                <div>
                                                    <div className="font-bold text-[#1A1A1A]">
                                                        {user.name}
                                                    </div>
                                                    <div className="text-xs text-gray-500">
                                                        {user.email}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            {user.role === "seller" ? (
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                                    Seller
                                                </span>
                                            ) : user.role === "member" ? ( 
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                                    Buyer
                                                </span>
                                            ) : (
                                                <span className="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                    {user.role}
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {formatDate(user.created_at)}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex items-center justify-center gap-2">
                                                <button
                                                    onClick={() =>
                                                        openEditModal(user)
                                                    }
                                                    className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                    title="Edit User"
                                                >
                                                    <Edit className="w-4 h-4" />
                                                </button>

                                                <button
                                                    onClick={() =>
                                                        handleDelete(
                                                            user.id,
                                                            user.name
                                                        )
                                                    }
                                                    className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus User"
                                                >
                                                    <Trash2 className="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="4">
                                        <div className="flex flex-col items-center justify-center py-16 text-center">
                                            <div className="bg-gray-50 p-4 rounded-full mb-3">
                                                <User className="w-10 h-10 text-gray-300" />
                                            </div>
                                            <h4 className="text-gray-900 font-medium mb-1">
                                                Tidak Ada Pengguna
                                            </h4>
                                            <p className="text-gray-500 text-sm">
                                                Coba ubah kata kunci pencarian.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="p-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                    Showing {users.from ?? 0} to {users.to ?? 0} of{" "}
                    {users.total ?? 0} entries
                    <div className="flex gap-2">
                        {users.links &&
                            users.links.map((link, index) =>
                                link.url ? (
                                    <Link
                                        key={index}
                                        href={link.url}
                                        className={`px-3 py-1 rounded border ${
                                            link.active
                                                ? "bg-[#00B207] text-white border-[#00B207]"
                                                : "bg-white border-gray-300 hover:bg-gray-50"
                                        }`}
                                        dangerouslySetInnerHTML={{
                                            __html: link.label,
                                        }}
                                    />
                                ) : (
                                    <span
                                        key={index}
                                        className="px-3 py-1 rounded border bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed"
                                        dangerouslySetInnerHTML={{
                                            __html: link.label,
                                        }}
                                    />
                                )
                            )}
                    </div>
                </div>
            </div>

            {isEditOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                    <div className="bg-white rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden transform transition-all">
                        <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 className="font-bold text-lg text-[#1A1A1A]">
                                Edit Pengguna
                            </h3>
                            <button
                                onClick={() => setIsEditOpen(false)}
                                className="text-gray-400 hover:text-gray-600 transition"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleUpdate} className="p-6 flex flex-col gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                />
                                {errors.name && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.name}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                />
                                {errors.email && (
                                    <div className="text-red-500 text-xs mt-1">
                                        {errors.email}
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Role
                                </label>
                                <select
                                    value={data.role}
                                    onChange={(e) =>
                                        setData("role", e.target.value)
                                    }
                                    className="w-full rounded-lg border-gray-300 focus:border-[#00B207] focus:ring-[#00B207] text-sm"
                                >
                                    <option value="member">
                                        Buyer (User Biasa)
                                    </option>
                                    <option value="seller">
                                        Seller (Penjual)
                                    </option>
                                </select>
                            </div>

                            <div className="pt-4 flex justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => setIsEditOpen(false)}
                                    className="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-[#00B207] rounded-lg text-sm font-bold text-white hover:bg-green-700 flex items-center gap-2"
                                >
                                    {processing ? (
                                        "Menyimpan..."
                                    ) : (
                                        <>
                                            <Save className="w-4 h-4" /> Simpan
                                            Perubahan
                                        </>
                                    )}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
