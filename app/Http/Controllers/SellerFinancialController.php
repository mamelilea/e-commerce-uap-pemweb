<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerFinancialController extends Controller
{
    public function index()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $withdrawals = \App\Models\Withdrawal::where('store_id', $store->id)
                        ->latest()
                        ->get();

        return view('frontend.store.financial.index', compact('store', 'withdrawals'));
    }

    public function balanceHistory()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $histories = collect();
        if ($store->storeBalance) {
            $histories = \App\Models\StoreBalanceHistory::where('store_balance_id', $store->storeBalance->id)
                            ->latest()
                            ->paginate(20);
        } else {
             $histories = \App\Models\StoreBalanceHistory::whereRaw('1 = 0')->paginate(20); // Empty
        }

        return view('frontend.store.financial.balance', compact('store', 'histories'));
    }

    public function store(Request $request)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric|min:10000|max:' . ($store->storeBalance->balance ?? 0),
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);

        $withdrawal = \App\Models\Withdrawal::create([
            'store_id' => $store->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'status' => 'pending',
        ]);

        // Deduct balance
        $storeBalance = $store->storeBalance;
        $storeBalance->balance -= $request->amount;
        $storeBalance->save();

        \App\Models\StoreBalanceHistory::create([
             'store_balance_id' => $storeBalance->id,
             'type' => 'withdraw',
             'reference_id' => $withdrawal->id,
             'reference_type' => 'withdrawal',
             'amount' => $request->amount,
             'remarks' => 'Withdrawal request',
        ]);

        return back()->with('success', 'Withdrawal requested successfully.');
    }

    public function updateBankAccount(Request $request)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
        ]);

        $store->bank_name = $request->bank_name;
        $store->bank_account_name = $request->bank_account_name;
        $store->bank_account_number = $request->bank_account_number;
        $store->save();

        return back()->with('success', 'Bank account information updated successfully!');
    }
}
