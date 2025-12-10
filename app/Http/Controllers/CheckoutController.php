<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index(Request $request)
    {
        $productId = $request->query('product');
        
        if (!$productId) {
            // Fallback for demo: use the first product (Samsung S23 Ultra) or redirect home
            $product = \App\Models\Product::first(); 
        } else {
            $product = \App\Models\Product::with('productImages')->findOrFail($productId);
        }

        $qty = $request->query('qty', 1);

        return view('user.checkout.index', compact('product', 'qty'));
    }

    // Memproses form checkout
    public function process(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'nama'       => 'required|string|max:255',
            'telepon'    => 'required|string|max:20',
            'alamat'     => 'required|string',
            'kota'       => 'required|string|max:100',
            'kodepos'    => 'required|string|max:10',
            'pengiriman' => 'required|string',
            'payment'    => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->qty;

        $ongkir = match($request->pengiriman) {
            'reguler' => 15000,
            'express' => 25000,
            'same-day' => 35000,
            default => 15000
        };

        $totalPrice = ($product->price * $qty) + $ongkir;

        // Ensure Buyer exists
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            $buyer = \App\Models\Buyer::firstOrCreate(['user_id' => $user->id]);
            $buyerId = $buyer->id;
        } else {
            // Fallback for guest (assuming ID 1 exists or handle accordingly)
            $buyerId = 1; 
        }

        $transaction = \App\Models\Transaction::create([
            'store_id' => $product->store_id ?? 1,
            'buyer_id' => $buyerId, 
            'code' => 'TRX-' . time() . '-' . rand(100, 999),
            'address' => $request->alamat,
            'address_id' => 'ADDR-' . time(),
            'city' => $request->kota,
            'postal_code' => $request->kodepos,
            'shipping' => $request->pengiriman,
            'shipping_type' => $request->pengiriman,
            'shipping_cost' => $ongkir,
            'tax' => 0,
            'grand_total' => $totalPrice,
            'payment_status' => 'paid', // Mark as paid after successful checkout
        ]);

        // Create Transaction Detail
        \App\Models\TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            // 'price' => $product->price, // TODO: Uncomment after adding price column to database
            'qty' => $qty,
            'subtotal' => $product->price * $qty,
        ]);

        // Redirect ke halaman sukses pembayaran
        return redirect()->route('checkout.success', ['order' => $transaction->id]);
    }

    // Halaman sukses pembayaran
    public function success($transactionId)
    {
        $transaction = \App\Models\Transaction::with('transactionDetails.product')->findOrFail($transactionId);
        return view('checkout.success', compact('transaction'));
    }
}
