<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle Buy Now button - redirect to checkout with product
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = \App\Models\Product::with('store.user')->findOrFail($productId);
        
        return view('frontend.checkout.index', compact('product', 'quantity'));
    }

    public function index(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Checkout Index Called', [
            'method' => $request->method(),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'all_data' => $request->all()
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Check if this is a direct product purchase (Buy Now)
        if ($productId) {
            $product = \App\Models\Product::with('store.user')->findOrFail($productId);
            return view('frontend.checkout.index', compact('product', 'quantity'));
        }

        // Otherwise, checkout from cart
        $cartItems = \App\Models\Cart::where('user_id', auth()->id())
                                     ->with('product.store.user')
                                     ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('frontend.checkout.cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'shipping_type' => 'required|in:regular,express',
            'payment_method' => 'required|in:wallet,va',
        ]);

        // Ensure buyer exists
        $userId = auth()->id();
        $buyer = \App\Models\Buyer::firstOrCreate(['user_id' => $userId]);

        // Check if this is from cart or single product
        if ($request->has('from_cart')) {
            // Checkout from cart
            $cartItems = \App\Models\Cart::where('user_id', auth()->id())
                                        ->with('product')
                                        ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            // Group cart items by store
            $itemsByStore = $cartItems->groupBy('product.store_id');

            // Calculate total for wallet validation
            $grandTotalAll = 0;
            foreach ($itemsByStore as $items) {
                $subtotal = $items->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });
                $grandTotalAll += $subtotal + 15000; // shipping per store
            }

            // If wallet payment, check and deduct balance
            if ($request->payment_method == 'wallet') {
                $userBalance = \App\Models\UserBalance::where('user_id', $userId)->first();
                
                if (!$userBalance || $userBalance->balance < $grandTotalAll) {
                    return redirect()->back()->with('error', 'Insufficient wallet balance. Please top up first.');
                }
                
                // Deduct balance
                $userBalance->balance -= $grandTotalAll;
                $userBalance->save();
                
                // Record wallet transaction
                \App\Models\WalletTransaction::create([
                    'user_id' => $userId,
                    'type' => 'payment',
                    'amount' => $grandTotalAll,
                    'description' => 'Payment for order',
                    'balance_before' => $userBalance->balance + $grandTotalAll,
                    'balance_after' => $userBalance->balance,
                ]);
            }

            // Create a transaction for each store
            foreach ($itemsByStore as $storeId => $items) {
                $subtotal = $items->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });
                $shippingCost = 15000;
                $totalAmount = $subtotal + $shippingCost;

                $transaction = new \App\Models\Transaction();
                $transaction->code = 'SMX-' . time() . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
                $transaction->user_id = $userId;
                $transaction->buyer_id = $buyer->id;
                $transaction->store_id = $storeId;
                $transaction->payment_method = $request->payment_method;
                $transaction->shipping_type = $request->shipping_type;
                $transaction->address = $request->address;
                $transaction->grand_total = $totalAmount;
                $transaction->shipping_cost = $shippingCost;
                
                // Set payment status based on method
                if ($request->payment_method == 'wallet') {
                    $transaction->payment_status = 'paid';
                } else {
                    $transaction->payment_status = 'unpaid';
                    $transaction->va_number = '8888' . rand(1000000000, 9999999999);
                }
                
                $transaction->save();

                // Save transaction details
                foreach ($items as $item) {
                    \App\Models\TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->quantity,
                        'subtotal' => $item->product->price * $item->quantity,
                    ]);
                }
            }

            // Clear the cart
            \App\Models\Cart::where('user_id', auth()->id())->delete();

        } else {
            // Single product checkout (Buy Now)
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = \App\Models\Product::findOrFail($request->product_id);
            $subtotal = $product->price * $request->quantity;
            $shippingCost = 15000;
            $totalAmount = $subtotal + $shippingCost;

            // If wallet payment, check and deduct balance
            if ($request->payment_method == 'wallet') {
                $userBalance = \App\Models\UserBalance::where('user_id', $userId)->first();
                
                if (!$userBalance || $userBalance->balance < $totalAmount) {
                    return redirect()->back()->with('error', 'Insufficient wallet balance. Please top up first.');
                }
                
                // Deduct balance
                $balanceBefore = $userBalance->balance;
                $userBalance->balance -= $totalAmount;
                $userBalance->save();
                
                // Record wallet transaction
                \App\Models\WalletTransaction::create([
                    'user_id' => $userId,
                    'type' => 'payment',
                    'amount' => $totalAmount,
                    'description' => 'Payment for order ' . $product->name,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $userBalance->balance,
                ]);
            }

            $transaction = new \App\Models\Transaction();
            $transaction->code = 'SMX-' . time() . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            $transaction->user_id = $userId;
            $transaction->buyer_id = $buyer->id;
            $transaction->store_id = $product->store_id;
            $transaction->payment_method = $request->payment_method;
            $transaction->shipping_type = $request->shipping_type;
            $transaction->address = $request->address;
            $transaction->grand_total = $totalAmount;
            $transaction->shipping_cost = $shippingCost;
            
            // Set payment status based on method
            if ($request->payment_method == 'wallet') {
                $transaction->payment_status = 'paid';
            } else {
                $transaction->payment_status = 'unpaid';
                $transaction->va_number = '8888' . rand(1000000000, 9999999999);
            }
            
            $transaction->save();
            
            // Save Detail
            \App\Models\TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $request->quantity,
                'subtotal' => $subtotal,
            ]);
        }
        
        return redirect()->route('history.index')->with('success', 'Order placed successfully!');
    }
}
