<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function getSellerStoreId()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store.register')->send();
        }

        return $store->id;
    }

    public function index()
    {
        $storeId = $this->getSellerStoreId();
        
        $transactions = Transaction::where('store_id', $storeId)
            ->with(['buyer.user', 'transactionDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.orders.index', compact('transactions'));
    }

    public function show($id)
    {
        $storeId = $this->getSellerStoreId();
        
        $transaction = Transaction::where('store_id', $storeId)
            ->with(['buyer.user', 'transactionDetails.product'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('transaction'));
    }

    public function confirm($id)
    {
        $storeId = $this->getSellerStoreId();
        $transaction = Transaction::where('store_id', $storeId)->findOrFail($id);

        if ($transaction->delivery_status !== 'pending' && !is_null($transaction->delivery_status)) {
            return redirect()->back()->with('error', 'Pesanan sudah diproses.');
        }

        $resi = 'WTC-' . $storeId . '-' . $transaction->id . '-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(6));

        $transaction->update([
            'tracking_number' => $resi,
            'delivery_status' => 'shipped'
        ]);

        return redirect()->back()->with('success', 'Pesanan sudah dikonfirmasi dan resi berhasil dibuat.');
    }

    public function reject($id)
    {
        $storeId = $this->getSellerStoreId();
        $transaction = Transaction::where('store_id', $storeId)->findOrFail($id);

        if ($transaction->delivery_status !== 'pending' && !is_null($transaction->delivery_status)) {
            return redirect()->back()->with('error', 'Pesanan sudah diproses.');
        }

        $transaction->update([
            'delivery_status' => 'canceled'
        ]);

        return redirect()->back()->with('success', 'Pesanan telah ditolak oleh seller.');
    }

    public function update(Request $request, $id)
    {
        $storeId = $this->getSellerStoreId();
        
        $transaction = Transaction::where('store_id', $storeId)->findOrFail($id);

        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $transaction->update([
            'tracking_number' => $request->tracking_number,
        ]);

        return redirect()->route('seller.orders.show', $transaction->id)
            ->with('success', 'Nomor resi berhasil diperbarui.');
    }
}
