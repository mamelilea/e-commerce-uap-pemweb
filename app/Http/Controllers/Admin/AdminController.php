<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function storeVerification()
    {
        $unverifiedStores = Store::where('is_verified', false)
            ->with('user')
            ->paginate(10);

        return view('admin.stores.verification', compact('unverifiedStores'));
    }

    public function verifyStore(Store $store)
    {
        if ($store->is_verified) {
            return back()->with('error', 'Toko sudah terverifikasi.');
        }

        $store->is_verified = true;
        $store->save();

        return back()->with('success', 'Toko "' . $store->name . '" berhasil diverifikasi.');
    }

    public function rejectStore(Store $store)
    {
        $storeName = $store->name;
        $store->delete();

        return back()->with('success', 'Pengajuan toko "' . $storeName . '" telah ditolak dan data dihapus.');
    }

    public function userAndStoreManagement()
    {
        $users = User::with('store')->paginate(15);

        return view('admin.users_stores.index', compact('users'));
    }

    public function editUser(User $user)
    {
        $user->load('store');

        return view('admin.users_stores.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,member',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.users-stores.index')
            ->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Admin Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', 'Pengguna "' . $userName . '" berhasil dihapus.');
    }
}
