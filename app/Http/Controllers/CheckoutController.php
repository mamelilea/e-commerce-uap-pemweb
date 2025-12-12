<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->with('product');
        
        if ($request->has('store_id')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('store_id', $request->store_id);
            });
            $storeId = $request->store_id; // Pass to view to keep context
        } else {
            $storeId = null;
        }

        $carts = $query->get();
        if ($carts->isEmpty()) return redirect()->route('cart.index')->with('error', 'Cart is empty');
        
        $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $tax = $subtotal * 0.11; // 11% tax
        // Simple shipping calculation
        $shipping_cost = 20000;
        $total = $subtotal + $tax + $shipping_cost;

        return view('checkout.index', compact('carts', 'subtotal', 'tax', 'shipping_cost', 'total', 'storeId'));
    }

    public function process(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|string', // e.g., REG, YES
            'payment_method' => 'required|in:wallet,va',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $query = \App\Models\Cart::where('user_id', $user->id)->with('product');

        if ($request->store_id) {
             $query->whereHas('product', function($q) use ($request) {
                $q->where('store_id', $request->store_id);
            });
        }

        $carts = $query->get();
        
        if ($carts->isEmpty()) return redirect()->route('home');

        $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $tax = $subtotal * 0.11;
        $shipping_cost = 20000; // Fixed for demo
        $grand_total = $subtotal + $tax + $shipping_cost;

        // Group by Store (Simpler: Assume single store per checkout or multiple transactions? Prompt says "Satu Toko". Let's assume items might be mixed, but for UAP probably single store or split. Let's assume single transaction for simplicity, picking store from first item or creating multiple if needed.
        // Prompt says "Transactions ... Store ID". So Transaction is per store.
        // I will group items by store.
        
        $grouped = $carts->groupBy(fn($c) => $c->product->store_id);

        foreach ($grouped as $storeId => $items) {
            $storeSubtotal = $items->sum(fn($c) => $c->product->price * $c->quantity);
            $storeTax = $storeSubtotal * 0.11;
            $storeTotal = $storeSubtotal + $storeTax + $shipping_cost; // Per store shipping? Let's assume yes.

            $code = 'TRX-' . time() . rand(100,999);

            $transaction = \App\Models\Transaction::create([
                'buyer_id' => $user->id,
                'store_id' => $storeId,
                'code' => $code,
                'address' => $request->address,
                'address_id' => rand(1,100), // Fake
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE', // Fake
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shipping_cost,
                'tracking_number' => null,
                'tax' => $storeTax,
                'grand_total' => $storeTotal,
                'payment_status' => 'unpaid',
            ]);

            foreach ($items as $item) {
                \App\Models\TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
                
                // Decrement stock?
                $item->product->decrement('stock', $item->quantity);
            }

            // Payment Logic
            if ($request->payment_method === 'wallet') {
                $balance = \App\Models\UserBalance::firstOrCreate(['user_id' => $user->id]);
                if ($balance->balance >= $storeTotal) {
                    $balance->decrement('balance', $storeTotal);
                    $transaction->update(['payment_status' => 'paid']);
                    
                    // Credit Store
                    $storeBalance = \App\Models\StoreBalance::firstOrCreate(['store_id' => $storeId]);
                    $storeBalance->increment('balance', $storeTotal);
                    
                     \App\Models\StoreBalanceHistory::create([
                          'store_balance_id' => $storeBalance->id,
                          'amount' => $storeTotal,
                          'type' => 'credit',
                          'reference_id' => $transaction->id,
                          'reference_type' => \App\Models\Transaction::class,
                          'description' => 'Sale ' . $transaction->code,
                     ]);
                } else {
                    return redirect()->back()->with('error', 'Insufficient Wallet Balance');
                }
            } else {
                // VA
                // Already created transaction with 'unpaid'. Code IS the VA.
            }
        }

        // Clear Cart
        \App\Models\Cart::whereIn('id', $carts->pluck('id'))->delete();

        return redirect()->route('history')->with('success', 'Order Placed!');
    }
}
