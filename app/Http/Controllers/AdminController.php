<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingStores = \App\Models\Store::where('is_verified', false)->with('user')->latest()->get();
        $usersCount = \App\Models\User::count();
        $storesCount = \App\Models\Store::count();
        $verifiedStoresCount = \App\Models\Store::where('is_verified', true)->count();
        $transactionsCount = \App\Models\Transaction::count();

        return view('frontend.admin.index', compact('pendingStores', 'usersCount', 'storesCount', 'verifiedStoresCount', 'transactionsCount'));
    }

    public function stores()
    {
        $stores = \App\Models\Store::with('user')->latest()->paginate(20);
        return view('frontend.admin.stores', compact('stores'));
    }

    public function users()
    {
        $users = \App\Models\User::latest()->paginate(20);
        return view('frontend.admin.users', compact('users'));
    }

    public function verifyStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $store->is_verified = true;
        $store->save();

        return back()->with('success', 'Store "' . $store->name . '" has been verified!');
    }

    public function rejectStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $store->is_verified = false;
        $store->save();

        return back()->with('success', 'Store "' . $store->name . '" verification has been rejected.');
    }

    public function deleteStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $storeName = $store->name;
        $store->delete();

        return back()->with('success', 'Store "' . $storeName . '" has been deleted.');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Prevent deleting admin users
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', 'User "' . $userName . '" has been deleted.');
    }
}
