<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product.store')->get();
        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $qty = $request->quantity ?? 1;

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $qty);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update(['quantity' => $request->quantity]);

        if ($request->wantsJson()) {
            $itemTotal = $cart->product->price * $cart->quantity;
            
            // Recalculate grand total
            $grandTotal = Cart::where('user_id', Auth::id())->get()->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'item_total' => number_format($itemTotal, 0, ',', '.'),
                'grand_total' => number_format($grandTotal, 0, ',', '.'),
                'message' => 'Cart updated!'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product.store')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Group by Store
        $groupedItems = $cartItems->groupBy(function($item) {
            return $item->product->store_id;
        });

        $totalProductPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('groupedItems', 'totalProductPrice'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping' => 'required|array', // shipping[store_id]
        ]);

        $user = Auth::user();
        $buyer = $user->buyer;
        if (!$buyer) {
            $buyer = \App\Models\Buyer::create(['user_id' => $user->id]);
        }

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $groupedItems = $cartItems->groupBy('product.store_id');

        \Illuminate\Support\Facades\DB::transaction(function() use ($request, $groupedItems, $buyer) {
            foreach ($groupedItems as $storeId => $items) {
                
                // Calculate Store Totals
                $storeTotal = 0;
                foreach ($items as $item) {
                    $storeTotal += $item->product->price * $item->quantity;
                }

                // Shipping Cost Logic (Simplified per store)
                $shippingSelection = $request->shipping[$storeId] ?? 'JNE (Rp 15.000)';
                $shippingCost = 15000;
                if (str_contains($shippingSelection, '14.000')) $shippingCost = 14000;
                if (str_contains($shippingSelection, '13.000')) $shippingCost = 13000;

                $tax = $storeTotal * 0.11;
                $grandTotal = $storeTotal + $shippingCost + $tax;

                // Create Transaction
                $transaction = \App\Models\Transaction::create([
                    'buyer_id' => $buyer->id,
                    'store_id' => $storeId,
                    'code' => 'TRX-' . mt_rand(10000, 99999),
                    'address' => $request->address,
                    'address_id' => '0',
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'shipping' => $shippingSelection, // Assuming separate selection
                    'shipping_type' => 'REG',
                    'shipping_cost' => $shippingCost,
                    'tracking_number' => null,
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => 'paid',
                ]);

                // Create Details
                foreach ($items as $item) {
                    \App\Models\TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->quantity,
                        'subtotal' => $item->product->price * $item->quantity
                    ]);

                    // Decrement Stock
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Clear Cart
            Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->delete();
        });

        return redirect()->route('orders.history')->with('success', 'Checkout successful! Orders placed.');
    }
}
