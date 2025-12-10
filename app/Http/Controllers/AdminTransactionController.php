<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['buyer.user', 'store'])
            ->where('payment_status', 'unpaid')
            ->where('address_id', '!=', 'cod')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Transactions', [
            'transactions' => $transactions
        ]);
    }

    public function confirm($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'payment_status' => 'paid'
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi. Seller akan diberitahu.');
    }
}