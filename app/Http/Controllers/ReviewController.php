<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Transaction $transaction)
    {
        if ($transaction->buyer->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->delivery_status !== 'received') {
            return back()->with('error', 'You can only rate completed orders.');
        }

        return view('reviews.create', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return back()->with('success', 'Review submitted successfully!');
    }
}
