<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    /**
     * Display the seller's balance and transaction history.
     */
    public function index()
    {
        $store = auth()->user()->store;
        $storeBalance = $store->storeBalance()->firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );
        
        // Get completed transactions for history
        $transactions = Transaction::where('store_id', auth()->user()->store->id)
            ->where('payment_status', 'completed')
            ->with(['buyer.user'])
            ->latest()
            ->paginate(15);

        // Calculate total revenue
        $totalRevenue = Transaction::where('store_id', auth()->user()->store->id)
            ->where('payment_status', 'completed')
            ->sum('grand_total');

        // Get pending balance (from orders that are paid but not completed)
        $pendingBalance = Transaction::where('store_id', auth()->user()->store->id)
            ->whereIn('payment_status', ['paid', 'processed', 'shipped'])
            ->sum('grand_total');

        return view('seller.balance.index', compact('storeBalance', 'transactions', 'totalRevenue', 'pendingBalance'));
    }
}
