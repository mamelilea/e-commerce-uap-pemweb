<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Buyer;
use App\Models\StoreBalance;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MyOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $buyer = Buyer::where('user_id', $user->id)->first();

        if (!$buyer) {
            return Inertia::render('MyOrder/Index', ['orders' => [], 'currentFilter' => 'all']);
        }

        $query = Transaction::with(['store', 'transactionDetails.product.productImages'])
            ->where('buyer_id', $buyer->id);

        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        $orders = $query->latest()->get();

        return Inertia::render('MyOrder/Index', [
            'orders' => $orders,
            'currentFilter' => $request->filter ?? 'all'
        ]);
    }

    public function show($code)
    {
        $user = Auth::user();
        $buyer = Buyer::where('user_id', $user->id)->first();

        $order = Transaction::with(['store', 'transactionDetails.product.productImages'])
            ->where('code', $code)
            ->where('buyer_id', $buyer->id)
            ->firstOrFail();

        $reviews = ProductReview::where('transaction_id', $order->id)->get();

        return Inertia::render('MyOrder/Detail', [
            'order' => $order,
            'existingReviews' => $reviews
        ]);
    }

    public function complete($code)
    {
        $transaction = Transaction::where('code', $code)->firstOrFail();

        if (!$transaction->tracking_number) {
            return back()->withErrors(['error' => 'Pesanan belum ada resi, tidak bisa diselesaikan.']);
        }
        
        if ($transaction->payment_status === 'done') {
            return back()->withErrors(['error' => 'Pesanan ini sudah selesai sebelumnya.']);
        }

        DB::transaction(function () use ($transaction) {
            
            $transaction->payment_status = 'done';
            $transaction->save(); 

            $sellerEarnings = $transaction->grand_total - $transaction->tax;

            $balance = StoreBalance::firstOrCreate(
                ['store_id' => $transaction->store_id],
                ['balance' => 0] 
            );
            
            $balance->increment('balance', $sellerEarnings);
        });

        return back()->with('success', 'Pesanan diterima! Dana telah diteruskan ke penjual.');
    }
}