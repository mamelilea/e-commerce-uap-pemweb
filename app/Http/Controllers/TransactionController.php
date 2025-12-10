<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display user's transactions
     */
    public function index(Request $request)
    {
        $buyer = auth()->user()->buyer;
        
        if (!$buyer) {
            return view('transactions.index', ['transactions' => collect()]);
        }

        $query = Transaction::with(['store', 'transactionDetails.product'])
            ->where('buyer_id', $buyer->id)
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        $transactions = $query->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Display transaction detail
     */
    public function show(Transaction $transaction)
    {
        // Ensure user owns this transaction
        if ($transaction->buyer->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['store', 'transactionDetails.product.productImages']);

        return view('transactions.show', compact('transaction'));
    }
}
