<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerOrderController extends Controller
{
    public const STATUSES = [
        'pending'    => 'Menunggu',
        'processing' => 'Diproses',
        'shipped'    => 'Dikirim',
        'completed'  => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ];

    public function index(Request $request)
    {
        $store = $request->user()->store()->firstOrFail();

        $transactions = $store->transactions()
            ->with([
                'buyer.user',
                'transactionDetails.product',
            ])
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', [
            'transactions'  => $transactions,
            'statusOptions' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $store = $request->user()->store()->firstOrFail();

        if ($transaction->store_id !== $store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status'           => ['required', Rule::in(array_keys(self::STATUSES))],
            'tracking_number'  => ['nullable', 'string', 'max:255'],
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('seller.orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}