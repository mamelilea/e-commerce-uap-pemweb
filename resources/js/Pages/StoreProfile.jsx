// resources/js/Pages/StoreProfile.jsx (KODE LENGKAP)

import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; // Sesuaikan path Layout Anda

// --- Komponen Pembantu: ProductCard ---
// Menampilkan setiap produk dalam bentuk card
const ProductCard = ({ product }) => (
    // Link ke detail produk (gunakan slug)
    <Link href={route('product.detail', product.slug)} className="block p-4 border rounded-lg hover:shadow-lg transition duration-200 bg-white">
        <img 
            src={product.main_image} 
            alt={product.name} 
            className="w-full h-32 object-cover mb-3 rounded"
            // Tambahkan penanganan error gambar jika diperlukan
            onError={(e) => { e.target.onerror = null; e.target.src = '/images/default-product.png' }}
        />
        <h3 className="text-md font-semibold text-gray-800 truncate">{product.name}</h3>
        <p className="text-sm text-gray-500">Stok: {product.stock}</p>
        <p className="text-lg font-bold text-red-600 mt-1">
            Rp{product.price.toLocaleString('id-ID')}
        </p>
    </Link>
);


// --- Komponen Utama: StoreProfile ---
function StoreProfile({ store, auth }) { 
    
    // Fallback jika data toko tidak ada
    if (!store) {
        return (
            <AuthenticatedLayout user={auth.user} header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Toko Tidak Ditemukan</h2>}>
                <div className="text-center p-8">Data Toko tidak tersedia.</div>
            </AuthenticatedLayout>
        );
    }

    return (
        <AuthenticatedLayout 
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Profil Toko: {store.name}</h2>}
        >
            <Head title={`Profil Toko: ${store.name}`} />

            <div className="py-12 bg-gray-100">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        
                        <div className="p-6 sm:p-8">
                            
                            {/* --- HEADER PROFILE TOKO --- */}
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                                
                                {/* KOLOM KIRI: INFO RINGKAS */}
                                <div className="md:col-span-1 border-r pr-6">
                                    <div className="text-center">
                                        {/* Foto Profile Toko */}
                                        <img 
                                            src={store.logo || '/images/default_logo.png'} 
                                            alt={`Logo ${store.name}`} 
                                            className="w-36 h-36 object-cover rounded-full mx-auto shadow-xl border-4 border-green-500"
                                        />
                                        
                                        {/* Nama Toko */}
                                        <h1 className="text-3xl font-bold text-gray-900 mt-4">{store.name}</h1>
                                        <p className="text-sm text-gray-500 mt-1">Pemilik: {store.owner_name}</p>
                                        
                                        {/* Rating Toko */}
                                        <div className="flex items-center justify-center mt-3">
                                            <span className="text-yellow-500 text-3xl">⭐</span>
                                            <span className="ml-2 text-gray-700 font-bold text-3xl">
                                                {store.rating}
                                            </span>
                                            <span className="ml-1 text-base text-gray-500">
                                                / 5 ({store.reviews_count} Ulasan)
                                            </span>
                                        </div>

                                        {/* Tanggal Toko Dibuat */}
                                        <div className="mt-5 p-3 bg-green-50 rounded-lg shadow-sm">
                                            <p className="text-sm font-medium text-green-700">Bergabung Sejak:</p>
                                            <p className="text-lg font-bold text-green-800">{store.joined_date}</p>
                                        </div>

                                    </div>
                                </div>

                                {/* KOLOM KANAN: DESKRIPSI DAN ALAMAT */}
                                <div className="md:col-span-2">
                                    <section className="mb-6">
                                        <h2 className="text-2xl font-bold mb-3 text-gray-800 border-b pb-2">Deskripsi Toko</h2>
                                        <p className="text-gray-600 leading-relaxed whitespace-pre-line">{store.description}</p>
                                        
                                        <h2 className="text-2xl font-bold mb-3 mt-6 text-gray-800 border-b pb-2">Informasi Kontak</h2>
                                        <div className="text-gray-700 space-y-2">
                                            <p>📞 Telepon: **{store.phone}**</p>
                                            <p>📍 Kota: **{store.city}**</p>
                                            <p>🏠 Alamat Lengkap: {store.address}</p>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            
                            {/* --- DAFTAR PRODUK TOKO (Card Produk) --- */}
                            <section className="mt-12 pt-8 border-t border-gray-200">
                                <h2 className="text-3xl font-bold mb-6 text-gray-800">Semua Produk ({store.products ? store.products.length : 0})</h2>
                                
                                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                                    {store.products && store.products.length > 0 ? (
                                        store.products.map(p => <ProductCard key={p.id} product={p} />)
                                    ) : (
                                        <div className="col-span-full text-center py-10 text-xl text-gray-500 border rounded-lg bg-gray-50">
                                            Belum ada produk yang tersedia di toko ini.
                                        </div>
                                    )}
                                </div>
                            </section>

                        </div>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default StoreProfile;