<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = \App\Models\User::count();
        $storesCount = \App\Models\Store::count();
        $transactionsCount = \App\Models\Transaction::count();
        return view('admin.dashboard', compact('usersCount', 'storesCount', 'transactionsCount'));
    }

    public function verification()
    {
        $stores = \App\Models\Store::where('is_verified', false)->get();
        return view('admin.verification', compact('stores'));
    }

    public function approveStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $store->update(['is_verified' => true]);
        return back()->with('success', 'Store Verified');
    }

    public function rejectStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $store->delete();
        return back()->with('success', 'Store Rejected');
    }

    public function users()
    {
        $users = \App\Models\User::with('store')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User Deleted Successfully');
    }

    public function stores()
    {
        $stores = \App\Models\Store::with('user')->paginate(20);
        return view('admin.stores', compact('stores'));
    }

    public function destroyStore($id)
    {
        $store = \App\Models\Store::findOrFail($id);
        $store->delete();
        return back()->with('success', 'Store Deleted Successfully');
    }

    public function withdrawals()
    {
        // Get all pending withdrawals first, then others
        $withdrawals = \App\Models\Withdrawal::with('store')
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = \App\Models\Withdrawal::findOrFail($id);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal already processed');
        }

        $withdrawal->update(['status' => 'approved']);
        
        return back()->with('success', 'Withdrawal Approved');
    }

    public function rejectWithdrawal($id)
    {
        $withdrawal = \App\Models\Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal already processed');
        }

        // Refund Balance
        $storeBalance = \App\Models\StoreBalance::where('store_id', $withdrawal->store_id)->first();
        if ($storeBalance) {
            $storeBalance->increment('balance', $withdrawal->amount);
            
            // Log Refund
            \App\Models\StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'amount' => $withdrawal->amount,
                'type' => 'credit',
                'description' => 'Withdrawal Refund/Rejection',
            ]);
        }

        $withdrawal->update(['status' => 'rejected']);

        return back()->with('success', 'Withdrawal Rejected and Refunded');
    }
}
