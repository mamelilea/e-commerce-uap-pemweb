<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Find Buyer record for this user
        $buyer = Buyer::where('user_id', $user->id)->first();

        if (!$buyer) {
            $transactions = collect(); // Empty collection if no buyer record
        } else {
            // Fetch transactions with details, products, and images - ordered by newest
            $transactions = $buyer->transactions()
                ->with(['transactionDetails.product.productImages'])
                ->latest()
                ->get();
        }

        return view('user.history.index', compact('transactions'));
    }
}
