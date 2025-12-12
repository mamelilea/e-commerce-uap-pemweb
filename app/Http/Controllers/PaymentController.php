<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function check(\Illuminate\Http\Request $request)
    {
        $request->validate(['va_number' => 'required|string']);
        
        $topup = \App\Models\Topup::where('va_number', $request->va_number)->where('status', 'pending')->first();
        if ($topup) {
            return view('payment.index', ['details' => $topup, 'type' => 'topup']);
        }

        $transaction = \App\Models\Transaction::where('code', $request->va_number)->where('payment_status', 'unpaid')->first();
        if ($transaction) {
            return view('payment.index', ['details' => $transaction, 'type' => 'transaction', 'amount' => $transaction->grand_total]);
        }

        return back()->withErrors(['va_number' => 'VA Number not found or already paid.']);
    }

    public function pay(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'va_number' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:topup,transaction',
        ]);

        if ($request->type === 'topup') {
            $topup = \App\Models\Topup::where('va_number', $request->va_number)->where('status', 'pending')->firstOrFail();
            
            if ($request->amount != $topup->amount) {
                return back()->withErrors(['amount' => 'Invalid amount.']);
            }

            $topup->update(['status' => 'paid']);
            
            $balance = \App\Models\UserBalance::firstOrCreate(['user_id' => $topup->user_id]);
            $balance->increment('balance', $topup->amount);
            
            return redirect()->route('home')->with('success', 'Topup Successful!');
        }

        if ($request->type === 'transaction') {
            $transaction = \App\Models\Transaction::where('code', $request->va_number)->where('payment_status', 'unpaid')->firstOrFail();

            if ($request->amount != $transaction->grand_total) {
                return back()->withErrors(['amount' => 'Invalid amount.']);
            }

            $transaction->update(['payment_status' => 'paid']);

            // Add to Store Balance
            $storeBalance = \App\Models\StoreBalance::firstOrCreate(['store_id' => $transaction->store_id]);
            $storeBalance->increment('balance', $transaction->grand_total);
            // Record History (Optional but good practice)
             \App\Models\StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'amount' => $transaction->grand_total,
                'type' => 'credit',
                'description' => 'Payment for Order #' . $transaction->code,
            ]);

            return redirect()->route('home')->with('success', 'Payment Successful! Order Processed.');
        }

        return back();
    }
}
