<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'verified_stores' => Store::where('is_verified', true)->count(),
            'total_transactions' => Transaction::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
        ];

        $pendingStores = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $pendingWithdrawals = Withdrawal::where('status', 'pending')
            ->with('storeBalance.store')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingStores', 'pendingWithdrawals'));
    }
}
