<?php

namespace App\Http\Controllers;

use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index()
    {

        $pendingStores = Store::where('is_verified', 0)->get();
        $verifiedStores = Store::where('is_verified', 1)->get();

        return view('admin.verifikasi', compact('pendingStores', 'verifiedStores'));
    }

    public function approve($id)
    {
        Store::where('id', $id)->update([
            'is_verified' => 1
        ]);

        return back()->with('success', 'Toko berhasil disetujui.');
    }

    public function reject($id)
    {
        Store::where('id', $id)->update([
            'is_verified' => 0
        ]);

        return back()->with('success', 'Toko ditolak.');
    }
}
