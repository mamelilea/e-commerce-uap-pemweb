<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalApprovalController extends Controller
{
    /**
     * Display pending withdrawal requests.
     */
    public function index()
    {
        $withdrawals = Withdrawal::with('storeBalance.store.user')
            ->latest()
            ->paginate(15);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Approve withdrawal request.
     */
    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $withdrawal->update(['status' => 'approved']);

        // Note: In real implementation, this would trigger bank transfer process

        return back()->with('success', 'Withdrawal approved successfully!');
    }

    /**
     * Reject withdrawal request.
     */
    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        // Return balance to seller
        $storeBalance = $withdrawal->storeBalance;
        $storeBalance->increment('balance', $withdrawal->amount);

        // Mark as rejected
        $withdrawal->update(['status' => 'rejected']);

        return back()->with('success', 'Withdrawal rejected. Balance returned to seller.');
    }
}
