<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $transaction = null;
        
        if ($request->has('transaction_id')) {
            $transaction = \App\Models\Transaction::find($request->transaction_id);
        }
        
        return view('frontend.payment.simulation', compact('transaction'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'va_number' => 'required|exists:transactions,va_number',
        ]);

        $transaction = \App\Models\Transaction::where('va_number', $request->va_number)
                        ->where('payment_status', 'unpaid')
                        ->first();

        if (!$transaction) {
            return back()->with('error', 'Transaction not found or already paid.');
        }

        // Process Payment
        $transaction->payment_status = 'paid';
        $transaction->save();

        // Add to store balance (for product purchases)
        if($transaction->store_id) {
            $store = \App\Models\Store::find($transaction->store_id);
            if($store) {
                $storeBalance = \App\Models\StoreBalance::firstOrCreate(['store_id' => $store->id]);
                $storeBalance->balance += $transaction->grand_total;
                $storeBalance->save();
                
                // Record history
                \App\Models\StoreBalanceHistory::create([
                    'store_balance_id' => $storeBalance->id,
                    'type' => 'income',
                    'amount' => $transaction->grand_total,
                    'reference_id' => $transaction->id,
                    'reference_type' => 'transaction',
                    'remarks' => 'Sales revenue from Order #' . ($transaction->code ?? $transaction->id)
                ]);
            }
        }

        return redirect()->route('history.index')->with('success', 'Payment Successful! Your order is now confirmed.');
    }
}
