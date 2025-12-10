<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // Daftar pesanan user yang sedang login
    public function index()
    {
        $user = Auth::user();

        // Pastikan buyer profile ada
        $buyer = Buyer::where('user_id', $user->id)->first();

        if (! $buyer) {
            return redirect()->route('home')
                ->with('error', 'Kamu belum memiliki pesanan.');
        }

        $transactions = Transaction::with('store')
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('transactions'));
    }

    // Detail satu transaksi
    public function show(Transaction $transaction)
    {
        $user = Auth::user();
        $buyer = Buyer::where('user_id', $user->id)->first();

        // Cek kepemilikan transaksi
        if (! $buyer || $transaction->buyer_id !== $buyer->id) {
            abort(403, 'Kamu tidak berhak melihat transaksi ini.');
        }

        $transaction->load([
            'store',
            'buyer.user',
            'transactionDetails.product.productImages',
        ]);

        $itemsSubtotal = $transaction->transactionDetails->sum('subtotal');

        return view('orders.show', [
            'transaction'   => $transaction,
            'itemsSubtotal' => $itemsSubtotal,
        ]);
    }
    public function pay(Request $request, Transaction $transaction)
    {
        $user = Auth::user();
        $buyer = \App\Models\Buyer::where('user_id', $user->id)->first();

        // Cek kepemilikan transaksi
        if (! $buyer || $transaction->buyer_id !== $buyer->id) {
            abort(403, 'Kamu tidak berhak membayar transaksi ini.');
        }

        // Kalau sudah lunas, nggak perlu bayar lagi
        if ($transaction->payment_status === 'paid') {
            return redirect()
                ->route('orders.show', $transaction)
                ->with('success', 'Transaksi ini sudah dibayar.');
        }

        // Validasi metode pembayaran (simulasi)
        $data = $request->validate([
            'payment_method' => 'required|string|in:bank_transfer,ewallet,cod',
        ]);

        // Simulasi payment success:
        $transaction->update([
            'payment_status' => 'paid',
            'payment_method' => $data['payment_method'],
            'paid_at'        => now(),
        ]);

        return redirect()
            ->route('orders.show', $transaction)
            ->with('success', 'Pembayaran berhasil (simulasi). Terima kasih!');
    }
}
