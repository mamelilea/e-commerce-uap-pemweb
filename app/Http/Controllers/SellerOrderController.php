<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of the orders for the seller's store.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pastikan user adalah seller dan punya store yang terverifikasi
        if (!$user->store || !$user->store->is_verified) {
            abort(403, 'Unauthorized access');
        }

        $store = $user->store;

        // Query dasar - hanya pesanan dari store seller ini
        $query = Transaction::where('store_id', $store->id)
            ->with(['buyer.user', 'transactionDetails.product.productImages'])
            ->orderBy('created_at', 'desc');

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by tracking number status
        if ($request->filled('tracking_status')) {
            if ($request->tracking_status == 'with_tracking') {
                $query->whereNotNull('tracking_number');
            } elseif ($request->tracking_status == 'without_tracking') {
                $query->whereNull('tracking_number')
                    ->where('payment_status', 'paid');
            }
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by transaction code
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(15);

        // Statistics
        $stats = [
            'total_orders' => Transaction::where('store_id', $store->id)->count(),
            'paid_orders' => Transaction::where('store_id', $store->id)
                ->where('payment_status', 'paid')->count(),
            'pending_process' => Transaction::where('store_id', $store->id)
                ->where('payment_status', 'paid')
                ->whereNull('tracking_number')->count(),
            'shipped_orders' => Transaction::where('store_id', $store->id)
                ->whereNotNull('tracking_number')->count(),
        ];

        return view('seller.orders.index', compact('transactions', 'stats'));
    }

    /**
     * Display the specified order detail.
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->store || !$user->store->is_verified) {
            abort(403, 'Unauthorized access');
        }

        // Pastikan pesanan milik store seller ini
        $transaction = Transaction::where('store_id', $user->store->id)
            ->with(['buyer.user', 'transactionDetails.product.productImages', 'store'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('transaction'));
    }

    /**
     * Update tracking number for the order.
     */
    public function updateTracking(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->store || !$user->store->is_verified) {
            abort(403, 'Unauthorized access');
        }

        $transaction = Transaction::where('store_id', $user->store->id)
            ->findOrFail($id);

        // Hanya bisa update tracking jika sudah dibayar
        if ($transaction->payment_status !== 'paid') {
            return back()->withErrors(['error' => 'Pesanan belum dibayar. Tidak dapat menambahkan nomor resi.']);
        }

        $request->validate([
            'tracking_number' => ['required', 'string', 'max:100'],
        ]);

        $transaction->update([
            'tracking_number' => $request->tracking_number,
        ]);

        return back()->with('success', 'Nomor resi berhasil diperbarui!');
    }

    /**
     * Remove tracking number from the order.
     */
    public function removeTracking($id)
    {
        $user = Auth::user();

        if (!$user->store || !$user->store->is_verified) {
            abort(403, 'Unauthorized access');
        }

        $transaction = Transaction::where('store_id', $user->store->id)
            ->findOrFail($id);

        $transaction->update([
            'tracking_number' => null,
        ]);

        return back()->with('success', 'Nomor resi berhasil dihapus!');
    }
}
