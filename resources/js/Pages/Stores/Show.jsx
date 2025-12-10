import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';

export default function StoreProfile({ store, products }) {
    const { auth } = usePage().props;
    const isOwner = auth.user && auth.user.id === store.user_id;

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(number);
    };

    const formatDate = (dateString) => {
        if (!dateString) return 'Baru saja';
        try {
            const safeDate = dateString.replace(' ', 'T');
            const dateObj = new Date(safeDate);
            if (isNaN(dateObj.getTime())) return 'Baru saja';
            return dateObj.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
        } catch (e) {
            return 'Baru saja';
        }
    };

    const getProductImage = (product) => {
        if (!product.product_images || product.product_images.length === 0) {
            return 'https://via.placeholder.com/300?text=No+Image';
        }
        const imgObj = product.product_images[0];
        const path = imgObj.path || imgObj.image || imgObj.file || imgObj.filename || imgObj.url;
        
        return path ? `/storage/${path}` : 'https://via.placeholder.com/300?text=Error+Path';
    };

    return (
        <div className="bg-gray-50 min-h-screen pb-20 font-sans">
            <Head title={`${store.name} - FreshMart`} />

            <div className="relative h-64 w-full bg-gradient-to-r from-emerald-600 to-green-500 overflow-hidden">
                <div className="absolute inset-0 opacity-10" 
                     style={{ backgroundImage: 'radial-gradient(#fff 1px, transparent 1px)', backgroundSize: '20px 20px' }}>
                </div>
            </div>

            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="relative -mt-24 z-10 mb-8">
                    <div className="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div className="p-6 md:p-8">
                            <div className="flex flex-col md:flex-row items-center md:items-start gap-6">
                                <div className="flex-shrink-0">
                                    <div className="w-32 h-32 rounded-full border-4 border-white shadow-md overflow-hidden bg-gray-100">
                                        <img 
                                            src={store.logo ? `/storage/${store.logo}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(store.name)}&background=10b981&color=fff`} 
                                            alt={store.name} 
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                </div>

                                <div className="flex-1 text-center md:text-left space-y-3">
                                    <div className="flex items-center justify-center md:justify-start gap-2 flex-wrap">
                                        <h1 className="text-3xl font-bold text-gray-900">{store.name}</h1>
                                        {store.is_verified === 1 && (
                                            <span className="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 border border-blue-100">
                                                <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd"></path></svg>
                                                Official Store
                                            </span>
                                        )}
                                    </div>

                                    <div className="flex items-center justify-center md:justify-start gap-4 text-sm text-gray-500">
                                        <div className="flex items-center gap-1">
                                            <svg className="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {store.city}
                                        </div>
                                        <div className="hidden md:block w-1 h-1 bg-gray-300 rounded-full"></div>
                                        <div>Bergabung {formatDate(store.created_at)}</div>
                                    </div>

                                    <p className="text-gray-600 max-w-2xl text-sm leading-relaxed mx-auto md:mx-0 line-clamp-2">
                                        {store.about || "Selamat datang di toko kami! Kami menyediakan produk segar berkualitas terbaik langsung untuk Anda."}
                                    </p>

                                    <div className="flex items-center justify-center md:justify-start gap-8 pt-2">
                                        <div className="text-center md:text-left">
                                            <span className="block text-xl font-bold text-emerald-600">{products.total}</span>
                                            <span className="text-xs text-gray-400 uppercase tracking-wide font-semibold">Produk</span>
                                        </div>
                                        <div className="w-px h-8 bg-gray-200"></div>
                                        <div className="text-center md:text-left">
                                            <span className="block text-xl font-bold text-yellow-500 flex items-center justify-center md:justify-start gap-1">
                                                4.8 
                                                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            </span>
                                            <span className="text-xs text-gray-400 uppercase tracking-wide font-semibold">Rating Toko</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="border-t border-gray-100 bg-gray-50 px-6 md:px-8 overflow-x-auto">
                            <nav className="-mb-px flex space-x-8">
                                <button className="border-emerald-500 text-emerald-600 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm">
                                    Produk Toko
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>

                <div className="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h2 className="text-xl font-bold text-gray-800">Etalase Toko</h2>
                    <div className="w-full sm:w-auto relative">
                        <input 
                            type="text" 
                            placeholder="Cari produk di toko ini..." 
                            className="w-full sm:w-72 pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-shadow"
                        />
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                </div>

                {products.data.length > 0 ? (
                    <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        {products.data.map((product) => (
                            <Link 
                                href={`/product/${product.slug}`} 
                                key={product.id} 
                                className="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full"
                            >
                                <div className="relative aspect-square overflow-hidden bg-gray-100">
                                    <img 
                                        src={getProductImage(product)} 
                                        alt={product.name} 
                                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        onError={(e) => { e.target.src = 'https://via.placeholder.com/300?text=Img+Error'; }}
                                    />
                                </div>
                                <div className="p-4 flex flex-col flex-1">
                                    <h3 className="text-sm font-medium text-gray-800 line-clamp-2 mb-2 group-hover:text-emerald-600 transition-colors">
                                        {product.name}
                                    </h3>
                                    <div className="mt-auto">
                                        <p className="text-lg font-bold text-emerald-600 mb-2">
                                            {formatRupiah(product.price)}
                                        </p>
                                        <div className="flex items-center justify-between text-xs text-gray-500 border-t border-gray-50 pt-3">
                                            <div className="flex items-center">
                                                <svg className="w-3.5 h-3.5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                {product.product_reviews_avg_rating 
                                                    ? Number(product.product_reviews_avg_rating).toFixed(1) 
                                                    : '5.0'}
                                            </div>
                                            <div>
                                                Terjual {product.sold_count || 0}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                ) : (
                    <div className="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                        <div className="bg-gray-50 p-4 rounded-full mb-4">
                            <svg className="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 className="text-lg font-medium text-gray-900">Belum ada produk</h3>
                        <p className="text-gray-500 text-sm mt-1">Toko ini belum menambahkan produk ke etalase.</p>
                    </div>
                )}

                {products.links && (
                     <div className="mt-10 flex justify-center">
                        {products.links.map((link, k) => (
                            <Link
                                key={k}
                                href={link.url || '#'}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                                className={`px-4 py-2 border rounded mx-1 text-sm ${
                                    link.active 
                                    ? 'bg-emerald-600 text-white border-emerald-600' 
                                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                                } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                            />
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
}