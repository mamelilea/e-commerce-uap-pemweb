<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Str;
use App\Models\Withdrawal;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        // 1. Total Users
        $totalUsers = User::count();

        // 2. Total Sellers (Users with a Store)
        $totalSellers = Store::count();

        // 3. Total Stores (Same as above, but keeping separation for logic if needed)
        $totalStores = Store::count();

        // 4. Pending Verifications
        $pendingStores = Store::where('is_verified', false)->count();

        // 5. Recent Activity
        $latestUsers = User::latest()->take(5)->get();
        $latestStores = Store::latest()->take(5)->get();

        // 6. Chart Data (Simulation for Visuals)
        // In real app, we would group by created_at.
        $monthlyStats = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [12, 19, 3, 5, 2, 10], // Dummy data for "rame" UI
        ];

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalStores', 'pendingStores',
            'latestUsers', 'latestStores', 'monthlyStats'
        ));
    }

    /**
     * Display the System Management Page.
     */
    /**
     * Display the Store Verification Page.
     */
    public function verification()
    {
        $pendingStoresList = Store::with('user')->where('is_verified', false)->get();
        return view('admin.verification', compact('pendingStoresList'));
    }

    /**
     * Display the System Management Page (Users & Stores).
     */
    public function management()
    {
        // All Users
        $users = User::all();

        // All Stores
        $stores = Store::with('user')->get();

        return view('admin.management', compact('users', 'stores'));
    }

    /**
     * Verify (Approve) a Store.
     */
    public function verifyStore(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        
        $action = $request->input('action'); // 'approve' or 'reject'

        if ($action === 'approve') {
            $store->update(['is_verified' => true]);
            // Ensure User role is updated if needed (though logic usually relies on store existence)
             return redirect()->back()->with('success', 'Toko berhasil diverifikasi.');
        } elseif ($action === 'reject') {
            // Delete the store or mark as rejected
            $store->delete(); // Simple rejection for now
            return redirect()->back()->with('success', 'Pengajuan toko ditolak.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

    public function paymentVerification()
    {
        $transactions = Transaction::where('payment_status', 'unpaid')
            ->whereNotNull('proof_of_payment')
            ->with(['buyer.user', 'store'])
            ->get();

        return view('admin.payment_verification', compact('transactions'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $action = $request->input('action'); // 'valid' or 'invalid'

        if ($action === 'valid') {
            DB::transaction(function () use ($transaction) {
                // 1. Update Transaction
                $transaction->update([
                    'payment_status' => 'paid',
                    'admin_verified_at' => now(),
                ]);

                // 2. Release Money to Seller
                $storeBalance = StoreBalance::firstOrCreate(
                    ['store_id' => $transaction->store_id],
                    ['balance' => 0]
                );

                $amount = $transaction->grand_total; // Assuming full amount release

                $storeBalance->increment('balance', $amount);

                // 3. Record History
                StoreBalanceHistory::create([
                    'store_balance_id' => $storeBalance->id,
                    'type' => 'income',
                    'reference_id' => $transaction->id, // Using Transaction ID (ensure schema supports string/int or adjust)
                    'reference_type' => 'App\Models\Transaction',
                    'amount' => $amount,
                    'remarks' => 'Penjualan #' . $transaction->code,
                ]);
            });

            return redirect()->back()->with('success', 'Pembayaran diverifikasi. Dana diteruskan ke penjual.');
        } elseif ($action === 'invalid') {
            // Reject: Reset proof so user can re-upload
            $transaction->update([
                'proof_of_payment' => null,
            ]);
            
            return redirect()->back()->with('success', 'Pembayaran ditolak. Bukti pembayaran di-reset.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

    public function withdrawalVerification()
    {
        $withdrawals = Withdrawal::where('status', 'pending')
            ->with(['storeBalance.store'])
            ->latest()
            ->get();

        return view('admin.withdrawal_verification', compact('withdrawals'));
    }

    public function verifyWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $action = $request->input('action'); // 'approve' or 'reject'

        if ($action === 'approve') {
            $withdrawal->update(['status' => 'approved']);
            return redirect()->back()->with('success', 'Penarikan dana disetujui.');
        } elseif ($action === 'reject') {
            DB::transaction(function () use ($withdrawal) {
                // 1. Mark as Rejected
                $withdrawal->update(['status' => 'rejected']);

                // 2. Refund Balance to Store
                $storeBalance = $withdrawal->storeBalance;
                $storeBalance->increment('balance', $withdrawal->amount);

                // 3. Record History (Refund)
                StoreBalanceHistory::create([
                    'store_balance_id' => $storeBalance->id,
                    'type' => 'income', // Treated as income because money comes back
                    'reference_id' => $withdrawal->id,
                    'reference_type' => 'App\Models\Withdrawal',
                    'amount' => $withdrawal->amount,
                    'remarks' => 'Pengembalian Dana (Penarikan Ditolak)',
                ]);
            });

            return redirect()->back()->with('success', 'Penarikan dana ditolak. Saldo dikembalikan ke toko.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
}