<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        // Verify the transaction belongs to the user
        $transaction = Transaction::where('id', $request->transaction_id)
            ->whereHas('buyer', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->firstOrFail();

        // Verify the product is in the transaction
        $hasProduct = $transaction->transactionDetails()
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$hasProduct) {
            abort(403, 'Product not found in this transaction.');
        }

        // Check if review already exists
        $existingReview = ProductReview::where('transaction_id', $request->transaction_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        ProductReview::create([
            'transaction_id' => $request->transaction_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
