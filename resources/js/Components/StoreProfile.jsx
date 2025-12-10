// resources/js/components/StoreProfile.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom'; // Untuk mengambil ID dari URL

function StoreProfile() {
    const { id } = useParams(); // Ambil ID toko dari URL (misalnya /store/1)
    
    // State untuk menyimpan data toko, status loading, dan error
    const [store, setStore] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        // Reset state sebelum fetching
        setLoading(true);
        setError(null);
        
        // Panggil endpoint API Laravel
        axios.get(`/api/stores/${id}`)
            .then(response => {
                setStore(response.data.store);
                setLoading(false);
            })
            .catch(err => {
                setError('Gagal memuat profil toko. Cek konsol untuk detail.');
                setLoading(false);
                console.error("API Error:", err);
            });
    }, [id]); // Dependency array: jalankan ulang ketika ID berubah

    if (loading) {
        return <div className="text-center p-8 text-blue-600">Memuat profil toko...</div>;
    }

    if (error) {
        return <div className="text-center p-8 text-red-600">{error}</div>;
    }
    
    // Pastikan store ada sebelum mencoba mengakses propertinya
    if (!store) return <div className="text-center p-8">Toko tidak ditemukan.</div>;

    // --- Tampilan Toko (gunakan data dari state 'store') ---
    return (
        <div className="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg my-10">
            <header className="border-b pb-4 mb-4">
                <h1 className="text-3xl font-bold text-green-700">{store.name}</h1>
                <p className="text-sm text-gray-500">Pemilik: {store.owner.name}</p>
                <div className="flex items-center mt-2">
                    <span className="text-yellow-500 text-xl">⭐</span>
                    <span className="ml-2 text-gray-700 font-semibold">
                        {store.rating || 'N/A'} ({store.reviews.length} Ulasan)
                    </span>
                </div>
            </header>
            
            <section className="mb-6">
                <h2 className="text-2xl font-semibold mb-2 text-gray-800">Deskripsi Toko</h2>
                <p className="text-gray-600">{store.description}</p>
            </section>

            <section>
                <h2 className="text-2xl font-semibold mb-4 text-gray-800">Daftar Produk ({store.products.length})</h2>
                <ul className="list-disc pl-5 text-gray-700">
                    {store.products.length > 0 ? (
                        store.products.map(p => <li key={p.id}>{p.name}</li>)
                    ) : (
                        <li>Toko ini belum memiliki produk.</li>
                    )}
                </ul>
            </section>
        </div>
    );
}

export default StoreProfile;