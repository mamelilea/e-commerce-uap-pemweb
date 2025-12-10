<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingStores = \App\Models\Store::where('is_verified', false)->get();
        $pendingWithdrawals = \App\Models\Withdrawal::where('status', 'pending')->with('storeBalance.store.user')->get();
        $users = \App\Models\User::all();
        $stores = \App\Models\Store::all();
        
        return view('admin.dashboard', compact('pendingStores', 'pendingWithdrawals', 'users', 'stores'));
    }

    public function approveStore(\App\Models\Store $store)
    {
        $store->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Store verified successfully!');
    }

    public function approveWithdrawal(\App\Models\Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Withdrawal request approved!');
    }

    public function destroyStore(\App\Models\Store $store)
    {
        $store->delete();
        return redirect()->back()->with('success', 'Store deleted successfully!');
    }

    public function suspendStore(\App\Models\Store $store)
    {
        $store->update(['is_suspended' => !$store->is_suspended]);
        $status = $store->is_suspended ? 'suspended' : 'activated';
        return redirect()->back()->with('success', "Store has been $status.");
    }
}
