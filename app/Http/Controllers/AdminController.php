<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\StoreBalance;
use App\Models\WithDrawal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'member')->count();
        $activeStores = Store::where('is_verified', true)->count();
        $pendingStoresCount = Store::where('is_verified', false)->count();
        $totalSystemBalance = StoreBalance::sum('balance');

        $pendingStores = Store::with('user')
            ->where('is_verified', false)
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_users' => $totalUsers,
                'active_stores' => $activeStores,
                'pending_stores' => $pendingStoresCount,
                'total_balance' => $totalSystemBalance
            ],
            'pendingStores' => $pendingStores
        ]);
    }

    public function stores(Request $request)
    {
        $query = Store::with('user');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stores = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Stores', [
            'stores' => $stores,
            'filters' => $request->only(['search']),
        ]);
    }

    public function approveStore($id)
    {
        Store::findOrFail($id)->update(['is_verified' => true]);
        return back()->with('success', 'Toko berhasil diverifikasi.');
    }

    public function rejectStore($id)
    {
        $store = Store::findOrFail($id);
        
        if ($store->user) {
            $store->user->update(['role' => 'member']);
        }

        $store->delete();
        return back()->with('success', 'Pengajuan toko ditolak dan role pengguna dikembalikan.');
    }

    public function withdrawals()
    {
        $withdrawals = WithDrawal::with('storeBalance.store')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Withdrawals', [
            'withdrawals' => $withdrawals
        ]);
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = WithDrawal::findOrFail($id);
        
        $withdrawal->storeBalance->decrement('balance', $withdrawal->amount);
        
        $withdrawal->update(['status' => 'approved']);

        return back()->with('success', 'Penarikan disetujui.');
    }

    public function rejectWithdrawal($id)
    {
        WithDrawal::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Penarikan ditolak.');
    }

    public function users(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'filters' => $request->only(['search']),
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Data pengguna diperbarui.');
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }
}