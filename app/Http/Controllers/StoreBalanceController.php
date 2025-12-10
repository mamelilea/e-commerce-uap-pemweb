<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StoreBalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('toko.dashboard')
                ->with('error', 'Kamu belum memiliki toko.');
        }

        $transactions = $store->transactions()
            ->where('payment_status', 'paid')
            ->get();

        $totalIncome = $transactions->sum('grand_total');

        return view('toko.saldo.index', compact('store', 'transactions', 'totalIncome'));
    }
}
