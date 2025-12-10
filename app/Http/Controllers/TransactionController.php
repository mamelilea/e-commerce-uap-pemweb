<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping' => 'required|string',
        ]);

        $user = Auth::user();
        
        $shippingCost = 15000;
        if (str_contains($request->shipping, '14.000')) $shippingCost = 14000;
        if (str_contains($request->shipping, '13.000')) $shippingCost = 13000;
        
        $grandTotal = $product->price + $shippingCost;

        $buyer = $user->buyer;
        if (!$buyer) {
            $buyer = \App\Models\Buyer::create(['user_id' => $user->id]);
        }

        $transaction = Transaction::create([
            'buyer_id' => $buyer->id,
            'store_id' => $product->store_id,
            'code' => 'TRX-' . mt_rand(10000, 99999), 
            'address' => $request->address,
            'address_id' => '0',
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping' => $request->shipping,
            'shipping_type' => 'REG',
            'shipping_cost' => $shippingCost,
            'tracking_number' => null,
            'tax' => 0,
            'grand_total' => $grandTotal,
            'payment_status' => 'paid',
        ]);

        \App\Models\TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => 1,
            'subtotal' => $product->price
        ]);

        $product->decrement('stock', 1);

        return redirect()->route('orders.history')->with('success', 'Order placed successfully!');
    }

    public function complete(\App\Models\Transaction $transaction)
    {
        if ($transaction->buyer->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->delivery_status !== 'received') {
             $transaction->update(['delivery_status' => 'received']);
             
             $storeBalance = \App\Models\StoreBalance::firstOrCreate(
                ['store_id' => $transaction->store_id],
                ['balance' => 0]
            );
            $storeBalance->increment('balance', $transaction->grand_total);
        }

        return redirect()->route('reviews.create', $transaction->id)->with('success', 'Order received! Please rate your products.');
    }
}
