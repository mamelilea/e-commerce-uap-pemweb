<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class StoreBalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        // Ensure StoreBalance exists
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $withdrawals = Withdrawal::where('store_balance_id', $balance->id)->latest()->get();

        return view('seller.balance.index', compact('store', 'balance', 'withdrawals'));
    }

    public function updateBank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
        ]);

        $store = Auth::user()->store;
        $store->update([
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
        ]);

        return redirect()->back()->with('success', 'Bank details updated successfully.');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $store = Auth::user()->store;
        $balance = $store->balance;

        if ($balance->balance < $request->amount) {
            return redirect()->back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        if (!$store->bank_name || !$store->bank_account_number) {
             return redirect()->back()->withErrors(['bank' => 'Please set up your bank details first.']);
        }

        // Create Withdrawal Request
        Withdrawal::create([
            'store_balance_id' => $balance->id,
            'amount' => $request->amount,
            'bank_name' => $store->bank_name,
            'bank_account_name' => $store->bank_account_name,
            'bank_account_number' => $store->bank_account_number,
            'status' => 'pending',
        ]);

        // Deduct balance immediately or hold it? 
        // Typically deduct and refund if rejected.
        $balance->decrement('balance', $request->amount);

        return redirect()->back()->with('success', 'Withdrawal requested successfully.');
    }
}
