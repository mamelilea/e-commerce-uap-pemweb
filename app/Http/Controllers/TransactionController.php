<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
                        ->with(['store', 'transactionDetails.product'])
                        ->latest()
                        ->get();
        return view('frontend.history.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = \App\Models\Transaction::where('user_id', auth()->id())
                        ->with(['store', 'transactionDetails.product'])
                        ->findOrFail($id);
        return view('frontend.history.show', compact('transaction'));
    }

    public function complete($id)
    {
        $transaction = \App\Models\Transaction::where('user_id', auth()->id())
                        ->where('payment_status', 'shipped')
                        ->findOrFail($id);

        $transaction->payment_status = 'completed';
        $transaction->save();
        
        
        // Update store balance
        $storeBalance = $transaction->store->storeBalance ?? \App\Models\StoreBalance::create(['store_id' => $transaction->store_id]);
        $storeBalance->balance += $transaction->grand_total;
        $storeBalance->save();

        \App\Models\StoreBalanceHistory::create([
             'store_balance_id' => $storeBalance->id,
             'type' => 'income',
             'reference_id' => $transaction->id,
             'reference_type' => 'transaction',
             'amount' => $transaction->grand_total,
             'remarks' => 'Order completed',
        ]);

        return back()->with('success', 'Order marked as completed. Thank you!');
    }
}
