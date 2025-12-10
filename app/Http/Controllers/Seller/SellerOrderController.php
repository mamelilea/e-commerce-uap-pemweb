<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan untuk toko milik seller yang login.
     * Bisa ditambah filter sederhana (status, search kode/nama buyer).
     */
    public function index(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            abort(403, 'Kamu belum memiliki toko.');
        }

        $query = Transaction::with([
                'buyer.user',
                'transactionDetails.product',
            ])
            ->where('store_id', $store->id)
            ->latest();

        // Filter status pembayaran (unpaid / paid)
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search berdasarkan kode transaksi atau nama/email buyer
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                    ->orWhereHas('buyer.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                                  ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('transactions'));
    }

    /**
     * Detail satu pesanan.
     */
    public function show(Transaction $transaction)
    {
        $store = Auth::user()->store;

        if (!$store || $transaction->store_id !== $store->id) {
            abort(403, 'Pesanan ini tidak termasuk dalam toko kamu.');
        }

        $transaction->load([
            'buyer.user',
            'transactionDetails.product',
        ]);

        return view('seller.orders.show', compact('transaction'));
    }

    /**
     * Update informasi pesanan:
     * - payment_status (unpaid / paid)
     * - shipping (ekspedisi)
     * - shipping_type (layanan)
     * - tracking_number (resi)
     */
    public function update(Request $request, Transaction $transaction)
    {
        $store = Auth::user()->store;

        if (!$store || $transaction->store_id !== $store->id) {
            abort(403, 'Pesanan ini tidak termasuk dalam toko kamu.');
        }

        $data = $request->validate([
            'shipping'        => ['required', 'string', 'max:255'],
            'shipping_type'   => ['required', 'string', 'max:255'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
            'payment_status'  => ['nullable', 'in:unpaid,paid'],
        ]);

        $transaction->update($data);

        return redirect()
            ->route('seller.orders.show', $transaction)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }
}
