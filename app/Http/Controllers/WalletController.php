<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function topup()
    {
        return view('wallet.topup');
    }

    public function processTopup(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $topup = \App\Models\Topup::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'amount' => $request->amount,
            'va_number' => 'VA-' . time() . rand(100, 999),
            'status' => 'pending',
        ]);

        return redirect()->route('payment.index')
            ->with('success', 'Topup Request Created. Your VA Code is: ' . $topup->va_number)
            ->with('va_number', $topup->va_number);
    }
}
