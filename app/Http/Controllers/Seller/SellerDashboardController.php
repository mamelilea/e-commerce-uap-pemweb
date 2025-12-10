<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    // Dashboard utama seller (butuh toko verified)
    public function index()
    {
        $user  = Auth::user();
        $store = $user->store;

        // Kalau entah gimana nggak punya toko, arahkan ke register
        if (!$store) {
            return redirect()
                ->route('seller.store.create')
                ->with('error', 'Kamu belum memiliki toko. Daftarkan toko dulu ya.');
        }

        // Safety: kalau belum verified, lempar ke waiting
        if (!$store->is_verified) {
            return redirect()->route('seller.waiting');
        }

        // Nanti di sini kamu bisa kirim data statistik, pesanan, dsb
        return view('seller.dashboard.dashboard', compact('store'));
    }

    // Halaman "Menunggu Verifikasi"
    public function waitingVerification()
    {
        $user  = Auth::user();
        $store = $user->store;

        // Kalau belum punya toko, balik ke form register
        if (!$store) {
            return redirect()->route('seller.store.create');
        }

        // Kalau SUDAH diverifikasi, langsung lempar ke dashboard
        if ($store->is_verified) {
            return redirect()
                ->route('seller.dashboard')
                ->with('success', 'Toko kamu sudah diverifikasi. Selamat berjualan di Techly!');
        }

        return view('seller.dashboard.waiting-verification', compact('store'));
    }
}
