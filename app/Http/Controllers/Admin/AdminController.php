<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Constructor kosong - middleware dipindahkan ke routes
    public function __construct()
    {
        //
    }

    // Dashboard Admin
    public function dashboard()
    {
        $totalUsers = User::where('role', 'member')->count();
        $totalStores = Store::count();
        $verifiedStores = Store::where('is_verified', true)->count();
        $pendingStores = Store::where('is_verified', false)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores',
            'verifiedStores',
            'pendingStores'
        ));
    }

    // Halaman Verifikasi Toko
    public function storeVerification()
    {
        $pendingStores = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.store-verification', compact('pendingStores'));
    }

    // Approve Toko
    public function approveStore($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_verified' => true]);

        return redirect()
            ->back()
            ->with('success', 'Toko berhasil diverifikasi!');
    }

    // Reject Toko
    public function rejectStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()
            ->back()
            ->with('success', 'Pengajuan toko ditolak dan dihapus!');
    }

    // Halaman Manajemen Pengguna
    public function userManagement()
    {
        $users = User::where('role', 'member')
            ->with('store')
            ->latest()
            ->paginate(15);

        return view('admin.user-management', compact('users'));
    }

    // Hapus User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()
                ->back()
                ->with('error', 'Tidak bisa menghapus admin!');
        }

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'User berhasil dihapus!');
    }

    // Halaman Manajemen Toko
    public function storeManagement()
    {
        $stores = Store::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.store-management', compact('stores'));
    }

    // Hapus Toko
    public function deleteStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()
            ->back()
            ->with('success', 'Toko berhasil dihapus!');
    }

    // Toggle Status Verifikasi Toko
    public function toggleStoreVerification($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_verified' => !$store->is_verified]);

        $status = $store->is_verified ? 'diverifikasi' : 'ditangguhkan';

        return redirect()
            ->back()
            ->with('success', "Toko berhasil {$status}!");
    }
}