<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:5|max:500',
        ]);

        $user = Auth::user();
        $buyer = Buyer::where('user_id', $user->id)->first();

        if (!$buyer) {
            return back()->withErrors(['review' => 'Anda belum terdaftar sebagai pembeli.']);
        }

        $alreadyReviewed = ProductReview::where('product_id', $request->product_id)
            ->whereHas('transaction', function ($q) use ($buyer) {
                $q->where('buyer_id', $buyer->id);
            })
            ->exists();

        if ($alreadyReviewed) {
            return back()->withErrors(['review' => 'Anda sudah memberikan ulasan untuk produk ini.']);
        }

        $transaction = Transaction::where('buyer_id', $buyer->id)
        ->whereIn('payment_status', ['paid', 'done'])
            ->whereHas('transactionDetails', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->latest()
            ->first();

        if (!$transaction) {
            return back()->withErrors(['review' => 'Anda harus membeli produk ini sebelum memberikan ulasan.']);
        }

        ProductReview::create([
            'transaction_id' => $transaction->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}