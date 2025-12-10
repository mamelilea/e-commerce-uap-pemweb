<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

        // CARI TRANSAKSI YANG PERNAH MEMBELI PRODUK INI
        // Asumsi: Product punya relasi transactionDetails()
        // dan TransactionDetail punya relasi transaction() yang punya user_id
        $transactionDetail = $product->transactionDetails()
            ->whereHas('transaction', function ($q) use ($user) {
                $q->where('buyer_id', $user->id);
            })
            ->latest()
            ->first();

        if (! $transactionDetail) {
            return back()->with('error', 'Anda belum pernah membeli produk ini sehingga belum dapat memberikan ulasan.');
        }

        $transaction = $transactionDetail->transaction;

        // ⛔ CEK: hanya boleh review jika SUDAH DIBAYAR
        if ($transaction->payment_status !== 'paid') {
            return back()->with('error', 'Kamu baru bisa memberi ulasan setelah pembayaran lunas.');
        }

        // ⛔ CEK apakah user sudah pernah review transaksi ini
        $alreadyReviewed = ProductReview::where('transaction_id', $transaction->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Kamu sudah memberi ulasan untuk pesanan ini.');
        }

        ProductReview::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'rating'         => $request->rating,
            'review'         => $request->review,
        ]);

        return back()->with('success', 'Terima kasih! Ulasanmu berhasil dikirim.');
    }
}
