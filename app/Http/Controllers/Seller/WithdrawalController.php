<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display withdrawal history and form.
     */
    public function index()
    {
        $store = auth()->user()->store;
        
        // Get or create store balance record
        $storeBalance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            [
                'balance' => 0,
                'bank_name' => null,
                'bank_account_name' => null,
                'bank_account_number' => null,
            ]
        );
        
        $withdrawals = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->latest()
            ->paginate(10);

        return view('seller.withdrawals.index', compact('storeBalance', 'withdrawals'));
    }

    /**
     * Store a new withdrawal request.
     */
    public function store(Request $request)
    {
        $store = auth()->user()->store;
        $storeBalance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $validated = $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
        ]);

        // Check if balance is sufficient
        if ($validated['amount'] > $storeBalance->balance) {
            return back()->with('error', 'Insufficient balance!');
        }

        // Create withdrawal request
        Withdrawal::create([
            'store_balance_id' => $storeBalance->id,
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank_name'],
            'bank_account_name' => $validated['bank_account_name'],
            'bank_account_number' => $validated['bank_account_number'],
            'status' => 'pending',
        ]);

        // Deduct balance immediately (will be returned if rejected)
        $storeBalance->decrement('balance', $validated['amount']);

        return back()->with('success', 'Withdrawal request submitted successfully!');
    }

    /**
     * Update bank account information.
     */
    public function updateBankAccount(Request $request)
    {
        $store = auth()->user()->store;
        $storeBalance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
        ]);

        $storeBalance->update($validated);

        return back()->with('success', 'Bank account updated successfully!');
    }
}
