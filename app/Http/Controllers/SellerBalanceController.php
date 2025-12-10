<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerBalanceController extends Controller
{
    /**
     * Display store balance and history
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        // Get or create store balance
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        // Query balance histories
        $query = StoreBalanceHistory::where('store_balance_id', $storeBalance->id)
            ->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by remarks
        if ($request->filled('search')) {
            $query->where('remarks', 'like', '%' . $request->search . '%');
        }

        $histories = $query->paginate(20);

        // Calculate statistics
        $stats = [
            'current_balance' => $storeBalance->balance,
            'total_income' => StoreBalanceHistory::where('store_balance_id', $storeBalance->id)
                ->where('type', 'income')
                ->sum('amount'),
            'total_withdrawn' => StoreBalanceHistory::where('store_balance_id', $storeBalance->id)
                ->where('type', 'withdraw')
                ->sum('amount'),
            'total_transactions' => StoreBalanceHistory::where('store_balance_id', $storeBalance->id)
                ->count(),
        ];

        return view('seller.balance.index', compact('storeBalance', 'histories', 'stats'));
    }

    /**
     * Show withdrawal form
     */
    public function withdrawalForm()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        return view('seller.balance.withdrawal', compact('storeBalance'));
    }

    /**
     * Process withdrawal request
     */
    public function processWithdrawal(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $storeBalance = StoreBalance::where('store_id', $store->id)->firstOrFail();

        $request->validate([
            'amount' => ['required', 'numeric', 'min:10000', 'max:' . $storeBalance->balance],
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder' => ['required', 'string', 'max:100'],
        ]);

        try {
            // Generate unique reference ID for withdrawal
            $withdrawalId = 'WD-' . time() . '-' . $store->id;

            // Deduct balance
            $storeBalance->withdraw(
                $request->amount,
                $withdrawalId,
                'withdrawal',
                "Penarikan saldo ke {$request->bank_name} - {$request->account_number}"
            );

            // TODO: Create withdrawal request record in withdrawals table
            // This is just for demonstration, you should create a proper withdrawal system

            return redirect()->route('seller.balance.index')
                ->with('success', 'Permintaan penarikan saldo berhasil! Dana akan diproses dalam 1-3 hari kerja.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
